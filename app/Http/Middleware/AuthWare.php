<?php

namespace App\Http\Middleware;

use App\Entities\UserRole;
use App\Entities\UserRoles;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthWare
{
    public function handle($request, Closure $next, $role = null)
    {

        if (!Auth::check()) {
            return redirect()->to('/login');
        }
        return $next($request);
    }
}
