<?php
namespace App\Repositories\Dashboard\User;


use App\Entities\PermissionKey;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionGroup;
use Yajra\DataTables\Facades\DataTables;

class PermissionRepository
{

    // get Permissions and create datatable data.
    public static function getPermissionsData(array $data)
    {
        $Permissions = Permission::get();
        $arr = ['danger', 'success', 'inverse', 'warning', 'primary', 'info'];
        return DataTables::of($Permissions)
            ->addColumn('permissions', function ($permission) use ($arr) {
                $response = '';
                foreach (PermissionKey::getKeys() as $permissionKey) {
                    if ($permission->{$permissionKey} == 1) {
                        $response .= '<span class="btn btn-' . $arr[mt_rand(0, 5)] . '">'
                            . trans('admin.' . $permissionKey . '_permission') . '</span> ';
                    }
                }
                return $response;
            })
            ->addColumn('actions', function ($Permission) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $Permission->id . '" onclick="editPermission(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $Permission->id . '" onclick="deletePermission(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addPermission(array $data)
    {
        $permissionData = [];
        $permission = new Permission;
        foreach ($data['permissions'] as $index => $permissionKey) {
            $permission->{$permissionKey} = 1;
        }
        $permission->group_name = $data['group_name'];
//        $created = PermissionGroup::create($permissionData);
        if ($permission->save()) {
            return true;
        }
        return false;
    }

    public static function deletePermission(array $data)
    {
        $Permission = Permission::where(['id' => $data['id']])->first();
        if ($Permission) {
            $Permission->forceDelete();
            return true;
        }
        return false;
    }

    public static function getPermissionData(array $data)
    {
        $permission = Permission::where(['id' => $data['id']])->first();
        $data = array();
        foreach ($permission->toArray() as $key => $value) {
            if ($value == 1)
                $data[] = $key;
        }
        if ($permission) {
            $permission['permissions'] = $data;
            return $permission;
        }
        return false;
    }

    public static function editPermission(array $data)
    {
        $permissionGroup = Permission::where(['id' => $data['id']])->first();
        if ($permissionGroup) {
            $permissionGroup->group_name = $data['group_name'];
            $permissions = $permissionGroup->toArray();
            foreach ($permissions as $permission_key => $value) {
                if (($value == 1 || $value == 0) && $permission_key != 'group_name') {
                    foreach ($data['permissions'] as $index => $permission_value) {
                        if ($permission_key == $permission_value) {
                            $permissionGroup->{$permission_key} = 1;
                            break;
                        } else
                            $permissionGroup->{$permission_key} = 0;
                    }
                }
            }
            if ($permissionGroup->save()) {
                return true;
            }
        }
        return false;
    }

    public static function changePermission(array $data)
    {
        $Permission = Permission::where(['id' => $data['id']])->first();
        if ($Permission) {
            $Permission->update(['is_active' => !$Permission->is_active]);
            return true;
        }
        return false;
    }
}

?>
