<?php

namespace App\Services\Api\Vendor;

use App\Repositories\Api\Client\VendorRepository;
use App\Repositories\Api\Vendor\MembershipApiRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class MembershipApiService
{

    public static function getMemberships(array $data)
    {
        $response = MembershipApiRepository::getMemberships($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getMembershipDetails(array $data)
    {
        $response = MembershipApiRepository::getMembershipDetails($data);
        return UtilsRepository::handleResponseApi($response);
    }


}

?>
