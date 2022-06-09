<?php

namespace App\Http\Middleware;

use App\Entities\Status;
use App\Entities\UserRoles;
use Closure;
use Auth;

class RoleWare
{
    public function handle($request, Closure $next, $role = null)
    {
        $user = auth()->user();
        $roles = explode('|', $role);
        foreach ($roles as $role){
            if(!$user->hasPermission($role)){
                abort(404);
            }
        }
        return $next($request);
    }
}
