<?php

namespace App\Repositories\Api\User;


use App\Entities\HttpCode;
use App\Http\Resources\NotificationResource;
use App\Models\User\Notification;
use App\Repositories\Api\Auth\AuthApiRepository;
use App\Repositories\General\UtilsRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class UserApiRepository
{

    public static function getMyNotifications(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);
        Notification::where(['user_id' => auth()->user()->id , 'read' => 0])->update(['read' => 1]);
        $notifications = Notification::where(['user_id' => auth()->user()->id])
            ->orderBy('id', 'desc');
        $count = $notifications->count();

        $notifications = $notifications->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->get();
        $notifications = new Paginator(NotificationResource::collection($notifications), $count, $per_page);
        return [
            'data' => $notifications,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getProfile(array $data)
    {
        $user = auth()->user();
        return [
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'edit_email' => $user->edit_email,
                'is_verified' => ($user->edit_email !== null) ? false : true,
                'image' => ($user->image !== null) ? url($user->image) : null,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function updateUserData(array $data)
    {
        $userData = [
            'name' => (isset($data['name'])) ? $data['name'] : $data['user']->name,
            'edit_email' => (isset($data['email']) && $data['email'] !== $data['user']->email) ?
                $data['email'] : null,
                'phone' => (isset($data['phone'])) ? $data['phone'] : $data['user']->phone,
                'address' => (isset($data['address'])) ? $data['address'] : $data['user']->address,
                'image' => (isset($data['image'])) ? $data['image'] : $data['user']->image,
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $userData['password'] = $data['password'];
        }
        // $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        // $image_name = 'image';
        // $image_path = 'uploads/users/';
        // $userData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
        // if ($userData['image'] === false) {
        //     unset($userData['image']);
        // } else {
        //     if ($data['user']->image !== null && file_exists($data['user']->image)) {
        //         unlink($data['user']->image);
        //     }
        // }

        if($userData['edit_email'] !== null){
            $is_sent = AuthApiRepository::sendVerificationCode($data['user']);
        }

        $data['user']->update($userData);

        //AuthApiRepository::sendVerificationCode($data['user']);
        return [
            'data' => [
                'name' => $data['user']->name,
                'address' => $data['user']->address,
                'phone' => $data['user']->phone,
                'email' => $data['user']->email,
                'edit_email' => $data['user']->edit_email,
                'is_verified' => ($data['user']->edit_email !== null) ? false : true,
                'image' => ($data['user']->image !== null) ? url($data['user']->image) : null,
            ],
            'message' => trans('api.done_successfully'),
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getSetting(array $data)
    {
        $user = auth()->user();
        return [
            'data' => [
                'notification' => $user->notification,
                'lang' => $user->lang,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function editSetting(array $data)
    {
        $userData = [
            'notification' => (isset($data['notification'])) ?
                $data['notification'] : $data['user']->notification,
            'lang' => (isset($data['lang'])) ?
                $data['lang'] : $data['user']->lang,
        ];
        $data['user']->update($userData);
        return [
            'data' => [
                'notification' => $data['user']->notification,
                'lang' => $data['user']->lang,
            ],
            'message' => trans('api.done_successfully'),
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getMyNotificationsCount(array $data)
    {
        $user = auth()->user();
        return [
            'data' => [
                'notifications_count' => Notification::where(['user_id' => $user->id , 'read' => 0])->count()
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }
}
