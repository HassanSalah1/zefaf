<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\User\Client;
use App\Models\User\User;
use App\Services\Dashboard\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    //

    public function showUsers(Request $request)
    {
        $data['title'] = trans('admin.users_title');
        $data['active'] = 'users';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['debatable_names'] = array(trans('admin.name'), trans('admin.phone'),
            trans('admin.email'), trans('admin.status'), trans('admin.actions'));

        $data['countries'] = Country::where(['is_deleted' => 0])->get();
        $data['cities'] = (count($data['countries']) > 0) ?
            City::where(['country_id' => $data['countries'][0]->id])->where(['is_deleted' => 0])->get() : [];

        return view('admin.user.users')->with($data);
    }

    public function getUsersData(Request $request)
    {
        $data = $request->all();
        return UserService::getUsersData($data);
    }

    public function getCountryCities(Request $request)
    {
        $data = $request->all();
        return UserService::getCountryCities($data);
    }

    public function addUser(Request $request)
    {
        $data = $request->all();
        return UserService::addUser($data);
    }

    public function verifyUser(Request $request)
    {
        $data = $request->all();
        return UserService::verifyUser($data);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        return UserService::changeStatus($data);
    }

    public function showUserDetails($id, Request $request)
    {
        $user = User::where(['users.id' => $id, 'role' => UserRoles::CUSTOMER])
            ->first();

        if (!$user) {
            return abort(404);
        }

        $client = Client::where(['user_id' => $user->id])->first();
        $user->weddingDate = $client ? $client->wedding_date : null;

        $city = City::where(['id' => $user->city_id])->first();
        $user->cityName = ($city) ? $city->name : null;
        $country = Country::where(['id' => ($city) ? $city->country_id : null])->first();
        $user->countryName = ($country) ? $country->name : null;

        $data['locale'] = App::getLocale();
        $data['userProfile'] = $user;
        $data['title'] = trans('admin.user_details_title') . ' - ' . $user->name;
        $data['active'] = '';
        $data['user'] = auth()->user();
        return view('admin.user.user_profile')->with($data);
    }

    public function showUserFavouritesData(Request $request ,$id){
        $data = $request->all();
        $data['id'] = $id;
        return UserService::showUserFavouritesData($data);
    }

}
