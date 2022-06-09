<?php

namespace App\Repositories\Api\Home;

use App\Entities\HttpCode;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventsResource;
use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class EventApiRepository
{
    public static function getDates()
    {
        $Events = Event::get()->groupBy('date')->map(function ($map) {
            return [
                'date' => $map->first()->date,
                'numbers' => $map->count()
            ];
        })->toArray();

        return [
            'data' => array_values($Events),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getEvents(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);
//          ?
        $Events = Event::where(function ($query) use ($data) {
                if((isset($data['date']))){
                    $date = date('Y-m-d', strtotime($data['date']));
                    $query->where('date', '=', $date);
                }
                if (isset($data['keyword'])) {
                    $query->where(function ($query2) use ($data){
                        $query2->where('name_ar', 'LIKE', '%' . $data['keyword'] . '%');
                        $query2->orWhere('name_en', 'LIKE', '%' . $data['keyword'] . '%');
                    });
                }
            })->orderBy('id', 'desc');
        $count = $Events->get()->count();
        $Events = $Events->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->get();
        $Events = new Paginator(EventsResource::collection($Events), $count, $per_page);
        return [
            'data' => $Events,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getEventData(array $data)
    {
        $Event = Event::where(['id' => $data['id']])->first();
        if ($Event) {
            $Event = new EventResource($Event);
            return [
                'data' => $Event,
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
