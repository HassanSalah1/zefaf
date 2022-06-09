<?php

namespace App\Repositories\Api\Setting;

use App\Entities\HttpCode;
use App\Entities\Key;
use App\Http\Resources\CountryResource;
use App\Models\Setting\Country;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\App;

class SettingApiRepository
{

    // get About
    public static function getCountriesCities(array $data): array
    {
        $countries = Country::where(['is_deleted' => 0])->get();
        // return success response
        return [
            'data' => CountryResource::collection($countries),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getClientTerms(array $data)
    {
        $lang = App::getLocale();
        $setting = Setting::where(['key' => ($lang === 'en') ?
            Key::CLIENT_TERMS_EN : Key::CLIENT_TERMS_AR])->first();
        // return success response
        return [
            'data' => [
                'terms' => $setting ? $setting->value : null,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getVendorTerms(array $data)
    {
        $lang = App::getLocale();
        $setting = Setting::where(['key' => ($lang === 'en') ?
            Key::VENDOR_TERMS_EN : Key::VENDOR_TERMS_AR])->first();
        // return success response
        return [
            'data' => [
                'terms' => $setting ? $setting->value : null,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getSettings(array $data)
    {
        $setting = Setting::where(['key' => Key::SUPPORT])->first();
        $phone = Setting::where(['key' => Key::PHONE])->first();
        // return success response
        return [
            'data' => [
                'terms' => $setting ? $setting->value : null,
                'phone' => $phone ? $phone->value : null,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }
}
