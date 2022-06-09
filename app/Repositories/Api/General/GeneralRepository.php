<?php

namespace App\Repositories\Api\General;


use App\Entities\AdStatus;
use App\Entities\Constants;
use App\Entities\FollowListStatus;
use App\Entities\HttpCode;
use App\Model\User\Contact;
use App\Models\Ad\Ad;
use App\Models\General\BankAccount;
use App\Models\General\City;
use App\Models\General\Condition;
use App\Models\General\Country;
use App\Models\General\Image;
use App\Models\General\Setting;
use App\Models\User\FollowList;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;

class GeneralRepository
{

    public static function getHome(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);

        $search = ['status' => AdStatus::PUBLISHED];


        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $search['country_id'] = $data['country_id'];
        }
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $search['city_id'] = $data['city_id'];
        }

        $ads = Ad::where($search)
            ->where(function ($query) use ($data) {

                $query->whereRaw('DATE_ADD(showed_at,INTERVAL 14 DAY) >= ?', [date('y-m-d')]);
                if (isset($data['latitude']) && isset($data['longitude']))
                    $query->whereRaw("( 6371 * acos( cos( radians(" . $data['latitude'] . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $data['longitude'] . ") ) + sin( radians(" . $data['latitude'] . ") ) * sin( radians( latitude ) ) ) ) <= 10");
                if (isset($data['user']) && $data['user']) {
                    $blockListIds = FollowList::where([
                        'user_id' => $data['user']->id,
                        'status' => FollowListStatus::BLOCK
                    ])->pluck('follower_id')->toArray();
                    $otherBlockListIds = FollowList::where([
                        'follower_id' => $data['user']->id,
                        'status' => FollowListStatus::BLOCK
                    ])->pluck('user_id')->toArray();


                    if (count($blockListIds) > 0)
                        $query->whereNotIn('user_id', $blockListIds);
                    if (count($otherBlockListIds) > 0)
                        $query->whereNotIn('user_id', $otherBlockListIds);

                }

                if (isset($data['type']) && !empty($data['type'])) {
                    $data['type'] = json_decode(urldecode($data['type']), true);
                    $query->whereIn('type', $data['type']);
                }

                if (isset($data['purpose']) && !empty($data['purpose'])) {
                    $data['purpose'] = json_decode(urldecode($data['purpose']), true);
                    $query->whereIn('purpose', $data['purpose']);
                }
            })
            ->orWhere(function ($query) use ($data) {
                if (isset($data['user']) && $data['user']) {
                    $query->where([
                        'status' => AdStatus::HIDDEN,
                        'user_id' => $data['user']->id
                    ]);
                    $followListIds = FollowList::where([
                        'user_id' => $data['user']->id,
                        'status' => FollowListStatus::FOLLOW
                    ])->pluck('follower_id')->toArray();
                    if (count($followListIds) > 0)
                        $query->orWhereIn('user_id', $followListIds);
                }
            });


        if (isset($data['date']) && !empty($data['date'])) {
            $ads = $ads->orderBy('showed_at', $data['date']);
        }else{
            $ads = $ads->orderBy('id', 'DESC');
        }

        $count = $ads->count();
        $ads = $ads->get(['id', 'images', 'title', 'showed_at', 'country_id', 'city_id'
            , 'street', 'extra_data', 'payment', 'currency', 'purpose', 'latitude'
            , 'longitude', 'type', 'purpose'
        ])->each(function ($ad) {
            $ad->basicInfo();
        });

        $ads = collect($ads);

        if (isset($data['price_from']) && !empty($data['price_from'])
            && isset($data['price_to']) && !empty($data['price_to'])) {
            $ads = $ads->where('price', '>=', $data['price_from']);
            $ads = $ads->where('price', '<=', $data['price_to']);
        } else if (isset($data['price_from']) && !empty($data['price_from'])) {
            $ads = $ads->where('price', '>=', $data['price_from']);
        } else if (isset($data['price_to']) && !empty($data['price_to'])) {
            $ads = $ads->where('price', '<=', $data['price_to']);
        }

        if (isset($data['price_from']) && !empty($data['price_from'])
            && isset($data['price_to']) && !empty($data['price_to'])) {
            $ads = $ads->where('price', '>=', $data['price_from']);
            $ads = $ads->where('price', '<=', $data['price_to']);
        } else if (isset($data['price_from']) && !empty($data['price_from'])) {
            $ads = $ads->where('price', '>=', $data['price_from']);
        } else if (isset($data['price_to']) && !empty($data['price_to'])) {
            $ads = $ads->where('price', '<=', $data['price_to']);
        }

        if (isset($data['building_area_from']) && !empty($data['building_area_from'])
            && isset($data['building_area_to']) && !empty($data['building_area_to'])) {
            $ads = $ads->where('building_area', '>=', $data['building_area_from']);
            $ads = $ads->where('building_area', '<=', $data['building_area_to']);
        } else if (isset($data['building_area_from']) && !empty($data['building_area_from'])) {
            $ads = $ads->where('building_area', '>=', $data['building_area_from']);
        } else if (isset($data['building_area_to']) && !empty($data['building_area_to'])) {
            $ads = $ads->where('building_area', '<=', $data['building_area_to']);
        }

        if (isset($data['aqar_type']) && !empty($data['aqar_type'])) {
            $ads = $ads->where('aqar_type', $data['aqar_type']);
        }

        if (isset($data['aqar_purpose']) && !empty($data['aqar_purpose'])) {
            $ads = $ads->where('aqar_purpose', $data['aqar_purpose']);
        }

        if (isset($data['rooms_number']) && !empty($data['rooms_number'])) {
            $ads = $ads->where('rooms_number', $data['rooms_number']);
        }

        if (isset($data['rooms_number']) && !empty($data['rooms_number'])) {
            $ads = $ads->where('rooms_number', $data['rooms_number']);
        }

        if (isset($data['bathrooms_number']) && !empty($data['bathrooms_number'])) {
            $ads = $ads->where('bathrooms_number', $data['bathrooms_number']);
        }

        if (isset($data['lounges_number']) && !empty($data['lounges_number'])) {
            $ads = $ads->where('lounges_number', $data['lounges_number']);
        }


        if (isset($data['price']) && !empty($data['price'])
            && strtoupper($data['price']) === 'ASC') {
            $ads = $ads->sortBy('price')->values();
        } else if (isset($data['price']) && !empty($data['price'])
            && strtoupper($data['price']) === 'DESC') {
            $ads = $ads->sortByDesc('price')->values();
        }


        $ads = $ads->forPage($page, $per_page);
        $ads = new Paginator(array_values(collect($ads)->toArray()), $count, $per_page, $page);
        return [
            'data' => $ads,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    // get ad constants ( countries - cities )
    public static function getAdConstants(array $data)
    {
        $response = [];
        $locale = App::getLocale();
        $countries = Country::select(['id', 'name_' . $locale . ' AS name'])->get();

        $temp = [];
        foreach ($countries as $country) {
            $country->cities = City::where(['country_id' => $country->id])
                ->select(['id', 'name_' . $locale . ' AS name'])
                ->get();

            $temp[] = $country;
        }

        $conditions = Condition::select(['condition_' . $locale . ' AS condition'])
            ->get();

        $setting = Setting::select(['app_percent', 'max_percent', 'terms_' . $locale . ' AS terms'
            , 'about_' . $locale . ' AS about', 'facebook', 'twitter', 'linkedin', 'instagram'])
            ->first();

        $banks = BankAccount::select(['id', 'name_' . $locale . ' AS name',
            'logo', 'iban_number' , 'account_name' , 'account_number'])->get()
            ->each(function ($bank) {
                $bank->logo = url($bank->logo);
            });

        $response = [
            'countries' => $temp,
            'conditions' => $conditions,
            'settings' => $setting,
            'banks' => $banks
        ];

        return [
            'data' => $response,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    // upload media
    public static function uploadMedia(array $data)
    {
        $fileData = [
            'ad_id' => $data['ad_id']
        ];
        $file_id = mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        if ($data['type'] === 'image') {
            $image_name = 'file';
            $image_path = 'uploads/images/';
            $fileData['path'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
        } else if ($data['type'] === 'video') {
            $image_name = 'file';
            $filePath = 'uploads/media/';
            $fileData['path'] = UtilsRepository::uploadFiles($data['request'], $image_name, $filePath, $file_id);
        }
        if ($fileData['path'] !== false) {
            $fileData['image_id'] = $file_id;
            $created = Image::create($fileData);
            if ($created) {
                $fileData['path'] = url('/files/' . $file_id);
                return [
                    'data' => $fileData,
                    'message' => 'success',
                    'code' => HttpCode::SUCCESS
                ];
            }
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    // get files
    public static function getFiles(array $data)
    {
        $image = Image::where(['image_id' => $data['id']])->first();
        if ($image) {
            return response()->file($image->path);
        }
        return abort(404);
    }

    public static function contact(array $data)
    {
        $contactData = [
            'title' => $data['title'],
            'message' => $data['message'],
            'status' => Constants::UNSEEN
        ];

        if ($data['user']) {
            $contactData['user_id'] = $data['user']->id;
        }else{

            $contactData = array_merge($contactData , [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);
        }
        $contact = Contact::create($contactData);
        if ($contact) {
            return [
                'message' => trans('api.done_successfully'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

}
