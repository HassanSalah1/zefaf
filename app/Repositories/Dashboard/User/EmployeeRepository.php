<?php
namespace App\Repositories\Dashboard\User;


use App\Entities\UserStatus;
use App\Entities\UserRoles;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionGroup;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class EmployeeRepository
{

    // get Employees and create datatable data.
    public static function getEmployeesData(array $data)
    {
        $employees = User::join('permission_groups', 'permission_groups.user_id', '=', 'users.id')
            ->where(['role' => UserRoles::EMPLOYEE])
            ->get(['users.id', 'name', 'email', 'status', 'permission_id']);
        return DataTables::of($employees)
            ->addColumn('group_name', function ($employee) {
                $permission = Permission::where(['id' => $employee->permission_id])
                    ->first();
                if ($permission) {
                    return $permission->group_name;
                }
            })
            ->addColumn('actions', function ($employee) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $employee->id . '" onclick="editEmployee(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                if ($employee->status === UserStatus::ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.inactive_action') . '" id="' . $employee->id . '" onclick="banEmployee(this);return false;" href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-ban"></i></a> ';
                } else if ($employee->status === UserStatus::BLOCKED) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $employee->id . '" onclick="changeEmployeeStatus(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                }
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $employee->id . '" onclick="deleteEmployee(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addEmployee(array $data)
    {
        $employeeData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRoles::EMPLOYEE
        ];
        $created = User::create($employeeData);
        if ($created) {
            PermissionGroup::create([
                'user_id' => $created->id,
                'permission_id' => $data['permission_group_id']
            ]);
            return true;
        }
        return false;
    }

    public static function deleteEmployee(array $data)
    {
        $employee = User::where(['id' => $data['id'], 'role' => UserRoles::EMPLOYEE])->first();
        if ($employee) {
            $employee->forceDelete();
            return true;
        }
        return false;
    }

    public static function getEmployeeData(array $data)
    {
        $employee = User::join('permission_groups', 'permission_groups.user_id', '=', 'users.id')
            ->where(['users.id' => $data['id'], 'role' => UserRoles::EMPLOYEE])
            ->first(['users.id', 'name', 'email', 'status', 'permission_id']);
        if ($employee) {
            $employee->permission_group_id = $employee->permission_id;
            return $employee;
        }
        return false;
    }

    public static function editEmployee(array $data)
    {
        $employee = User::where(['id' => $data['id'], 'role' => UserRoles::EMPLOYEE])->first();
        if ($employee) {
            $employeeData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];
            if (isset($data['password']) && !empty($data['password'])) {
                $employeeData['password'] = Hash::make($data['password']);
            }
            $updated = $employee->update($employeeData);
            if ($updated) {
                PermissionGroup::where(['user_id' => $employee->id])
                    ->update([
                        'permission_id' => $data['permission_group_id']
                    ]);
                return true;
            }
        }
        return false;
    }

    public static function changeEmployee(array $data)
    {
        $employee = User::where(['id' => $data['id']])->first();
        if ($employee) {
            $employee->update(['status' => $data['status']]);
            return true;
        }
        return false;
    }

}

?>
