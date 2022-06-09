<?php

namespace App\Repositories\Dashboard\User;


use App\Entities\StatisticsType;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Http\Resources\CityResource;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\Setting\Membership;
use App\Models\User\Statistics;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{

    public static function getUsersData(array $data)
    {
        $users = User::where(['role' => UserRoles::CUSTOMER])
            ->where(function ($query) use ($data) {
                if (isset($data['city_id']) && !empty($data['city_id'])
                    && $data['city_id'] !== '-1') {
                    $query->where(['city_id' => $data['city_id']]);
                }
            })
            ->get();
        return DataTables::of($users)
            ->editColumn('status', function ($user) {
                if ($user->status === UserStatus::ACTIVE) {
                    return '<span class="btn btn-success">' . trans('admin.active_status') . '</span>';
                } else if ($user->status === UserStatus::BLOCKED) {
                    return '<span class="btn btn-danger">' . trans('admin.blocked_status') . '</span>';
                }
            })
            ->addColumn('actions', function ($userObj) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.details_action') . '" href="/user/details/' . $userObj->id . '" class="on-default edit-row btn btn-primary"><i class="fa fa-eye"></i></a> ';
                // block or activate account
                if ($userObj->status === UserStatus::BLOCKED) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $userObj->id . '" onclick="activeUser(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                } else if ($userObj->status === UserStatus::ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.block_action') . '" id="' . $userObj->id . '" onclick="blockUser(this);return false;"  href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-lock"></i></a> ';
                }
//                // verify
//                if ($userObj->status === UserStatus::UNVERIFIED) {
//                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.verify_action') . '" id="' . $userObj->id . '" onclick="verifyAccount(this);return false;" href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-certificate"></i></a> ';
//                }
                return $ul;
            })
            ->make(true);
    }

    public static function changeStatus(array $data)
    {
        $user = User::where(['id' => $data['id']])->first();
        if ($user) {
            $user->update([
                'status' => $data['status'],
            ]);
            return true;
        }
        return false;
    }


    public static function verifyUser(array $data)
    {
        $user = User::where(['id' => $data['id']])->first();
        if ($user) {
            $user->update(['status' => UserStatus::INT_ACTIVE]);
            return true;
        }
        return false;
    }

    public static function addUser(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRoles::CUSTOMER,
            'status' => UserStatus::ACTIVE,
            'lang' => 'en',
            'phone' => $data['phone'],
            'city_id' => $data['city_id']
        ];
        $user = User::create($userData);
        if ($user) {
            // send email with phone / password
            $locale = $user->lang;
            $message = str_replace(['{phone}', '{password}'], [$user->phone, $data['password']],
                trans('sms.create_your_account'));
            // TODO: send email
            return true;
        }
        return false;
    }

    public static function showUserFavouritesData(array $data)
    {
        $users = Statistics::join('users', 'users.id', '=', 'statistics.vendor_id')
            ->join('vendors', 'vendors.user_id', '=', 'statistics.vendor_id')
            ->where(['statistics.user_id' => $data['id'], 'statistics.type' => StatisticsType::LIKE])
            ->get(['users.id', 'users.name', 'category_id', 'from_price', 'to_price' ,
                'city_id' , 'membership_id']);

        return DataTables::of($users)
            ->addColumn('category_name', function ($userObj) {
                $category = Category::where(['id' => $userObj->category_id])->first();
                if ($category) {
                    return $category->name;
                }
            })
            ->addColumn('price_range', function ($userObj) {
                return $userObj->from_price . ' - ' . $userObj->to_price;
            })
            ->addColumn('location', function ($userObj) {
                $city = City::where(['id' => $userObj->city_id])->first();
                if ($city) {
                    $country = Country::where(['id' => $city->country_id])->first();
                    return $city->name . ' - ' . $country->name;
                }
            })
            ->addColumn('membership', function ($userObj) {
                $membership = Membership::where(['id' => $userObj->membership_id])->first();
                if ($membership) {
                    return $membership->type;
                }
            })
            ->make(true);
    }

    public static function getCountryCities(array $data)
    {
        $cities = City::where(['country_id' =>$data['country_id']])
            ->get();

        return CityResource::collection($cities);
    }

}

?>
