<?php
namespace App\Services\Dashboard\User;

use App\Repositories\Dashboard\User\BranchRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class BranchService
{


    public static function getBranchesData(array $data)
    {
        return BranchRepository::getBranchesData($data);
    }

    public static function addBranch(array $data)
    {
        if(auth()->user()->isRestaurantAuth()){
            $data['restaurant_id'] = auth()->user()->id;
        }
        $rules = [
            'address' => 'required',
            'city_id' => 'required',
            'restaurant_id' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = BranchRepository::addBranch($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteBranch(array $data)
    {
        $response = BranchRepository::deleteBranch($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getBranchData(array $data)
    {
        $response = BranchRepository::getBranchData($data);
        return UtilsRepository::response($response);
    }

    public static function editBranch(array $data)
    {
        if(auth()->user()->isRestaurantAuth()){
            $data['restaurant_id'] = auth()->user()->id;
        }
        $rules = [
            'address' => 'required',
            'city_id' => 'required',
            'restaurant_id' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = BranchRepository::editBranch($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function changeBranch(array $data)
    {
        $response = BranchRepository::changeBranch($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>
