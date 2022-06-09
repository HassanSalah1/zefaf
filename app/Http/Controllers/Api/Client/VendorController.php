<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Services\Api\Client\ActionService;
use App\Services\Api\Client\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    public function getVendors(Request $request)
    {
        $data = $request->all();
        return VendorService::getVendors($data);
    }

    public function getFavouriteVendors(Request $request)
    {
        $data = $request->all();
        return VendorService::getFavouriteVendors($data);
    }

    public function toggleFavourite(Request $request)
    {
        $data = $request->all();
        return VendorService::toggleFavourite($data);
    }

    public function getVendorDetails(Request $request , $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorService::getVendorDetails($data);
    }


    public function reviewFavourite(Request $request)
    {
        $data = $request->all();
        return VendorService::reviewFavourite($data);
    }

    public function getVendorReviews(Request $request , $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorService::getVendorReviews($data);
    }

    public function getVendorPackages(Request $request , $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorService::getVendorPackages($data);
    }


    public function clickVendorContact(Request $request)
    {
        $data = $request->all();
        return VendorService::clickVendorContact($data);
    }

}
