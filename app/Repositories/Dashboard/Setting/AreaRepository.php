<?php
namespace App\Repositories\Dashboard\Setting;


use App\Models\Setting\City;
use App\Models\Setting\Country;
use Yajra\DataTables\Facades\DataTables;

class AreaRepository
{

    // get Areas and create datatable data.
    public static function getAreasData(array $data)
    {
        $areas = City::where(['is_deleted' => 0])->get();
        return DataTables::of($areas)
            ->addColumn('country_name', function ($area) {
                $country = Country::where(['id' => $area->country_id])->first();
                return ($country) ? $country->name : null;
            })->addColumn('actions', function ($area) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $area->id . '" onclick="editArea(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
//                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $area->id . '" onclick="deleteArea(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addArea(array $data)
    {
        $areaData = [
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'country_id' => $data['country_id'],
        ];
        $created = City::create($areaData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteArea(array $data)
    {
        $area = City::where(['id' => $data['id']])->first();
        if ($area) {
            $area->update(['is_deleted' => 1]);
            return true;
        }
        return false;
    }

    public static function changeArea(array $data)
    {
        $area = City::where(['id' => $data['id']])->first();
        if ($area) {
            $area->update(['is_active' => !$area->is_active]);
            return true;
        }
        return false;
    }

    public static function getAreaData(array $data)
    {
        $area = City::where(['id' => $data['id']])->first();
        if ($area) {
            return $area;
        }
        return false;
    }

    public static function editArea(array $data)
    {
        $area = City::where(['id' => $data['id']])->first();
        if ($area) {
            $areaData = [
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'country_id' => $data['country_id'],
            ];
            $updated = $area->update($areaData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
