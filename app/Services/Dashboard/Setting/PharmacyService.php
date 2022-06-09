<?php
namespace App\Services\Dashboard\Setting;

use App\Repositories\Dashboard\Setting\PharmacyRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class PharmacyService
{


    public static function getPharmaciesData(array $data)
    {
        return PharmacyRepository::getPharmaciesData($data);
    }

    public static function addPharmacy(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'city_id' => 'required',
            'logo' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = PharmacyRepository::addPharmacy($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deletePharmacy(array $data)
    {
        $response = PharmacyRepository::deletePharmacy($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changePharmacy(array $data)
    {
        $response = PharmacyRepository::changePharmacy($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getPharmacyData(array $data)
    {
        $response = PharmacyRepository::getPharmacyData($data);
        return UtilsRepository::response($response);
    }

    public static function editPharmacy(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'city_id' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = PharmacyRepository::editPharmacy($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
