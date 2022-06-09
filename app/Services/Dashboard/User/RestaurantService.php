<?php
namespace App\Services\Dashboard\User;

use App\Entities\UserRoles;
use App\Models\User\User;
use App\Repositories\Dashboard\User\RestaurantRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class RestaurantService
{


    public static function getRestaurantsData(array $data)
    {
        return RestaurantRepository::getRestaurantsData($data);
    }

    public static function addRestaurant(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'restaurant_name' => 'required',
            'logo' => 'required'
        ];
        $messages = [
            'email' => trans('admin.email_error_message'),
            'unique' => trans('admin.unique_error_message')
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules , $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = RestaurantRepository::addRestaurant($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function changeRestaurant(array $data)
    {
        $response = RestaurantRepository::changeRestaurant($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getRestaurantData(array $data)
    {
        $response = RestaurantRepository::getRestaurantData($data);
        return UtilsRepository::response($response);
    }

    public static function editRestaurant(array $data)
    {
        $user = User::where(['id' => $data['id'] , 'role' => UserRoles::RESTAURANT])->first();
        $response = false;
        if($user){
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'restaurant_name' => 'required',
            ];
            if(isset($data['email']) && !empty($data['email']) && $data['email'] !== $user->email){
                $rules['email'] .= '|unique:users';
            }
            $messages = [
                'email' => trans('admin.email_error_message'),
                'unique' => trans('admin.unique_error_message')
            ];
            $validated = ValidationRepository::validateWebGeneral($data, $rules , $messages);
            if ($validated !== true) {
                return $validated;
            }
            $data['user'] = $user;
            $response = RestaurantRepository::editRestaurant($data);
        }
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
