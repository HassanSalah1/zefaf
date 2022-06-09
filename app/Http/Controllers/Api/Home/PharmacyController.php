<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Services\Api\Home\PharmacyApiService;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    //

    public function getPharmacies(Request $request)
    {
        $data = $request->all();
        return PharmacyApiService::getPharmacies($data);
    }

    public function getPharmacyData(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return PharmacyApiService::getPharmacyData($data);
    }
}
