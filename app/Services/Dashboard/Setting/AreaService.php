<?php
namespace App\Services\Dashboard\Setting;

use App\Repositories\Dashboard\Setting\AreaRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class AreaService
{


    public static function getAreasData(array $data)
    {
        return AreaRepository::getAreasData($data);
    }

    public static function addArea(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'country_id' => 'required'
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = AreaRepository::addArea($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteArea(array $data)
    {
        $response = AreaRepository::deleteArea($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeArea(array $data)
    {
        $response = AreaRepository::changeArea($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getAreaData(array $data)
    {
        $response = AreaRepository::getAreaData($data);
        return UtilsRepository::response($response);
    }

    public static function editArea(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'country_id' => 'required'
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = AreaRepository::editArea($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
