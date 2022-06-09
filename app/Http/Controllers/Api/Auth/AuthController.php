<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Services\Api\Auth\AuthApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return AuthApiService::signup($data);
    }

//    public function authFacebook(Request $request){
//        $data = $request->all();
//        return AuthApiService::authFacebook($data);
//    }

    public function login(Request $request){
        $data = $request->all();
        return AuthApiService::login($data);
    }

    public function forgetPassword(Request $request){
        $data = $request->all();
        return AuthApiService::forgetPassword($data);
    }

    public function changeForgetPassword(Request $request){
        $data = $request->all();
        return AuthApiService::changeForgetPassword($data);
    }

    public function resendVerificationCode(Request $request){
        $data = $request->all();
        return AuthApiService::resendVerificationCode($data);
    }

    public function checkVerificationCode(Request $request){
        $data = $request->all();
        return AuthApiService::checkVerificationCode($data);
    }

    public function logout(Request $request){
        $data = $request->all();
        return AuthApiService::logout();
    }

}
