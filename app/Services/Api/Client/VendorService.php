<?php

namespace App\Services\Api\Client;

use App\Repositories\Api\Client\VendorRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class VendorService
{

    public static function getVendors(array $data)
    {
        $response = VendorRepository::getVendors($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function toggleFavourite(array $data)
    {
        $keys = [
            'vendor_id' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorRepository::toggleFavourite($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getVendorDetails(array $data)
    {
        $response = VendorRepository::getVendorDetails($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function reviewFavourite(array $data)
    {
        $keys = [
            'vendor_id' => 'required',
            'rate' => 'required',
            'is_help' => 'required',
            'name' => 'required'
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorRepository::reviewFavourite($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getVendorReviews(array $data)
    {
        $response = VendorRepository::getVendorReviews($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getVendorPackages(array $data)
    {
        $response = VendorRepository::getVendorPackages($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function clickVendorContact(array $data)
    {
        $keys = [
            'vendor_id' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorRepository::clickVendorContact($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getFavouriteVendors(array $data)
    {
        $response = VendorRepository::getFavouriteVendors($data);
        return UtilsRepository::handleResponseApi($response);
    }

}

?>
