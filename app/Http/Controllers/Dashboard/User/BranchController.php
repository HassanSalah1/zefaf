<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Restaurant;
use App\Services\Dashboard\User\BranchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BranchController extends Controller
{
    //
    public function showBranches()
    {
        $data['title'] = trans('admin.branches_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'branches';
        $data['debatable_names'] = array(trans('admin.restaurant_name'), trans('admin.city_name'),
            trans('admin.address'), trans('admin.actions'));

        $data['cities'] = City::get();
        $data['restaurants'] = Restaurant::get();

        return view('admin.user.branch')->with($data);
    }

    public function getBranchesData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return BranchService::getBranchesData($data);
    }

    public function addBranch(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return BranchService::addBranch($data);
    }

    public function deleteBranch(Request $request)
    {
        $data = $request->all();
        return BranchService::deleteBranch($data);
    }

    public function getBranchData(Request $request)
    {
        $data = $request->all();
        return BranchService::getBranchData($data);
    }

    public function editBranch(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return BranchService::editBranch($data);
    }

    public function changeBranch(Request $request)
    {
        $data = $request->all();
        return BranchService::changeBranch($data);
    }

}
