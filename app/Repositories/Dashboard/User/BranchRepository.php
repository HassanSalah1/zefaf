<?php
namespace App\Repositories\Dashboard\User;


use App\Entities\UserStatus;
use App\Models\Branch;
use App\Models\City;
use App\Models\Restaurant;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class BranchRepository
{

    // get Branches and create datatable data.
    public static function getBranchesData(array $data)
    {
        $search = [];
        if(auth()->user()->isRestaurantAuth()){
            $search['restaurant_id'] = auth()->user()->id;
        }
        $branches = Branch::where($search)->get();
        return DataTables::of($branches)
            ->addColumn('city_name', function ($branch) {
                $locale = App::getLocale();
                $city = City::where(['id' => $branch->city_id])
                    ->select(['name_' . $locale . ' AS name'])
                    ->first();
                if ($city) {
                    return $city->name;
                }
            })
            ->addColumn('restaurant_name', function ($branch) {
                $restaurant = Restaurant::where(['id' => $branch->restaurant_id])
                    ->first();
                if ($restaurant) {
                    return $restaurant->name;
                }
            })
            ->addColumn('actions', function ($branch) {
                $ul = '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $branch->id . '" onclick="editBranch(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                if (intval($branch->is_active) === UserStatus::INT_ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.inactive_action') . '" id="' . $branch->id . '" onclick="banBranch(this);return false;" href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-ban"></i></a> ';
                } else if (intval($branch->is_active) === UserStatus::INT_INACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $branch->id . '" onclick="changeBranchStatus(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                }
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $branch->id . '" onclick="deleteBranch(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addBranch(array $data)
    {
        $branchData = [
            'address' => $data['address'],
            'restaurant_id' => $data['restaurant_id'],
            'city_id' => $data['city_id'],
        ];
        $created = Branch::create($branchData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteBranch(array $data)
    {
        $branch = Branch::where(['id' => $data['id']])->first();
        if ($branch) {
            $branch->forceDelete();
            return true;
        }
        return false;
    }

    public static function getBranchData(array $data)
    {
        $branch = Branch::where(['id' => $data['id']])->first();
        if ($branch) {
            return $branch;
        }
        return false;
    }

    public static function editBranch(array $data)
    {
        $branch = Branch::where(['id' => $data['id']])->first();
        if ($branch) {
            $branchData = [
                'address' => $data['address'],
                'restaurant_id' => $data['restaurant_id'],
                'city_id' => $data['city_id'],
            ];
            $updated = $branch->update($branchData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

    public static function changeBranch(array $data)
    {
        $branch = Branch::where(['id' => $data['id']])->first();
        if ($branch) {
            $branch->update(['is_active' => !$branch->is_active]);
            return true;
        }
        return false;
    }
}

?>
