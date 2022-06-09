<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPrice;
use App\Services\Dashboard\User\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PermissionController extends Controller
{
    //
    public function showPermissions()
    {
        $data['title'] = trans('admin.permissions_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'permissions';
        $data['debatable_names'] = array(trans('admin.group_name'), trans('admin.permissions'),
         trans('admin.actions'));
        return view('admin.user.admin.permission')->with($data);
    }

    public function getPermissionsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return PermissionService::getPermissionsData($data);
    }

    public function addPermission(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return PermissionService::addPermission($data);
    }

    public function deletePermission(Request $request)
    {
        $data = $request->all();
        return PermissionService::deletePermission($data);
    }

    public function getPermissionData(Request $request)
    {
        $data = $request->all();
        return PermissionService::getPermissionData($data);
    }

    public function editPermission(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return PermissionService::editPermission($data);
    }

    public function changePermission(Request $request){
        $data = $request->all();
        return PermissionService::changePermission($data);
    }

    public function showDeliveryPrices($id)
    {
        $data['locale'] = App::getLocale();
        $Permission = Permission::where(['id' => $id])->select(['id' , 'name_'.$data['locale'].' AS name'])->first(['id' , 'name']);
        if(!$Permission){
            return redirect()->to(url('/Permissions'));
        }
        $Permission->delivery_price = DeliveryPrice::where(['Permission_id' => $Permission->id])->first();
        $data['title'] = trans('admin.delivery_prices_title') . ' - ' . $Permission->name;
        $data['user'] = auth()->user();
        $data['active'] = 'Permissions';
        $data['Permission'] = $Permission;
        return view('admin.setting.delivery_price')->with($data);
    }

    public function saveDeliveryPrice(Request $request){
        $data = $request->all();
        return PermissionService::saveDeliveryPrice($data);
    }

}
