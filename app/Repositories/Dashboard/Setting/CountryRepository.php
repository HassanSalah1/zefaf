<?php
namespace App\Repositories\Dashboard\Setting;


use App\Models\Setting\Country;
use Yajra\DataTables\Facades\DataTables;

class CountryRepository
{

    // get Countrys and create datatable data.
    public static function getCountriesData(array $data)
    {
        $countrys = Country::where(['is_deleted' => 0])->get();
        return DataTables::of($countrys)
            ->addColumn('actions', function ($country) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $country->id . '" onclick="editCountry(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
//                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $country->id . '" onclick="deleteCountry(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addCountry(array $data)
    {
        $countryData = [
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
        ];
        $created = Country::create($countryData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteCountry(array $data)
    {
        $country = Country::where(['id' => $data['id']])->first();
        if ($country) {
            $country->update(['is_deleted' => 1]);
            return true;
        }
        return false;
    }

    public static function changeCountry(array $data)
    {
        $country = Country::where(['id' => $data['id']])->first();
        if ($country) {
            $country->update(['is_active' => !$country->is_active]);
            return true;
        }
        return false;
    }

    public static function getCountryData(array $data)
    {
        $country = Country::where(['id' => $data['id']])->first();
        if ($country) {
            return $country;
        }
        return false;
    }

    public static function editCountry(array $data)
    {
        $country = Country::where(['id' => $data['id']])->first();
        if ($country) {
            $countryData = [
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
            ];
            $updated = $country->update($countryData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
