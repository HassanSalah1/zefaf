<?php

namespace App\Services\Api\Vendor;

use App\Repositories\Api\Vendor\VendorActionsRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class VendorActionsService
{

    public static function startFreeTrial(array $data)
    {
        $response = VendorActionsRepository::startFreeTrial($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getMyPackages(array $data)
    {
        $response = VendorActionsRepository::getMyPackages($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function addPackage(array $data)
    {
        $keys = [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorActionsRepository::addPackage($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function editPackage(array $data)
    {
        $keys = [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorActionsRepository::editPackage($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function deletePackage(array $data)
    {
        $response = VendorActionsRepository::deletePackage($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getProfile(array $data)
    {
        $response = VendorActionsRepository::getProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function editProfile(array $data)
    {
        $user = auth()->user();
        $keys = [];

        if (isset($data['phone']) && $data['phone'] !== $user->phone) {
            $keys['phone'] = 'unique:users';
        }
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $keys['email'] = 'unique:users';
        }

        $messages = [
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorActionsRepository::editProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getMyReviews(array $data)
    {
        $response = VendorActionsRepository::getMyReviews($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getStatistics(array $data)
    {
        $response = VendorActionsRepository::getStatistics($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function renewPackage(array $data)
    {

        $keys = [
            'package_id' => 'required',
            'duration' => 'required',
            'type'=>'required|in:cart,wallet'
        ];

        $validated = ValidationRepository::validateAPIGeneral($data, $keys);


        if ($validated !== true) {
            return $validated;
        }

        $response = VendorActionsRepository::renewPackage($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function post_pay(array $data)
    {
        $response = VendorActionsRepository::post_pay($data);
        return $response;
    }

    public static function upload(array $data)
    {
        $keys = [
            'image' => 'required',
        ];

        $validated = ValidationRepository::validateAPIGeneral($data, $keys);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorActionsRepository::upload($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function removeImage(array $data)
    {
        $response = VendorActionsRepository::removeImage($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>
