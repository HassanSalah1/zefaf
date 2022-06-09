<?php

namespace App\Models\User;

use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionGroup;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    //
    use Notifiable, HasApiTokens;

    protected $table = 'users';
    protected $fillable = ['name', 'phone', 'email', 'password', 'lang', 'city_id',
        'facebook_id', 'device_type', 'device_token', 'role', 'status', 'login_count'];

    //

//    protected $casts = [
//        'login_count' => 'integer', //
//    ];

    function isDashboardAuth()
    {
        if ($this->role === UserRoles::ADMIN) {
            return true;
        }
        return false;
    }

    function isActiveUser()
    {
        if ($this->status === UserStatus::ACTIVE) {
            return true;
        }
        return false;
    }

    function isBlocked()
    {
        if ($this->status === UserStatus::BLOCKED) {
            return true;
        }
        return false;
    }

    public function hasPermission($permission)
    {
        if ($this->role == UserRoles::ADMIN) {
            return true;
        } else if ($this->role == $permission) {
            return true;
        }

        $group = PermissionGroup::where(['user_id' => $this->id])->first();
        if ($group) {
            $permissions = Permission::where(['id' => $group->permission_id])->first();
            if ($permissions && $permissions[$permission] == 1) {
                return true;
            }
        }
        return false;
    }

    public function vendor()
    {
        return $this->hasOne(Vendors::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function vendor_images()
    {
        return $this->hasMany(UserImage::class);
    }

}
