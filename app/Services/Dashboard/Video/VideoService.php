<?php
namespace App\Services\Dashboard\Video;

use App\Repositories\Dashboard\Video\VideoRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class VideoService
{


    public static function getVideosData(array $data)
    {
        return VideoRepository::getVideosData($data);
    }

    public static function addVideo(array $data)
    {
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
            'video' => 'required',
            // 'photo' => 'required'
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = VideoRepository::addVideo($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteVideo(array $data)
    {
        $response = VideoRepository::deleteVideo($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeVideo(array $data)
    {
        $response = VideoRepository::changeVideo($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getVideoData(array $data)
    {
        $response = VideoRepository::getVideoData($data);
        return UtilsRepository::response($response);
    }

    public static function editVideo(array $data)
    {
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'short_description_ar' => 'required',
            'short_description_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = VideoRepository::editVideo($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
