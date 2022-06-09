<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Entities\UserStatus;
use App\Entities\NotificationType;
use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use App\Services\Dashboard\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function loginView()
    {
//        User::create([
//            'name' => 'super admin',
//            'email' => 'admin@zefaf.com',
//            'password' => Hash::make('123456'),
//            'role' => UserRoles::ADMIN,
//            'status' => UserStatus::ACTIVE
//        ]);
        $user = auth()->user();
        if ($user && $user->isDashboardAuth()) {
            return redirect()->to('/home');
        }
        $data['title'] = trans('admin.login_title');
        $data['locale'] = App::getLocale();
        return view('admin.auth.login')->with($data);
    }

    public function login(Request $request)
    {
        $data = $request->all('email', 'password');
        $data['remember'] = $request->has('remember') ? true : false;
        return AuthService::login($data);
    }

    public function showUpdateProfile()
    {
        $data['title'] = trans('admin.profile_title');
        $data['active'] = 'profile';
        $data['user'] = auth()->user();
        $data['user']->admin_image = ($data['user']->admin_image !== null) ?
            url($data['user']->admin_image) : url('/dashboard/images/users/avatar-1.jpg');
        $data['locale'] = App::getLocale();
        return view('admin.auth.profile')->with($data);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        $data['user'] = auth()->user();
        return AuthService::updateProfile($data);
    }


    public function logout(Request $request)
    {
        return AuthService::logout('/login');
    }

    public function showResetPassword(Request $request)
    {
        $data['title'] = trans('admin.forget_password');
        $data['locale'] = App::getLocale();
        return view('admin.auth.forget')->with($data);
    }

    public function processResetPassword(Request $request)
    {
        $data = $request->all('email', 'password');
        return AuthService::processResetPassword($data);
    }

    public function showChangePassword(Request $request, $code)
    {
        $verification = VerificationCode::where(['code' => $code])->first();
        if (!$verification) {
            return redirect()->to(url('/reset-password'));
        }
        $data['title'] = trans('admin.change_password');
        $data['locale'] = App::getLocale();
        $data['code'] = $code;
        return view('admin.auth.change')->with($data);
    }

    public function processChangePassword(Request $request)
    {
        $data = $request->all('password', 'code');
        return AuthService::processChangePassword($data);
    }

    public function updateToken(Request $request)
    {
        if (isset($request->device_token)) {
            User::where(['id' => auth()->user()->id])
                ->update(['device_token' => $request->device_token]);
        }
    }

}
