<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Api\Vendor\VendorActionsService;
use Illuminate\Http\Request;

class VendorActionsController extends Controller
{

    public function startFreeTrial(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::startFreeTrial($data);
    }

    public function getMyPackages(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::getMyPackages($data);
    }

    public function addPackage(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::addPackage($data);
    }


    public function editPackage(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorActionsService::editPackage($data);
    }


    public function deletePackage(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorActionsService::deletePackage($data);
    }

    public function upload(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return VendorActionsService::upload($data);
    }

    public function removeImage(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorActionsService::removeImage($data);
    }

    public function getProfile(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::getProfile($data);
    }

    public function editProfile(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::editProfile($data);
    }

    public function getMyReviews(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::getMyReviews($data);
    }

    public function getStatistics(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::getStatistics($data);
    }

    public function renewPackage(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::renewPackage($data);
    }


    public function handlePayment(Request $request)
    {
        if ($request->has('key')) {
            $data['token'] = $request->key;
            return view('payment')->with($data);
        }
    }


    public function handlePaymentWallet(Request $request)
    {
        if ($request->has('iframe')) {
            $data['iframe'] = $request->iframe;
            return view('payment_wallet')->with($data);
        }
    }

    public function post_pay(Request $request)
    {
        $data = $request->all();
        return VendorActionsService::post_pay($data);
    }

    public function payment_error(Request $request)
    {
        return view('payment_error');
    }

}
