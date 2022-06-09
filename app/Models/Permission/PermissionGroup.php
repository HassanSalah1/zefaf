<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    //
    protected $table = 'permission_groups';
    protected $fillable = ['permission_id', 'user_id'];

}
