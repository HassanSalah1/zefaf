<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Models\City;
use App\Models\Pharmacy;
use App\Models\Province;
use App\Services\Dashboard\Setting\PharmacyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PharmacyController extends Controller
{
    //
    public function showPharmacies()
    {
        $data['title'] = trans('admin.pharmacies_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'pharmacies';
        $data['debatable_names'] = array(trans('admin.name_arabic'), trans('admin.name_english'),
            trans('admin.logo'), trans('admin.actions'));
        return view('admin.pharmacy.index')->with($data);
    }

    public function getPharmaciesData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return PharmacyService::getPharmaciesData($data);
    }

    public function showAddPharmacy()
    {
        $data['title'] = trans('admin.add_pharmacy');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'pharmacies';
        $data['governments'] = Province::get();
        $data['cities'] = (count($data['governments']) > 0) ?
            City::where(['province_id' => $data['governments'][0]->id])->get() : [];
        return view('admin.pharmacy.add_pharmacy')->with($data);
    }

    public function getAreas(Request $request)
    {
        $areas = City::where(['province_id' => $request->government_id])
            ->get();
        return response()->json([
            'areas' => AreaResource::collection($areas)
        ]);
    }

    public function addPharmacy(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return PharmacyService::addPharmacy($data);
    }

    public function deletePharmacy(Request $request)
    {
        $data = $request->all();
        return PharmacyService::deletePharmacy($data);
    }

    public function getPharmacyData(Request $request)
    {
        $data = $request->all();
        return PharmacyService::getPharmacyData($data);
    }

    public function showEditPharmacy(Request $request, $id)
    {
        $pharmacy = Pharmacy::where(['id' => $id])->first();
        if (!$pharmacy) {
            return redirect()->to(url('/pharmacies'));
        }
        $data['pharmacy'] = $pharmacy;
        $data['title'] = trans('admin.edit_pharmacy');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'pharmacies';
        $data['governments'] = Province::get();
        $city = City::where(['id' => $pharmacy->city_id])->first();
        $data['cities'] = City::where(['province_id' => $city->province_id])->get();
        return view('admin.pharmacy.edit_pharmacy')->with($data);
    }

    public function editPharmacy(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return PharmacyService::editPharmacy($data);
    }

    public function changePharmacy(Request $request)
    {
        $data = $request->all();
        return PharmacyService::changePharmacy($data);
    }

}
