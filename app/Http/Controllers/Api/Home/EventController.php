<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Services\Api\Home\EventApiService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //

    public function getDates()
    {
        return EventApiService::getDates();
    }

    public function getEvents(Request $request)
    {
        $data = $request->all();
        return EventApiService::getEvents($data);
    }

    public function getEventData(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return EventApiService::getEventData($data);
    }
}
