<?php

namespace App\Repositories\Api\Client;

use App\Entities\HttpCode;
use App\Http\Resources\CategoryResource;
use App\Models\Setting\Category;
use App\Models\User\CategoryStatistics;
use App\Models\User\Client;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ActionRepository
{

    public static function setWeddingDate(array $data): array
    {
        $user = Auth::user();
        $client = Client::where(['user_id' => $user->id])->first();
        if ($client) {
            $client->update([
                'user_id' => $user->id,
                'wedding_date' => (isset($data['wedding_date'])) ?
                    date('Y-m-d H:i:s', strtotime($data['wedding_date'])) : $client->wedding_date,
                'partner_name' => (isset($data['partner_name'])) ? $data['partner_name'] : $client->partner_namel
            ]);
        } else {
            $client = Client::create([
                'user_id' => $user->id,
                'wedding_date' => (isset($data['wedding_date'])) ?
                    date('Y-m-d H:i:s', strtotime($data['wedding_date'])) : null,
                'partner_name' => (isset($data['partner_name'])) ? $data['partner_name'] : null
            ]);
        }
        return [
            'data' => [
                'original_wedding_date' => $client->wedding_date,
                'wedding_date' => $client->wedding_date !== null  ?
                    UtilsRepository::calcDiffDates($client->wedding_date) : null,
                'partner_name' => $client->partner_name
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getWeddingDate(array $data)
    {
        $user = Auth::user();
        $client = Client::where(['user_id' => $user->id])->first();
        return [
            'data' => [
                'original_wedding_date' => $client && $client->wedding_date ?
                    $client->wedding_date : null,
                'wedding_date' => $client && $client->wedding_date !== null ?
                    UtilsRepository::calcDiffDates($client->wedding_date) : null,
                'partner_name' => $client && $client->partner_name ? $client->partner_name : null
            ],
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getCategoryTips(array $data)
    {
        $category = Category::where(['is_deleted' => 0])
            ->where(function ($query) use ($data) {
                $query->where('name_ar', 'LIKE', '%' . $data['keyword'] . '%')
                    ->orWhere('name_en', 'LIKE', '%' . $data['keyword'] . '%');
            })
            ->first();
        if ($category) {
            $locale = App::getLocale();
            return [
                'data' => [
                    'name' => $category->name,
                    'tips' => ($category->tips !== null) ?
                        collect(json_decode($category->tips, true))->pluck($locale)->toArray() : []
                ],
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

    public static function getCategories(array $data)
    {
        $categories = Category::where(['is_deleted' => 0, 'category_id' => null])->get();
        return [
            'data' => CategoryResource::collection($categories),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getSubCategories(array $data)
    {
        $categories = Category::where(['is_deleted' => 0, 'category_id' => $data['category_id']])->get();
        return [
            'data' => CategoryResource::collection($categories),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function clickCategories(array $data)
    {
        CategoryStatistics::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'category_id' => $data['category_id'],
        ]);
        return [
            'message' => trans('api.done_successfully'),
            'code' => HttpCode::SUCCESS
        ];
    }
}
