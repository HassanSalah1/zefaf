<?php

namespace App\Http\Controllers\Dashboard\Video;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Video\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class VideoController extends Controller
{
    //
    public function showVideos()
    {
        $data['title'] = trans('admin.videos_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'videos';
        $data['debatable_names'] = array(trans('admin.name_arabic'),
            trans('admin.name_english'), trans('admin.video') , trans('admin.actions'));
        return view('admin.video.index')->with($data);
    }

    public function getVideosData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return VideoService::getVideosData($data);
    }

    public function addVideo(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return VideoService::addVideo($data);
    }

    public function deleteVideo(Request $request)
    {
        $data = $request->all();
        return VideoService::deleteVideo($data);
    }

    public function getVideoData(Request $request)
    {
        $data = $request->all();
        return VideoService::getVideoData($data);
    }

    public function editVideo(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return VideoService::editVideo($data);
    }

    public function changeVideo(Request $request){
        $data = $request->all();
        return VideoService::changeVideo($data);
    }

}
