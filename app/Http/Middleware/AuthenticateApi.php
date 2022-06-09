<?php

namespace App\Http\Middleware;


use App\Entities\HttpCode;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Closure;
use Illuminate\Support\Facades\App;

class AuthenticateApi
{
    public function handle($request, Closure $next, $role = null)
    {
        $user = auth()->user();
        if (!$user || !$user->isActiveUser()) {
            $response = [
                'message' => trans('api.not_login_message'),
                'code' => HttpCode::AUTH_ERROR
            ];
            return UtilsRepository::handleResponseApi($response);
        }
        $user->update(['lang' => App::getLocale()]);
        return $next($request);
    }
}
