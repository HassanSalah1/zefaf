<?php

namespace App\Services\Api\Home;

use App\Repositories\Api\Home\PharmacyApiRepository;
use App\Repositories\General\UtilsRepository;

class PharmacyApiService
{


    public static function getPharmacies(array $data)
    {
        $response = PharmacyApiRepository::getPharmacies($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getPharmacyData(array $data)
    {
        $response = PharmacyApiRepository::getPharmacyData($data);
        return UtilsRepository::handleResponseApi($response);
    }
}

?>
