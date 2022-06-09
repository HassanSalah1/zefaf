<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Permission\Permission;
use App\Models\PermissionGroup;
use App\Services\Dashboard\User\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EmployeeController extends Controller
{
    //
    public function showEmployees()
    {
        $data['title'] = trans('admin.employees_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'employees';
        $data['debatable_names'] = array(trans('admin.name'), trans('admin.email'),
            trans('admin.group_name'),
            trans('admin.actions'));
        $data['permissions'] = Permission::select(['id', 'group_name'])->get();
        return view('admin.user.employee')->with($data);
    }

    public function getEmployeesData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return EmployeeService::getEmployeesData($data);
    }

    public function addEmployee(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return EmployeeService::addEmployee($data);
    }

    public function deleteEmployee(Request $request)
    {
        $data = $request->all();
        return EmployeeService::deleteEmployee($data);
    }

    public function getEmployeeData(Request $request)
    {
        $data = $request->all();
        return EmployeeService::getEmployeeData($data);
    }

    public function editEmployee(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return EmployeeService::editEmployee($data);
    }

    public function changeEmployee(Request $request)
    {
        $data = $request->all();
        return EmployeeService::changeEmployee($data);
    }
}
