<?php
namespace App\Repositories\Dashboard\Event;


use App\Models\Event;
use App\Repositories\General\UtilsRepository;
use Yajra\DataTables\Facades\DataTables;

class EventRepository
{

    // get Events and create datatable data.
    public static function getEventsData(array $data)
    {
        $events = Event::get();
        return DataTables::of($events)
            ->addColumn('short_description', function ($event) {
                return $event->short_description;
            })
            ->addColumn('time', function ($event) {
                return $event->from . ' - ' . $event->to;
            })
            ->addColumn('actions', function ($event) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $event->id . '" href="' . url('/event/edit/' . $event->id) . '" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $event->id . '" onclick="deleteEvent(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addEvent(array $data)
    {
        $eventData = [
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'short_description_ar' => $data['short_description_ar'],
            'short_description_en' => $data['short_description_en'],
            'description_ar' => $data['description_ar'],
            'description_en' => $data['description_en'],
            'date' => $data['date'],
            'from' => date('H:i:s', strtotime($data['from'])),
            'to' => date('H:i:s', strtotime($data['to'])),
            'link' => ($data['type'] === 'online') ? $data['link'] : null,
            'lat' => ($data['type'] === 'offline') ? $data['latitude'] : null,
            'long' => ($data['type'] === 'offline') ? $data['longitude'] : null,
        ];
        //logo
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'logo';
        $image_path = 'uploads/events/';
        $eventData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id , true);
        if ($eventData['logo'] === false) {
            unset($eventData['logo']);
        }
        //image
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'image';
        $image_path = 'uploads/events/';
        $eventData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id , true);
        if ($eventData['image'] === false) {
            unset($eventData['image']);
        }
        $created = Event::create($eventData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteEvent(array $data)
    {
        $event = Event::where(['id' => $data['id']])->first();
        if ($event) {
            if(file_exists($event->logo)){
                unlink($event->logo);
            }
            if(file_exists($event->image)){
                unlink($event->image);
            }
            $event->forceDelete();
            return true;
        }
        return false;
    }

    public static function changeEvent(array $data)
    {
        $event = Event::where(['id' => $data['id']])->first();
        if ($event) {
            $event->update(['is_active' => !$event->is_active]);
            return true;
        }
        return false;
    }

    public static function getEventData(array $data)
    {
        $event = Event::where(['id' => $data['id']])->first();
        if ($event) {
            return $event;
        }
        return false;
    }

    public static function editEvent(array $data)
    {
        $event = Event::where(['id' => $data['id']])->first();
        if ($event) {
            $eventData = [
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'short_description_ar' => $data['short_description_ar'],
                'short_description_en' => $data['short_description_en'],
                'description_ar' => $data['description_ar'],
                'description_en' => $data['description_en'],
                'date' => $data['date'],
                'from' => date('H:i:s', strtotime($data['from'])),
                'to' => date('H:i:s', strtotime($data['to'])),
                'link' => ($data['type'] === 'online') ? $data['link'] : null,
                'lat' => ($data['type'] === 'offline') ? $data['latitude'] : null,
                'long' => ($data['type'] === 'offline') ? $data['longitude'] : null,
            ];
            //logo
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'logo';
            $image_path = 'uploads/events/';
            $eventData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id , true);
            if ($eventData['logo'] === false) {
                unset($eventData['logo']);
            } else {
                if ($event->logo !== null && file_exists($event->logo)) {
                    unlink($event->logo);
                }
            }
            // image
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/events/';
            $eventData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id , true);
            if ($eventData['image'] === false) {
                unset($eventData['image']);
            } else {
                if ($event->image !== null && file_exists($event->image)) {
                    unlink($event->image);
                }
            }
            $updated = $event->update($eventData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
