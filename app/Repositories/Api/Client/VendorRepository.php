<?php

namespace App\Repositories\Api\Client;

use App\Entities\HttpCode;
use App\Entities\StatisticsType;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\VendorDetailsResource;
use App\Http\Resources\VendorResource;
use App\Models\User\Package;
use App\Models\User\Review;
use App\Models\User\Statistics;
use App\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class VendorRepository
{

    public static function getVendors(array $data): array
    {
        $search = [];

        if (isset($data['category_id'])) {
            $search['category_id'] = $data['category_id'];
        }
        if (isset($data['city_id'])) {
            $search['city_id'] = $data['city_id'];
        }
        /////////////////
        ///
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $vendors = User::join('vendors', 'users.id', '=', 'vendors.user_id')
            ->where([
                'role' => UserRoles::VENDOR,
                'status' => UserStatus::ACTIVE,
                ['membership_id', '!=', null],
            ])
            ->where(function ($query) use ($search, $data) {
                if (count($search) > 0) {
                    $query->where($search);
                }
                if (isset($data['keyword'])) {
                    $query->where([
                        ['users.name', 'LIKE', '%' . $data['keyword'] . '%']
                    ]);
                }
                if (isset($data['price'])) {
                    $query->whereRaw($data['price'] . " BETWEEN from_price AND to_price");
                }
            })
            ->whereRaw("NOW() BETWEEN DATE(membership_date) AND DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY))");

        $count = $vendors->distinct()->get(['users.id'])->count();


        $vendors = $vendors->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->distinct()
            ->orderBy('membership_id', 'DESC')
            ->get(['users.id', 'category_id', 'from_price', 'to_price', 'city_id'
                , 'membership_id', 'name', 'category_questions']);

        $vendors = new Paginator(VendorResource::collection($vendors), $count, $per_page);
        return [
            'data' => $vendors,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function toggleFavourite(array $data)
    {
        $user = auth()->user();
        $statistics = Statistics::where([
            'user_id' => $user->id,
            'vendor_id' => $data['vendor_id'],
            'type' => StatisticsType::LIKE
        ])->first();
        if ($statistics) {
            $statistics->forceDelete();
            return [
                'data' => [
                    'is_favourite' => 0
                ],
                'message' => trans('api.unliked_message'),
                'code' => HttpCode::SUCCESS
            ];
        } else {
            Statistics::create([
                'user_id' => $user->id,
                'vendor_id' => $data['vendor_id'],
                'type' => StatisticsType::LIKE
            ]);
            return [
                'data' => [
                    'is_favourite' => 1
                ],
                'message' => trans('api.liked_message'),
                'code' => HttpCode::SUCCESS
            ];
        }
    }

    public static function getVendorDetails(array $data)
    {
        $vendor = User::join('vendors', 'users.id', '=', 'vendors.user_id')
            ->where([
                'role' => UserRoles::VENDOR,
                'status' => UserStatus::ACTIVE,
                ['membership_id', '!=', null],
                'users.id' => $data['id']
            ])
            ->whereRaw("NOW() BETWEEN DATE(membership_date) AND DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY))")
            ->first(['users.id', 'category_id', 'from_price', 'to_price', 'city_id'
                , 'membership_id', 'name', 'biography', 'phone', 'website',
                'category_questions', 'instagram', 'facebook', 'locations']);
        if ($vendor) {
            Statistics::create([
                'user_id' => auth()->user()->id,
                'vendor_id' => $vendor->id,
                'type' => StatisticsType::VISIT
            ]);
            return [
                'data' => VendorDetailsResource::make($vendor),
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        } else {
            return [
                'message' => 'error',
                'code' => HttpCode::ERROR
            ];
        }
    }

    public static function reviewFavourite(array $data)
    {
        $review = Review::create([
            'user_id' => auth()->user()->id,
            'vendor_id' => $data['vendor_id'],
            'rate' => $data['rate'],
            'comment' => (isset($data['comment'])) ? $data['comment'] : null,
            'is_help' => $data['is_help'],
            'name' => $data['name']
        ]);
        if ($review) {
            return [
                'message' => trans('api.done_successfully'),
                'code' => HttpCode::SUCCESS
            ];
        } else {
            return [
                'message' => trans('api.general_error_message'),
                'code' => HttpCode::ERROR
            ];
        }
    }

    public static function getVendorReviews(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $reviews = Review::where(['vendor_id' => $data['id']])
            ->orderBy('id', 'DESC');

        $count = $reviews->get()->count();
        $reviews = $reviews->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->distinct()
            ->get();
        $reviews = new Paginator(ReviewResource::collection($reviews), $count, $per_page);
        return [
            'data' => $reviews,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getVendorPackages(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $packages = Package::where(['user_id' => $data['id']])
            ->orderBy('id', 'DESC');

        $count = $packages->get()->count();
        $packages = $packages->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->distinct()
            ->get();
        $packages = new Paginator(PackageResource::collection($packages), $count, $per_page);
        return [
            'data' => $packages,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function clickVendorContact(array $data)
    {
        Statistics::create([
            'user_id' => auth()->user()->id,
            'vendor_id' => $data['vendor_id'],
            'type' => StatisticsType::CLICK
        ]);
        return [
            'message' => trans('api.done_successfully'),
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getFavouriteVendors(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $vendors = User::join('vendors', 'users.id', '=', 'vendors.user_id')
            ->join('statistics', 'statistics.vendor_id', '=', 'users.id')
            ->where([
                'statistics.user_id' => auth()->user()->id,
                'statistics.type' => StatisticsType::LIKE,
                'role' => UserRoles::VENDOR,
                'status' => UserStatus::ACTIVE,
                ['membership_id', '!=', null],
            ])
            ->whereRaw("NOW() BETWEEN DATE(membership_date) AND DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY))");

        $count = $vendors->distinct()->get(['users.id'])->count();


        $vendors = $vendors->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->distinct()
            ->orderBy('membership_id', 'DESC')
            ->get(['users.id', 'category_id', 'from_price', 'to_price', 'city_id'
                , 'membership_id', 'name', 'category_questions']);
        $vendors = new Paginator(VendorResource::collection($vendors), $count, $per_page);
        return [
            'data' => $vendors,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

}
