<?php

namespace App\Services\Dashboard\User;


use App\Repositories\Dashboard\User\UserRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class UserService
{
    public static function getUsersData(array $data)
    {
        return UserRepository::getUsersData($data);
    }

    public static function addUser(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
            'country_id' => 'required',
            'city_id' => 'required'
        ];
        $messages = [
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = UserRepository::addUser($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function changeStatus(array $data)
    {
        $response = UserRepository::changeStatus($data);
        return UtilsRepository::response($response,
            trans('admin.process_success_message'), trans('admin.success_title'));
    }

    public static function verifyUser(array $data)
    {
        $response = UserRepository::verifyUser($data);
        return UtilsRepository::response($response,
            trans('admin.verify_success_message'), trans('admin.success_title'));
    }

    public static function showUserFavouritesData(array $data)
    {
        return UserRepository::showUserFavouritesData($data);
    }

    public static function getCountryCities(array $data)
    {
        $response =  UserRepository::getCountryCities($data);
        return UtilsRepository::response($response, '' , '');
    }
}

?>
