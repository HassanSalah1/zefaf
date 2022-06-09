<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\Setting\Membership;
use App\Models\User\User;
use App\Models\User\Vendors;
use App\Services\Dashboard\User\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    //

    public function showRequests(Request $request)
    {
        $data['title'] = 'requests';
        $data['active'] = 'requests';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['debatable_names'] = array('name' , 'phone' , 'category' , 'sub category' , 'new data' , trans('admin.actions'));
        return view('admin.user.requests')->with($data);
    }

    public function getRequestsData(Request $request)
    {
        $data = $request->all();
        return VendorService::getRequestsData($data);
    }

    public function addVendor(Request $request)
    {
        $data = $request->all();
        return VendorService::addVendor($data);
    }

    public function verifyVendor(Request $request)
    {
        $data = $request->all();
        return VendorService::verifyVendor($data);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        return VendorService::changeRequestStatus($data);
    }

    public function showVendorDetails($id, Request $request)
    {
        $vendor = User::where(['id' => $id, 'role' => UserRoles::VENDOR])
            ->first();

        if (!$vendor) {
            return redirect()->to('vendors');
        }

        $image = null;
        if ($vendor->images !== null) {
            $images = json_decode($vendor->images, true);
            $vendor->imagesArr = array_map(function ($image){
                return url($image);
            } , $images);
            $image = url($images[0]);
        }
        $vendor->image = $image;
        $city = City::where(['id' => $vendor->city_id])->first();
        $vendor->cityName = ($city) ? $city->name : null;
        $country = Country::where(['id' => ($city) ? $city->country_id : null])->first();
        $vendor->countryName = ($country) ? $country->name : null;

        $vendorObj = Vendors::where(['user_id' => $vendor->id])
            ->select(DB::raw("DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY)) AS end_membership_date"),
                'user_id', 'biography', 'category_id', 'from_price'
                , 'to_price', 'membership_id', 'membership_duration', 'membership_date'
                , 'category_questions', 'website', 'instagram', 'facebook')
            ->first();
        $category = Category::where(['id' => $vendorObj->category_id])->first();
        $vendorObj->category = $category;
        $membership = Membership::where(['id' => $vendorObj->membership_id])->first();
        $vendorObj->membership = $membership;
        if($vendorObj->category_questions !== null){
            $vendorObj->category_questions = json_decode($vendorObj->category_questions , true);
        }
        $vendor->vendor = $vendorObj;

        $data['locale'] = App::getLocale();
        $data['userProfile'] = $vendor;
        $data['title'] = trans('admin.vendor_details_title') . ' - ' . $vendor->name;
        $data['active'] = '';
        $data['user'] = auth()->user();
        return view('admin.user.vendor_profile')->with($data);
    }


    public function getVendorPackagesData(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorService::getVendorPackagesData($data);
    }

    public function getVendorReviewsData(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return VendorService::getVendorReviewsData($data);
    }
}
