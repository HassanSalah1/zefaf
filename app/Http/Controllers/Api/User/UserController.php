<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\User\UserApiService;
use Illuminate\Http\Request;
use App\Repositories\General\UtilsRepository;

class UserController extends Controller
{
    //

    public function getProfile(Request $request)
    {
        $data = $request->all();
        return UserApiService::getProfile($data);
    }

    public function getMyNotifications(Request $request)
    {
        $data = $request->all();
        return UserApiService::getMyNotifications($data);
    }


    public function editProfile(Request $request)
    {
        $data = $request->all();
        $data['user'] = auth()->user();
        if($request->has('image')){
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/users/';
            $data['image'] = UtilsRepository::createImageFormBase64($request, $image_name, $image_path, $file_id);
            if ($data['user']->image !== null && file_exists($data['user']->image)) {
                unlink($data['user']->image);
            }
        }


        return UserApiService::updateUserData($data);
    }

    public function getSetting(Request $request)
    {
        $data = $request->all();
        return UserApiService::getSetting($data);
    }


    public function getMyNotificationsCount(Request $request)
    {
        $data = $request->all();
        return UserApiService::getMyNotificationsCount($data);
    }

    public function editSetting(Request $request)
    {
        $data = $request->all();
        $data['user'] = auth()->user();
        return UserApiService::editSetting($data);
    }
}
