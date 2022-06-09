<?php

namespace App\Repositories\Api\Home;

use App\Entities\HttpCode;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\PharmaciesResource;
use App\Models\Pharmacy;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class PharmacyApiRepository
{

    public static function getPharmacies(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);
        $search = [];
        if(isset($data['city_id'])) {
            $search['city_id'] = $data['city_id'];
        }
        $pharmacies = Pharmacy::where($search)
            ->where(function ($query) use ($data) {
                if (isset($data['keyword'])) {
                    $query->where('name_ar' , 'LIKE', '%'. $data['keyword']. '%');
                    $query->orWhere('name_en' , 'LIKE', '%'. $data['keyword']. '%');
                }
            })
            ->orderBy('id', 'desc');
        $count = $pharmacies->get()->count();
        $pharmacies = $pharmacies->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->get();
        $pharmacies = new Paginator(PharmaciesResource::collection($pharmacies), $count, $per_page);
        return [
            'data' => $pharmacies,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getPharmacyData(array $data)
    {
        $pharmacy = Pharmacy::where(['id' => $data['id']])->first();
        if ($pharmacy) {
            $pharmacy = new PharmacyResource($pharmacy);
            return [
                'data' => $pharmacy,
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }
}
