<?php

namespace App\Http\Controllers\Dashboard\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Dashboard\Event\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EventController extends Controller
{
    //
    public function showEvents()
    {
        $data['title'] = trans('admin.events_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'events';
        $data['debatable_names'] = array(trans('admin.title_arabic'), trans('admin.title_english'),
            trans('admin.date') , trans('admin.time'), trans('admin.actions'));
        return view('admin.event.index')->with($data);
    }

    public function getEventsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return EventService::getEventsData($data);
    }

    public function showAddEvent(Request $request)
    {
        $data['title'] = trans('admin.add_event');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'events';
        return view('admin.event.add_event')->with($data);
    }

    public function addEvent(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return EventService::addEvent($data);
    }

    public function deleteEvent(Request $request)
    {
        $data = $request->all();
        return EventService::deleteEvent($data);
    }

    public function getEventData(Request $request)
    {
        $data = $request->all();
        return EventService::getEventData($data);
    }
    public function showEditEvent(Request $request , $id)
    {
        $event = Event::where(['id' => $id])->first();
        if(!$event) {
            return redirect()->to(url('/events'));
        }
        $data['event'] = $event;
        $data['title'] = trans('admin.edit_event');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'events';
        return view('admin.event.edit_event')->with($data);
    }

    public function editEvent(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return EventService::editEvent($data);
    }

    public function changeEvent(Request $request)
    {
        $data = $request->all();
        return EventService::changeEvent($data);
    }

}
