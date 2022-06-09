<?php

namespace App\Services\Api\Home;

use App\Repositories\Api\Home\EventApiRepository;
use App\Repositories\General\UtilsRepository;

class EventApiService
{
    public static function getDates()
    {
        $response = EventApiRepository::getDates();
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getEvents(array $data)
    {
        $response = EventApiRepository::getEvents($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getEventData(array $data)
    {
        $response = EventApiRepository::getEventData($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>
