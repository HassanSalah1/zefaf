<?php
namespace App\Services\Dashboard\Setting;

use App\Repositories\Dashboard\Setting\CountryRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class CountryService
{


    public static function getCountriesData(array $data)
    {
        return CountryRepository::getCountriesData($data);
    }

    public static function addCountry(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = CountryRepository::addCountry($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteCountry(array $data)
    {
        $response = CountryRepository::deleteCountry($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeCountry(array $data)
    {
        $response = CountryRepository::changeCountry($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getCountryData(array $data)
    {
        $response = CountryRepository::getCountryData($data);
        return UtilsRepository::response($response);
    }

    public static function editCountry(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = CountryRepository::editCountry($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
