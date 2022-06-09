<?php
namespace App\Services\Dashboard\Event;

use App\Repositories\Dashboard\Event\EventRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class EventService
{


    public static function getEventsData(array $data)
    {
        return EventRepository::getEventsData($data);
    }

    public static function addEvent(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'logo' => 'required',
            'image' => 'required',
            'type' => 'required'
        ];
        if (isset($data['type']) && $data['type'] === 'online') {
            $rules['link'] = 'required';
        }else if (isset($data['type']) && $data['type'] === 'offline') {
            $rules['latitude'] = 'required';
            $rules['longitude'] = 'required';
        }
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = EventRepository::addEvent($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteEvent(array $data)
    {
        $response = EventRepository::deleteEvent($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeEvent(array $data)
    {
        $response = EventRepository::changeEvent($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getEventData(array $data)
    {
        $response = EventRepository::getEventData($data);
        return UtilsRepository::response($response);
    }

    public static function editEvent(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'type' => 'required'
        ];
        if (isset($data['type']) && $data['type'] === 'online') {
            $rules['link'] = 'required';
        }else if (isset($data['type']) && $data['type'] === 'offline') {
            $rules['latitude'] = 'required';
            $rules['longitude'] = 'required';
        }
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = EventRepository::editEvent($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
