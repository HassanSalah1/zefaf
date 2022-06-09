<?php

namespace App\Http\Middleware;


use App\Entities\HttpCode;
use App\Entities\UserRoles;
use App\Repositories\General\UtilsRepository;
use Closure;

class ValidateClientAuth
{
    public function handle($request, Closure $next, $role = null)
    {
        $user = auth()->user();
        if (!$user || $user->role !== UserRoles::CUSTOMER) {
            $response = [
                'message' => trans('api.not_login_message'),
                'code' => HttpCode::AUTH_ERROR
            ];
            return UtilsRepository::handleResponseApi($response);
        }
        return $next($request);
    }
}
