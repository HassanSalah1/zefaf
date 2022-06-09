<?php

namespace App\Services\Api\Setting;

use App\Repositories\Api\Setting\SettingApiRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class SettingApiService
{

    public static function getCountriesCities(array $data)
    {
        $response = SettingApiRepository::getCountriesCities($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getClientTerms(array $data)
    {
        $response = SettingApiRepository::getClientTerms($data);
        return UtilsRepository::handleResponseApi($response);
    }


    public static function getVendorTerms(array $data)
    {
        $response = SettingApiRepository::getVendorTerms($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getSettings(array $data)
    {
        $response = SettingApiRepository::getSettings($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>
