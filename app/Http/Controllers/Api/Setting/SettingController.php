<?php

namespace App\Http\Controllers\Api\Setting;

use App\Entities\Key;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use App\Repositories\General\UtilsRepository;
use App\Services\Api\Setting\SettingApiService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //

    public function getCountriesCities(Request $request)
    {
        $data = $request->all();
        return SettingApiService::getCountriesCities($data);
    }

    public function getSettings(Request $request)
    {
        $data = $request->all();
        return SettingApiService::getSettings($data);
    }

    public function getClientTerms(Request $request)
    {
        $data = $request->all();
        return SettingApiService::getClientTerms($data);
    }

    public function getVendorTerms(Request $request)
    {
        $data = $request->all();
        return SettingApiService::getVendorTerms($data);
    }
}
