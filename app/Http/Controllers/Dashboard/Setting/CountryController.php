<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Setting\CountryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CountryController extends Controller
{
    //
    public function showCountries()
    {
        $data['title'] = trans('admin.countries_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'countries';
        $data['debatable_names'] = array(trans('admin.name_arabic'), trans('admin.name_english'),
            trans('admin.actions'));
        return view('admin.setting.country')->with($data);
    }

    public function getCountriesData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return CountryService::getCountriesData($data);
    }

    public function addCountry(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return CountryService::addCountry($data);
    }

    public function deleteCountry(Request $request)
    {
        $data = $request->all();
        return CountryService::deleteCountry($data);
    }

    public function getCountryData(Request $request)
    {
        $data = $request->all();
        return CountryService::getCountryData($data);
    }

    public function editCountry(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return CountryService::editCountry($data);
    }

    public function changeCountry(Request $request){
        $data = $request->all();
        return CountryService::changeCountry($data);
    }

}
