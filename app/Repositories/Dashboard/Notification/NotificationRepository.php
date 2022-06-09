<?php

namespace App\Repositories\Dashboard\Notification;

use App\Entities\DeviceType;
use App\Entities\UserRoles;
use App\Models\User\Notification;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;

class NotificationRepository
{

    public static function sendNotification($data)
    {
        $users = User::where(function ($query) use ($data) {
            if (!isset($data['category_id']) || empty($data['category_id']) || $data['category_id'] === -1) {
                if (isset($data['all_vendors']) && $data['all_vendors'] === 'on') {
                    $query->where(['role' => UserRoles::VENDOR]);
                }
                if (isset($data['all_clients']) && $data['all_clients'] === 'on') {
                    $query->orWhere(['role' => UserRoles::CUSTOMER]);
                }
                if (isset($data['user_id']) && count($data['user_id']) > 0) {
                    $query->orWhereIn('id', $data['user_id']);
                }
                if (isset($data['vendor_id']) && count($data['vendor_id']) > 0) {
                    $query->orWhereIn('id', $data['vendor_id']);
                }
            }
            if (isset($data['city_id']) && !empty($data['city_id']) && $data['city_id'] === -1) {
                $query->where(['city_id' => $data['city_id']]);
            }
            $query->where([['role', '!=', UserRoles::ADMIN], ['role', '!=', UserRoles::EMPLOYEE]]);
        });
        if (isset($data['category_id']) && !empty($data['category_id']) && $data['category_id'] != -1) {
            $users = $users->join('vendors', 'vendors.user_id', '=', 'users.id')
                ->where(['category_id' => $data['category_id']]);
        }
        $users = $users->get(['users.id', 'lang', 'device_type', 'device_token']);

        if (count($users) === 0) {
            return false;
        }

        foreach ($users as $user) {
            $notification_obj = [
                'title_ar' => $data['title_ar'],
                'message_ar' => $data['message_ar'],
                'title_en' => $data['title_en'],
                'message_en' => $data['message_en'],
                'user_id' => $user->id,
//                'type' => NotificationType::Notify
            ];
            if ($user->device_token != null) {
                $notification_data = [
                    'title' => $notification_obj['title_' . $user->lang],
                    'message' => $notification_obj['message_' . $user->lang],
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $user->id,
                ]);
//                if ($user->device_type == DeviceType::IOS) {
//                    UtilsRepository::sendIosFCM($notification_data, $notification_data_obj, $user->device_token);
//                } else if ($user->device_type == DeviceType::ANDROID) {
                    UtilsRepository::sendAndroidFCM($notification_data_obj, $user->device_token);
//                }
            }
            Notification::create($notification_obj);
        }
        return true;
    }

}

?>
