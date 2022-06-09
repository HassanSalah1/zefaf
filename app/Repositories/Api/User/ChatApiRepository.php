<?php

namespace App\Repositories\Api\User;


use App\Entities\HttpCode;
use App\Entities\ProductType;
use App\Models\User\Chat\Chat;
use App\Models\User\Chat\Message;
use App\Models\User\FollowList;
use App\Models\User\User;
use App\Models\User\UserInformation;
use App\Repositories\General\UtilsRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ChatApiRepository
{

    public static function sendMessage(array $data)
    {
        $user = User::where(['id' => $data['member_id']])->first();
        $blockList = FollowList::isBlocked($data, $user)->first();
        if (!$blockList) {
            $chat = Chat::isExistChat($data, $user)->first();
            $image = null;
            if ($data['request']->hasFile('image')) {
                $file_id = 'msg_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
                $image = UtilsRepository::createImage($data['request'],
                    'image',
                    'uploads/chats/', $file_id);
                if ($image === false) {
                    return [
                        'message' => trans('api.upload_error_message'),
                        'code' => HttpCode::ERROR
                    ];
                }
            }
            if ($chat) {
                // send message
                $messageData = [
                    'chat_id' => $chat->id,
                    'sender_id' => $data['user']->id,
                    'message' => (isset($data['message'])) ? $data['message'] : null,
                    'image' => $image
                ];
                $message = Message::create($messageData);
            } else {
                // create chat
                $chatData = [
                    'creator_id' => $data['user']->id,
                    'member_id' => $user->id
                ];
                $chat = Chat::create($chatData);
                // send message
                $messageData = [
                    'chat_id' => $chat->id,
                    'sender_id' => $data['user']->id,
                    'message' => (isset($data['message'])) ? $data['message'] : null,
                    'image' => $image
                ];
                $message = Message::create($messageData);
            }

            if ($message) {
                $userInformation = UserInformation::where(['user_id' => $data['member_id']])->first();

                $sender = User::join('user_informations', 'users.id', '=', 'user_informations.user_id')
                    ->where(['users.id' => $data['user']->id])
                    ->first(['users.id', 'users.name', 'user_informations.image']);
                $messageData = [
                    'user' => [
                        'id' => $sender->id,
                        'name' => $sender->name,
                        'image' => $userInformation->image
                    ],
                    'chat_id' => $message->chat_id,
                    'sender' => 0,
                    'message' => $message->message,
                    'image' => ($message->image !== null) ? url($message->image) : null,
                    'date' => date('j M Y', strtotime($message->created_at)),
                    'time' => date('h:i a', strtotime($message->created_at))
                ];
                // send notification
                $user->device_token = $userInformation->device_token;
                $user->device_type = $userInformation->device_type;
                $notification_obj = [
                    'title_key' => 'notification_new_message_title',
                    'message_key' => 'notification_new_message_message',
                    'user_id' => $user->id,
                    'message_id' => $message->id,
                    'type' => ProductType::CHAT
                ];
                $notification_data = [
                    'title' => trans('api.' . $notification_obj['title_key']),
                    'message' => str_replace(
                        ['{name}', '{message}'],
                        [
                            $sender->name,
                            (isset($data['message']) && $data['message'] !== null) ? $data['message'] : trans('api.image'),
                        ],
                        trans('api.' . $notification_obj['message_key'])
                    )
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $user->id,
                    'type' => ProductType::CHAT,
                    'message_data' => $messageData
                ]);
                UtilsRepository::sendNotification($user, $notification_obj, $notification_data
                    , $notification_data_obj);
                $messageData['sender'] = 1;
                return [
                    'data' => $messageData,
                    'message' => 'success',
                    'code' => HttpCode::SUCCESS
                ];
            }
        }

        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    public static function getChats(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $chats = Chat::join('messages', 'messages.chat_id', '=', 'chats.id')
            ->where(function ($query) use ($data) {
                $query->where(['chats.creator_id' => $data['user']->id]);
                $query->orWhere(['chats.member_id' => $data['user']->id]);
            });
        $count = $chats->distinct()->get(['chats.id'])->count();

        $chats = $chats->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->distinct()
            ->get(['chats.id', 'chats.creator_id', 'chats.member_id'])
            ->each(function ($chat) use ($data) {
                if ($data['user']->id === $chat->creator_id) {
                    $userId = $chat->member_id;
                    unset($chat->creator_id);
                } else {
                    $userId = $chat->creator_id;
                    $chat->member_id = $chat->creator_id;
                    unset($chat->member_id);
                    unset($chat->creator_id);
                }
                $chat->user = User::join('user_informations', 'users.id', '=', 'user_informations.user_id')
                    ->where(['users.id' => $userId])->first(['users.id', 'name', 'image']);
                $chat->user->image = ($chat->user->image !== null) ? url($chat->user->image) : null;
                $chat->messages = Message::where(['chat_id' => $chat->id])
                    ->orderBy('id', 'DESC')
                    ->first(['message', 'image', 'created_at']);

                if ($chat->messages) {
                    $chat->messages->date = date('j M Y', strtotime($chat->messages->created_at));
                    $chat->messages->time = date('h:i a', strtotime($chat->messages->created_at));
                    $chat->messages->image = ($chat->messages->image !== null) ?
                        url($chat->messages->image) : null;
                }
            });
        $utils = new UtilsRepository();
        $chats = $utils->sortByDate(collect($chats)->toArray());
        $chats = new Paginator($chats, $count, $per_page);
        return [
            'data' => $chats,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getChatMessages(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $user = User::where(['id' => $data['member_id']])->first();
        $chat = Chat::isExistChat($data, $user)->first();
        if ($chat) {
            $messages = Message::where(['chat_id' => $chat->id])
                ->orderBy('id', 'DESC');
            $count = $messages->count();
            $messages = $messages->offset($offset)
                ->skip($offset)
                ->take($per_page)
                ->get(['sender_id', 'message', 'image' , 'created_at'])
                ->each(function ($message) use ($data) {
                    $user = User::join('user_informations' , 'user_informations.user_id' , '=' , 'users.id')
                        ->where(['users.id' => $message->sender_id])
                        ->first(['users.id' , 'users.name' , 'user_informations.image']);
                    $message->user = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => ($user->image !== null) ? url($user->image) : null
                    ];
                    $message->sender = ($data['user']->id == $message->sender_id) ? 1 : 0;
                    $message->date = date('j M Y', strtotime($message->created_at));
                    $message->time = date('h:i a', strtotime($message->created_at));
                    $message->image = ($message->image !== null) ?
                        url($message->image) : null;
                });

            $chats = new Paginator(array_reverse($messages->toArray()), $count, $per_page);
            return [
                'data' => $chats,
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

}

//  69310703

