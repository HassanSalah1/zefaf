<?php

namespace App\Repositories\Api\Vendor;

use App\Entities\EditRequestStatus;
use App\Entities\HttpCode;
use App\Entities\MembershipType;
use App\Entities\StatisticsType;
use App\Entities\UserStatus;
use App\Http\Resources\ImageResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ReviewResource;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\Setting\Membership;
use App\Models\User\EditRequest;
use App\Models\User\Notification;
use App\Models\User\Package;
use App\Models\User\Review;
use App\Models\User\Statistics;
use App\Models\User\UserImage;
use App\Models\User\Vendors;
use App\Repositories\General\UtilsRepository;
use GuzzleHttp\RequestOptions;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayMob;

class VendorActionsRepository
{

    public static function startFreeTrial(array $data)
    {
        $user = auth()->user();
        $vendor = Vendors::where(['user_id' => $user->id])->first();
        if ($vendor && $vendor->membership_id === null && $user->status === UserStatus::ACTIVE) {
            $membership = Membership::where(['type' => MembershipType::FREE, 'is_active' => 1])
                ->first();
            if ($membership) {
                $vendor->update([
                    'membership_id' => $membership->id,
                    'membership_duration' => $membership->duration,
                    'membership_date' => date('Y-m-d')
                ]);
                return [
                    'message' => trans('api.done_successfully'),
                    'code' => HttpCode::SUCCESS
                ];
            }
        }

        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    public static function getMyPackages(array $data)
    {
        $user = auth()->user();
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $packages = Package::where(['user_id' => $user->id])
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

    public static function addPackage(array $data)
    {
        $user = auth()->user();
        $packageData = [
            'title' => $data['title'],
            'price' => $data['price'],
            'description' => $data['description'],
            'user_id' => $user->id
        ];
        $package = Package::create($packageData);
        if ($package) {
            return [
                'data' => PackageResource::make($package),
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

    public static function editPackage(array $data)
    {
        $user = auth()->user();
        $package = Package::where(['user_id' => $user->id, 'id' => $data['id']])->first();
        if ($package) {
            $packageData = [
                'title' => $data['title'],
                'price' => $data['price'],
                'description' => $data['description'],
                'user_id' => $user->id
            ];
            $package->update($packageData);
            return [
                'data' => PackageResource::make($package),
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

    public static function deletePackage(array $data)
    {
        $user = auth()->user();
        $package = Package::where(['user_id' => $user->id, 'id' => $data['id']])->first();
        if ($package) {
            $package->forceDelete();
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

    public static function getProfile(array $data)
    {
        $user = auth()->user();
        $city = City::where(['id' => $user->city_id])->first();
        $country = $city ? Country::where(['id' => $city->country_id])->first() : null;
        $vendor = Vendors::where(['user_id' => $user->id])
            ->select(DB::raw("DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY)) AS end_membership_date"),
                'biography', 'category_id', 'from_price', 'to_price', 'membership_id', 'membership_duration',
                'membership_date', 'category_questions', 'locations', 'website', 'instagram', 'facebook')
            ->first();
        $category = Category::where(['id' => $vendor->category_id])->first();
        $sub_category = null;
        if ($category->category_id) {
            $sub_category = Category::where(['id' => $category->category_id])->first();
        }
        $membership = Membership::where(['id' => $vendor->membership_id])->first();

        $reviews = Review::where(['vendor_id' => $user->id])->get();


        return [
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'lang' => $user->lang,
                'images' => ImageResource::collection($user->vendor_images),
                'city' => [
                    'id' => @$city->id,
                    'name' => @$city->name
                ],
                'country' => [
                    'id' => @$country->id,
                    'name' => @$country->name
                ],
                'biography' => $vendor->biography,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'question_type' => $category->question_type,
                    'main_category' => [
                        'id' => $sub_category ? $sub_category->id : null,
                        'name' => $sub_category ? $sub_category->name : null,
                    ]
                ],
                'from_price' => $vendor->from_price,
                'to_price' => $vendor->to_price,
                'membership' => [
                    'id' => $membership ? $membership->id : null,
                    'type' => $membership ? $membership->type : null,
                    'duration' => $vendor->membership_duration,
                    'start_date' => date('d/m/Y' , strtotime($vendor->membership_date)),
                    'end_date' => date('d/m/Y' , strtotime($vendor->end_membership_date)),
                ],
                'category_questions' => $vendor->category_questions !== null ?
                    json_decode($vendor->category_questions, true) : null,
                'website' => $vendor->website,
                'instagram' => $vendor->instagram,
                'facebook' => $vendor->facebook,
                'locations' => $vendor->locations ? json_decode($vendor->locations, true) : [],
                'reviews_count' => count($reviews),
                'reviews' => count($reviews) > 0 ? collect($reviews)->sum('rate') / count($reviews) : 0,
                'notifications_count' => Notification::where(['user_id' => auth()->user()->id, 'read' => 0])->count()
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function editProfile(array $data)
    {
        $user = auth()->user();
        $vendor = Vendors::where(['user_id' => $user->id])->first();
        $editRequestData = [];
        if (isset($data['name']) && $user->name !== $data['name']) {
            $editRequestData['name'] = $data['name'];
        }
        if (isset($data['phone']) && $user->phone !== $data['phone']) {
            $editRequestData['phone'] = $data['phone'];
        }
        if (isset($data['email']) && $user->email !== $data['email']) {
            $editRequestData['email'] = $data['email'];
        }
        if (isset($data['city_id']) && $user->city_id !== $data['city_id']) {
            $editRequestData['city_id'] = $data['city_id'];
        }
        if (isset($data['biography']) && $vendor->biography !== $data['biography']) {
            $editRequestData['biography'] = $data['biography'];
        }
        if (isset($data['from_price']) && $vendor->from_price !== $data['from_price']) {
            $editRequestData['from_price'] = $data['from_price'];
        }
        if (isset($data['to_price']) && $vendor->to_price !== $data['to_price']) {
            $editRequestData['to_price'] = $data['to_price'];
        }
        if (isset($data['instagram']) && $vendor->instagram !== $data['instagram']) {
            $editRequestData['instagram'] = $data['instagram'];
        }
        if (isset($data['facebook']) && $vendor->facebook !== $data['facebook']) {
            $editRequestData['facebook'] = $data['facebook'];
        }
        if (isset($data['website']) && $vendor->website !== $data['website']) {
            $editRequestData['website'] = $data['website'];
        }


        if (isset($data['locations'])) {
            $editRequestData['locations'] = $data['locations'];
        }

        if (isset($data['category_questions'])) {
            $editRequestData['category_questions'] = $data['category_questions'];
        }

        if (count($editRequestData) > 0) {
            $editRequestData['status'] = EditRequestStatus::PENDING;
            $editRequestData['user_id'] = $user->id;
            EditRequest::where(['status' => EditRequestStatus::PENDING, 'user_id' => $user->id])
                ->forceDelete();
            EditRequest::create($editRequestData);
            return [
                'message' => trans('api.edit_request_saved'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.no_data_changed'),
            'code' => HttpCode::ERROR
        ];
    }

    public static function getMyReviews(array $data)
    {
        $user = auth()->user();
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $reviews = Review::where(['vendor_id' => $user->id])
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

    public static function getStatistics(array $data)
    {
        $vendor = auth()->user();
        $year = date('Y');
        if (isset($data['year']) && !empty($data['year'])) {
            $year = $data['year'];
        }


        $statisticsClick = Statistics::where([
            'type' => StatisticsType::CLICK,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)->get();
        $statisticsVisit = Statistics::where([
            'type' => StatisticsType::VISIT,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)->get();
        $statisticsLike = Statistics::where([
            'type' => StatisticsType::LIKE,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)->get();


        $statisticsClickDetails = Statistics::where([
            'type' => StatisticsType::CLICK,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();
        $statisticsVisitDetails = Statistics::where([
            'type' => StatisticsType::VISIT,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();
        $statisticsLikeDetails = Statistics::where([
            'type' => StatisticsType::LIKE,
            'vendor_id' => $vendor->id
        ])->whereYear('created_at', '=', $year)
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, $year));
            $click = collect($statisticsClickDetails)->where('month', '=', $month)->first();
            $visit = collect($statisticsVisitDetails)->where('month', '=', $month)->first();
            $like = collect($statisticsLikeDetails)->where('month', '=', $month)->first();

            $months[] = [
                'name' => $month,
                'analytics' => [
                    'click' => $click ? $click->count : 0,
                    'visit' => $visit ? $visit->count : 0,
                    'like' => $like ? $like->count : 0
                ]
            ];
        }

        return [
            'data' => [
                'visits' => count($statisticsVisit),
                'clicks' => count($statisticsClick),
                'likes' => count($statisticsLike),
                'statistics' => $months,
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function renewPackage(array $data)
    {
        $package = Membership::where(['id' => $data['package_id']])->first();
        if ($package && $package->type !== MembershipType::FREE) {
            $discount = ($package->discount ? $package->discount : 0);
            if ($discount > 0) {
                $discount = $package->price * ($discount / 100);
            }
            //$price = ($package->price - $discount) * $data['duration'];
            $price = $package->price;
            $auth = PayMob::authPaymob();
            //
            $orderID = auth()->user()->id . 'A' . $package->id . 'A' .
                $data['duration'] . 'A' .
                strtotime(date('Y-m-d')) . UtilsRepository::createVerificationCode($package->id, 5);
            //
            $paymobOrder = PayMob::makeOrderPaymob(
                $auth->token, // this is token from step 1.
                $auth->profile->id, // this is the merchant id from step 1.
                $price * 100, // total amount by cents/piasters.
                $orderID
            );

            if ($paymobOrder && isset($paymobOrder->id)) {
                $paymentKey = PayMob::getPaymentKeyPaymob(
                    $auth->token, // from step 1.
                    $price * 100, // total amount by cents/piasters.
                    $paymobOrder->id // paymob order id from step 2.
                );
                if ($paymentKey && isset($paymentKey->token) && request()->type == 'cart') {
                    return [
                        'data' => [
                            'link' => url('/api/v1/handle/payment') . '?key='
                                . $paymentKey->token
                        ],
                        'message' => 'success',
                        'code' => HttpCode::SUCCESS
                    ];
                }elseif($paymentKey && isset($paymentKey->token) && request()->type == 'wallet'){
                    $client = new \GuzzleHttp\Client();

                    $payLoad=[
                        'source'=> [
                        "identifier"=>auth()->user()->phone,
                        "subtype"=>"WALLET",
                    ],
                    "payment_token"=> $paymentKey->token];

                    $URI = 'https://accept.paymob.com/api/acceptance/payments/pay';

                    $response = $client->post(
                        $URI,
                        [
                            RequestOptions::JSON =>
                            $payLoad
                        ],
                        ['Content-Type' => 'application/json']
                    );

                    $responseJSON = json_decode($response->getBody(), true);

                    if(isset($responseJSON['pending']) && isset($responseJSON['success']) && $responseJSON['pending'] == "true"){
                            return [
                                'data' => [
                                    'link' => url('/api/v1/handle/payment_wallet') .'?iframe='
                                        .$responseJSON['iframe_redirection_url']
                                ],
                                'message' => 'success',
                                'code' => HttpCode::SUCCESS
                            ];
                    }else{
                        return [
                            'message' => 'error,mobile not valid or something worng',
                            'code' => HttpCode::ERROR
                        ];
                    }
                }
            }
        }
        return [
            'message' => 'error',
            'code' => HttpCode::ERROR
        ];
    }

    public static function post_pay(array $data)
    {
        Log::warning(json_encode($data));

        if (isset($data['success']) && $data['success'] === "true" && isset($data['merchant_order_id']) && !empty($data['merchant_order_id'])) {

            $merchant_order_id = explode('A', $data['merchant_order_id']);
            if (count($merchant_order_id) >= 3) {
                $user_id = $merchant_order_id[0];
                $vendor = Vendors::where(['user_id' => $user_id])->first();
                $membership = Membership::where('id',$merchant_order_id[0])->first();

                if ($vendor) {

                    $vendor->update([
                        'membership_id' => $merchant_order_id[1],
                        'membership_duration' => $membership->duration,//intval($merchant_order_id[2]) * 30,
                        'membership_date' => date('Y-m-d')
                    ]);
                    return view('payment_success');
                }
            }
        }
        return redirect()->to(url('/api/v1/payment_error'));
    }

    public static function upload(array $data)
    {
        //image
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'image';
        $image_path = 'uploads/users/';
        $userData['image'] = UtilsRepository::createImageFormBase64($data['request'], $image_name, $image_path, $file_id, false);

        if ($userData['image'] === false) {
            return [
                'message' => trans('api.general_error_message'),
                'code' => HttpCode::ERROR
            ];
        } else {
            UserImage::create([
                'user_id' => auth()->id(),
                'image' => $userData['image']
            ]);
        }

        return [
            'data' => [
                'images' => array_map(function ($image) {
                    return url($image);
                }, collect(auth()->user()->vendor_images()->pluck('image'))
                    ->toArray()),
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function removeImage(array $data)
    {
        $image = UserImage::find($data['id']);
        if ($image) {
            $image->forceDelete();
            return [
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => 'error',
            'code' => HttpCode::ERROR
        ];
    }


}

