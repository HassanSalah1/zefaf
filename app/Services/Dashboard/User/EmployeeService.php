<?php
namespace App\Services\Dashboard\User;

use App\Models\User\User;
use App\Repositories\Dashboard\User\EmployeeRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class EmployeeService
{


    public static function getEmployeesData(array $data)
    {
        return EmployeeRepository::getEmployeesData($data);
    }

    public static function addEmployee(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'permission_group_id' => 'required',
        ];
        $messages = [
            'email' => trans('admin.email_error_message'),
            'unique' => trans('admin.unique_error_message')
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules , $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = EmployeeRepository::addEmployee($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteEmployee(array $data)
    {
        $response = EmployeeRepository::deleteEmployee($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getEmployeeData(array $data)
    {
        $response = EmployeeRepository::getEmployeeData($data);
        return UtilsRepository::response($response);
    }

    public static function editEmployee(array $data)
    {
        $user = User::where(['id' => $data['id']])->first();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'permission_group_id' => 'required',
        ];
        if($user && !empty($data['email']) && $user->email !== $data['email'] ){
            $rules['email'] .= '|unique:users';
        }
        $messages = [
            'email' => trans('admin.email_error_message'),
            'unique' => trans('admin.unique_error_message')
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules , $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = EmployeeRepository::editEmployee($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function changeEmployee(array $data)
    {
        $response = EmployeeRepository::changeEmployee($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }
}

?>
