<?php

namespace App\Services\Api\General;

use App\Model\User\Contact;
use App\Repositories\Api\General\GeneralRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class GeneralService
{

    public static function getHome(array $data){
        $response =  GeneralRepository::getHome($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getAdConstants(array $data){
        $response =  GeneralRepository::getAdConstants($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function uploadMedia(array $data){
        $keys = [
            'file' => 'required',
            'type' => 'required',
            'ad_id' => 'required'
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys , $messages);
        if ($validated !== true) {
            return $validated;
        }

        $response =  GeneralRepository::uploadMedia($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getFiles(array $data){
        return GeneralRepository::getFiles($data);
    }

    public static function contact(array $data){
        $keys = [
            'title' => 'required',
            'message' => 'required',
        ];

        if(!$data['user']){
            $keys = array_merge($keys , [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);
        }

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys , $messages);
        if ($validated !== true) {
            return $validated;
        }

        $response =  GeneralRepository::contact($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>