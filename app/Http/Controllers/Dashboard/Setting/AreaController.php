<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Country;
use App\Services\Dashboard\Setting\AreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AreaController extends Controller
{
    //
    public function showAreas()
    {
        $data['title'] = trans('admin.areas_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'areas';
        $data['debatable_names'] = array(trans('admin.name_arabic'), trans('admin.name_english'),
            trans('admin.country_name'), trans('admin.actions'));
        $data['governments'] = Country::where(['is_deleted' => 0])->get();
        return view('admin.setting.area')->with($data);
    }

    public function getAreasData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return AreaService::getAreasData($data);
    }

    public function addArea(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return AreaService::addArea($data);
    }

    public function deleteArea(Request $request)
    {
        $data = $request->all();
        return AreaService::deleteArea($data);
    }

    public function getAreaData(Request $request)
    {
        $data = $request->all();
        return AreaService::getAreaData($data);
    }

    public function editArea(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return AreaService::editArea($data);
    }

    public function changeArea(Request $request){
        $data = $request->all();
        return AreaService::changeArea($data);
    }

}
