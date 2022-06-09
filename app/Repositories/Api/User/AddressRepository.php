<?php

namespace App\Repositories\Api\User;


use App\Entities\HttpCode;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressRepository
{

    public static function getAddresses(){
        $user = Auth::user();
        $addresses = $user->address();
        return [
            'data' => AddressResource::collection($addresses),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }


    public static function addAddress(array $data)
    {
        $addressData = [
            'user_id' => Auth::user()->id,
            'description' => (isset($data['description'])) ? $data['description'] : null,
            'street' => $data['street'],
            'building_number' => $data['building_number'],
            'floor_number' => $data['floor_number'],
            'flat_number' => $data['flat_number'],
            'area_id' => $data['area_id']
        ];
        $address = Address::create($addressData);
        if($address){
            return [
                'data' => AddressResource::collection($address),
                'message' => trans('api.add_address_success_message'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    public static function editAddress(array $data)
    {
        $filter = [
            'user_id' => Auth::user()->id,
            'id' => (isset($data['id'])) ? $data['id'] : null
        ];
        $address = Address::where($filter)->first();
        if($address){
            $addressData = [
                'description' => (isset($data['description'])) ? $data['description'] : null,
                'street' => $data['street'],
                'building_number' => $data['building_number'],
                'floor_number' => $data['floor_number'],
                'flat_number' => $data['flat_number'],
                'area_id' => $data['area_id']
            ];
            $address = $address->update($addressData);
            if($address){
                return [
                    'data' => AddressResource::collection($address),
                    'message' => trans('api.edit_address_success_message'),
                    'code' => HttpCode::SUCCESS
                ];
            }
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    public static function deleteAddress(array $data)
    {
        $filter = [
            'user_id' => Auth::user()->id,
            'id' => (isset($data['id'])) ? $data['id'] : null
        ];
        $address = Address::where($filter)->first();
        if($address){
            $address->update(['is_deleted' => 1]);
            return [
                'data' => $address,
                'message' => trans('api.edit_address_success_message'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

}
