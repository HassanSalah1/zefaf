<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User\User;
use App\Services\Dashboard\User\RestaurantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RestaurantController extends Controller
{
    //
    public function showRestaurants()
    {
        $data['title'] = trans('admin.restaurants_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'restaurants';
        $data['debatable_names'] = array(trans('admin.name'), trans('admin.restaurant_name'),
            trans('admin.logo'), trans('admin.actions'));
        return view('admin.user.restaurant.restaurant')->with($data);
    }

    public function getRestaurantsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return RestaurantService::getRestaurantsData($data);
    }

    public function showAddRestaurant()
    {
        $data['title'] = trans('admin.add_restaurant');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'restaurants';
        return view('admin.user.restaurant.add_restaurant')->with($data);
    }

    public function addRestaurant(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return RestaurantService::addRestaurant($data);
    }

    public function changeRestaurant(Request $request)
    {
        $data = $request->all();
        return RestaurantService::changeRestaurant($data);
    }

    public function getRestaurantData(Request $request)
    {
        $data = $request->all();
        return RestaurantService::getRestaurantData($data);
    }


    public function showEditRestaurant($id)
    {
        $user = User::where(['id' => $id, 'role' => UserRoles::RESTAURANT])->first();
        if (!$user) {
            return redirect()->to('/restaurants');
        }
        $user->restaurant = Restaurant::where(['user_id' => $user->id])->first();
        $user->restaurant->logo = url($user->restaurant->logo);
        $data['restaurant'] = $user;
        $data['title'] = trans('admin.edit_restaurant');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'restaurants';
        return view('admin.user.restaurant.edit_restaurant')->with($data);
    }

    public function editRestaurant(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return RestaurantService::editRestaurant($data);
    }

}
