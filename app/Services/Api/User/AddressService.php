<?php

namespace App\Services\Api\User;


use App\Repositories\Api\User\AddressRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class AddressService
{


    public static function addAddress(array $data)
    {
        $keys = [
            'street' => 'required',
            'building_number' => 'required',
            'floor_number' => 'required',
            'flat_number' => 'required',
            'area_id' => 'required'
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys);
        if ($validated !== true) {
            return $validated;
        }
        $response = AddressRepository::addAddress($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function editAddress(array $data)
    {
        $keys = [
            'street' => 'required',
            'building_number' => 'required',
            'floor_number' => 'required',
            'flat_number' => 'required',
            'area_id' => 'required'
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys);
        if ($validated !== true) {
            return $validated;
        }
        $response = AddressRepository::editAddress($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function deleteAddress(array $data)
    {
        $response = AddressRepository::deleteAddress($data);
        return UtilsRepository::handleResponseApi($response);
    }

}
