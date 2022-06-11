<?php

namespace App\Services\Dashboard\User;


use App\Repositories\Dashboard\User\VendorRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;
use Illuminate\Validation\Rule;

class VendorService
{
    public static function getVendorsData(array $data)
    {
        return VendorRepository::getVendorsData($data);
    }

    public static function saveAddVendor(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'image' => 'required',
            'biography' => 'required',
            'price_from' => 'required|numeric',
            'price_to' => 'required|numeric|min:'.$data['price_from'],
            'category_id' => 'required',
            'phone' => 'required|unique:users',
            'city_id' => 'required',
        ];

        $messages = [
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
            'price_to.min' => 'Price to must be greater than price from',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorRepository::saveAddVendor($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }
    public static function saveEditVendor(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => ['required',Rule::unique('users')->ignore($data['id'], 'id')],
            //'password' => 'required',
            'image' => 'required',
            'biography' => 'required',
            'price_from' => 'required|numeric',
            'price_to' => 'required|numeric|min:'.$data['price_from'],
            'category_id' => 'required',
            'phone' => ['required',Rule::unique('users')->ignore($data['id'], 'id')],
            'city_id' => 'required',
        ];

        $messages = [
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
            'price_to.min' => 'Price to must be greater than price from',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = VendorRepository::saveEditVendor($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }
    public static function changeStatus(array $data)
    {
        $response = VendorRepository::changeStatus($data);
        return UtilsRepository::response($response,
            trans('admin.process_success_message'), trans('admin.success_title'));
    }

    public static function changeRequestStatus(array $data)
    {
        $response = VendorRepository::changeRequestStatus($data);
        return UtilsRepository::response($response,
            trans('admin.process_success_message'), trans('admin.success_title'));
    }

    public static function verifyVendor(array $data)
    {
        $response = VendorRepository::verifyVendor($data);
        return UtilsRepository::response($response,
            trans('admin.verify_success_message'), trans('admin.success_title'));
    }

    public static function getVendorPackagesData(array $data)
    {
        return VendorRepository::getVendorPackagesData($data);
    }

    public static function getVendorReviewsData(array $data)
    {
        return VendorRepository::getVendorReviewsData($data);
    }

    public static function getRequestsData(array $data)
    {
        return VendorRepository::getRequestsData($data);
    }

    public static function getSearchCategories(array $data)
    {
        $response = VendorRepository::getSearchCategories($data);
        return UtilsRepository::response($response);
    }

    public static function getCountryCities(array $data)
    {
        $response = VendorRepository::getCountryCities($data);
        return UtilsRepository::response($response);
    }

    public static function getVendorsReviewData(array $data)
    {
        return VendorRepository::getVendorsReviewData($data);
    }
}

?>
