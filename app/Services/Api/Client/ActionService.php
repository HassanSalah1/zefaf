<?php

namespace App\Services\Api\Client;

use App\Repositories\Api\Client\ActionRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class ActionService
{

    public static function setWeddingDate(array $data)
    {
        $response = ActionRepository::setWeddingDate($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getWeddingDate(array $data)
    {
        $response = ActionRepository::getWeddingDate($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getCategoryTips(array $data)
    {
        $keys = [
            'keyword' => 'required',
        ];

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = ActionRepository::getCategoryTips($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getCategories(array $data)
    {
        $response = ActionRepository::getCategories($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getSubCategories(array $data)
    {
        $keys = [
            'category_id' => 'required',
        ];

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = ActionRepository::getSubCategories($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function clickCategories(array $data)
    {
        $keys = [
            'category_id' => 'required',
        ];

        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = ActionRepository::clickCategories($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>
