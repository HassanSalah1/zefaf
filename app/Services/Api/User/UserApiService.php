<?php

namespace App\Services\Api\User;


use App\Entities\HttpCode;
use App\Entities\UserRoles;
use App\Repositories\Api\User\UserApiRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;
use Illuminate\Support\Facades\Hash;

class UserApiService
{


    public static function myCurrentJourney(array $data)
    {
        $response = UserApiRepository::myCurrentJourney($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function renewJourney(array $data)
    {
        $response = UserApiRepository::renewJourney($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function makeJourneyLapTest(array $data)
    {
        $keys = [
            'lap_test_id' => 'required',
            'address' => 'required',
            'requested_date' => 'required',
            'from' => 'required',
            'to' => 'required'
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = UserApiRepository::makeJourneyLapTest($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getJourneyLapTest(array $data)
    {
        $response = UserApiRepository::getJourneyLapTest($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function makeJourneyProductDelivery(array $data)
    {
        $keys = [
            'product_id' => 'required',
            'address' => 'required',
            'requested_date' => 'required',
            'packets_number' => 'required'
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = UserApiRepository::makeJourneyProductDelivery($data);
        return UtilsRepository::handleResponseApi($response);
    }
    public static function getJourneyProductDelivery(array $data)
    {
        $response = UserApiRepository::getJourneyProductDelivery($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function makeJourneyNurseVisit(array $data)
    {
        $keys = [
            'address' => 'required',
            'requested_date' => 'required',
            'from' => 'required',
            'to' => 'required'
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = UserApiRepository::makeJourneyNurseVisit($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getJourneyNurseVisit(array $data)
    {
        $response = UserApiRepository::getJourneyNurseVisit($data);
        return UtilsRepository::handleResponseApi($response);
    }

    //////////////////////////////////////////////////////////////

    public static function getUserData(array $data)
    {
        $response = UserApiRepository::getUserData($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function updateUserData(array $data)
    {
        $keys = [
            'email' => 'email',
        ];
        if (isset($data['role'])) {
            $keys['role'] = 'in:' . implode(',', UserRoles::getUserKeys());
        }
        if (isset($data['email']) && $data['user']->email !== $data['email']) {
            $keys['email'] .= '|unique:users';
        }

        if (isset($data['phone']) && $data['user']->phone !== $data['phone']) {
            $keys['phone'] = 'unique:users';
        }

        if (isset($data['verification_number']) || isset($data['verification_image'])) {
            $keys = array_merge($keys, [
                'verification_number' => 'required',
                'verification_image' => 'required',
            ]);
        }

        if (isset($data['password']) || isset($data['old_password'])) {
            $keys = [
                'password' => 'required',
                'old_password' => 'required',
            ];
        }
        $messages = [
            'required' => trans('api.required_error_message'),
            'email.email' => trans('api.valid_email_error_message'),
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
            'role.in' => trans('api.role_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        if (isset($data['password']) && isset($data['old_password'])) {
            if (Hash::check($data['old_password'], $data['user']->password)) {
                $data['password'] = bcrypt($data['password']);
                unset($data['old_password']);
            } else {
                return UtilsRepository::handleResponseApi([
                    'message' => trans('api.old_password_message'),
                    'code' => HttpCode::ERROR
                ]);
            }
        }
        $response = UserApiRepository::updateUserData($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getUserProfile(array $data)
    {
        $response = UserApiRepository::getUserProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }


    public static function getMyNotifications(array $data)
    {
        $response = UserApiRepository::getMyNotifications($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getProfile(array $data)
    {
        $response = UserApiRepository::getProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function editProfile(array $data)
    {
        $keys = [];
        if (isset($data['email']) && $data['user']->email !== $data['email']) {
            $keys['email'] = 'unique:users';
        }
        $messages = [
            'required' => trans('api.required_error_message'),
            'email.unique' => trans('api.email_unique_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        if (isset($data['password']) && isset($data['old_password'])) {
            if (Hash::check($data['old_password'], $data['user']->password)) {
                $data['password'] = bcrypt($data['password']);
                unset($data['old_password']);
            } else {
                return UtilsRepository::handleResponseApi([
                    'message' => trans('api.old_password_message'),
                    'code' => HttpCode::ERROR
                ]);
            }
        }
        $response = UserApiRepository::editProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getSetting(array $data)
    {
        $response = UserApiRepository::getSetting($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function editSetting(array $data)
    {
        $response = UserApiRepository::editSetting($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getMyNotificationsCount(array $data)
    {
        $response = UserApiRepository::getMyNotificationsCount($data);
        return UtilsRepository::handleResponseApi($response);
    }
}
