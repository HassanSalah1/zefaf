<?php

namespace App\Services\Api\User;


use App\Repositories\Api\User\ChatApiRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class ChatApiService
{
    public static function sendMessage(array $data){
        $keys = [
            'member_id' => 'required',
        ];

        if(!$data['request']->hasFile('image')){
            $keys['message'] = 'required';
        }

        $validated = ValidationRepository::validateAPIGeneral($data, $keys);
        if ($validated !== true) {
            return $validated;
        }
        $response = ChatApiRepository::sendMessage($data);

        return UtilsRepository::handleResponseApi($response);
    }

    public static function getChats(array $data)
    {
        $response = ChatApiRepository::getChats($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getChatMessages(array $data)
    {
        $keys = [
            'member_id' => 'required',
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys);
        if ($validated !== true) {
            return $validated;
        }
        $response = ChatApiRepository::getChatMessages($data);
        return UtilsRepository::handleResponseApi($response);
    }

}