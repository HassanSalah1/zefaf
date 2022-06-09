<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Api\Vendor\MembershipApiService;
use Illuminate\Http\Request;

class MembershipController extends Controller
{

    public function getMemberships(Request $request)
    {
        $data = $request->all();
        return MembershipApiService::getMemberships($data);
    }

    public function getMembershipDetails(Request $request , $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return MembershipApiService::getMembershipDetails($data);
    }
}
