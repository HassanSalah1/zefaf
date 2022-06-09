<?php
namespace App\Repositories\Dashboard\User;


use App\Entities\UserStatus;
use App\Entities\UserRoles;
use App\Models\Restaurant;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class RestaurantRepository
{

    // get Restaurants and create datatable data.
    public static function getRestaurantsData(array $data)
    {
        $restaurants = User::join('restaurants', 'restaurants.user_id', '=', 'users.id')
            ->select(['users.id', 'users.name', 'is_active', 'restaurants.name AS restaurant_name', 'logo'])
            ->get();
        return DataTables::of($restaurants)
            ->editColumn('logo', function ($restaurant) {
                return '<a href="' . url($restaurant->logo) . '" data-popup="lightbox">
                    <img src="' . url($restaurant->logo) . '" class="img-rounded img-preview"
                    style="max-height:50px;max-width:50px;"></a>';
            })
            ->addColumn('actions', function ($restaurant) {
                $ul = '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $restaurant->id . '"  href="' . url('restaurant/edit/' . $restaurant->id) . '" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                if (intval($restaurant->is_active) === UserStatus::INT_ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.inactive_action') . '" id="' . $restaurant->id . '" onclick="banRestaurant(this);return false;" href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-ban"></i></a> ';
                } else if (intval($restaurant->is_active) === UserStatus::INT_INACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $restaurant->id . '" onclick="changeRestaurantStatus(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                }
//                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $restaurant->id . '" onclick="deleteRestaurant(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addRestaurant(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => UserRoles::RESTAURANT
        ];
        $restaurantData = [
            'name' => $data['restaurant_name']
        ];
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'logo';
        $image_path = 'uploads/restaurants/';
        $restaurantData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);

        if ($restaurantData['logo'] !== false) {
            $created = User::create($userData);
            if ($created) {
                $restaurantData['user_id'] = $created->id;
                Restaurant::create($restaurantData);
                return true;
            }
        }
        return false;
    }

    public static function changeRestaurant(array $data){
        $user = User::where(['id' => $data['id'] , 'role' => UserRoles::RESTAURANT])->first();
        if($user){
            $user->update(['is_active' => !$user->is_active]);
            return true;
        }
        return false;
    }

    public static function editRestaurant(array $data)
    {
        $user = $data['user'];
        if ($user) {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'role' => UserRoles::RESTAURANT
            ];
            if(isset($data['password']) && !empty($data['password'])){
                $userData['password'] = Hash::make($data['password']);
            }
            $restaurantData = [
                'name' => $data['restaurant_name']
            ];
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'logo';
            $image_path = 'uploads/restaurants/';
            $restaurantData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);

            $user->update($userData);
            $restaurant = Restaurant::where(['user_id' => $user->id])->first();
            if ($restaurantData['logo'] === false) {
                unset($restaurantData['logo']);
            } else {
                if (file_exists($restaurant->logo)) {
                    unlink($restaurant->logo);
                }
            }
            $restaurant->update($restaurantData);
            return true;
        }
        return false;
    }

}

?>
