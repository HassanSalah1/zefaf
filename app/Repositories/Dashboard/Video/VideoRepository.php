<?php
namespace App\Repositories\Dashboard\Video;


use App\Entities\DeviceType;
use App\Entities\NotificationType;
use App\Entities\UserRoles;
use App\Models\Journey;
use App\Models\Lap;
use App\Models\User\Notification;
use App\Models\User\User;
use App\Models\Video;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class VideoRepository
{

    // get Videos and create datatable data.
    public static function getVideosData(array $data)
    {
        $videos = Video::get();
        return DataTables::of($videos)
            ->editColumn('video', function ($video) {
                return '<video width="320" height="150" controls>
                          <source src="' . url($video->video) . '" type="video/mp4">
                        </video>';
            })
            ->addColumn('actions', function ($video) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $video->id . '" onclick="editVideo(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $video->id . '" onclick="deleteVideo(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addVideo(array $data)
    {
        $videoData = [
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'short_description_ar' => $data['short_description_ar'],
            'short_description_en' => $data['short_description_en'],
        ];
        $file_id = 'VIDEO_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $video_name = 'video';
        $video_path = 'uploads/videos/';
        $videoData['video'] = UtilsRepository::uploadFiles($data['request'], $video_name, $video_path, $file_id);
        if ($videoData['video'] === false) {
            unset($videoData['video']);
        }
        $image_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'photo';
        $image_path = 'uploads/videos/image/';
        $videoData['photo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $image_id);
        if ($videoData['photo'] === false) {
            unset($videoData['photo']);
        }
        //return $videoData;
        $created = Video::create($videoData);
        if ($created) {

            // notification
            $users = User::where(['role' => UserRoles::CUSTOMER])->get();
            if(count($users) > 0) {
                $locale = App::getLocale();
                foreach ($users as $user){
                    App::setLocale($user->lang);
                    $notification_obj = [
                        'title_key' => 'notification_video_message_title',
                        'message_key' => 'notification_video_message_message',
                        'user_id' => $user->id,
                        'video_id' => $created->id,
                        'type' => NotificationType::VIDEOS
                    ];
                    // send push notification
                    if ($user->device_token !== null) {
                        $notification_data = [
                            'title' => trans('api.' . $notification_obj['title_key']),
                            'message' => str_replace(['{video}'],
                                [$created->title],
                                trans('api.' . $notification_obj['message_key'])),
                        ];
                        $notification_data_obj = array_merge($notification_data, [
                            'user_id' => $user->id,
                            'video_id' => $created->id,
                            'type' => $notification_obj['type']
                        ]);
                        if ($user->device_type == DeviceType::IOS) {
                            UtilsRepository::sendIosFCM($notification_data, $notification_data_obj, $user->device_token);
                        } else if ($user->device_type == DeviceType::ANDROID) {
                            UtilsRepository::sendAndroidFCM($notification_data_obj, $user->device_token);
                        }
                    }
                    // save notification
                    Notification::create($notification_obj);
                }
                App::setLocale($locale);
            }
            // end notification

            return true;
        }
        return false;
    }

    public static function deleteVideo(array $data)
    {
        $video = Video::where(['id' => $data['id']])->first();
        if ($video) {
            $video->forceDelete();
            return true;
        }
        return false;
    }

    public static function changeVideo(array $data)
    {
        $video = Video::where(['id' => $data['id']])->first();
        if ($video) {
            $video->update(['is_active' => !$video->is_active]);
            return true;
        }
        return false;
    }

    public static function getVideoData(array $data)
    {
        $video = Video::where(['id' => $data['id']])->first();
        if ($video) {
            return $video;
        }
        return false;
    }

    public static function editVideo(array $data)
    {
        $video = Video::where(['id' => $data['id']])->first();
        if ($video) {
            $videoData = [
                'title_ar' => $data['title_ar'],
                'title_en' => $data['title_en'],
                'short_description_ar' => $data['short_description_ar'],
                'short_description_en' => $data['short_description_en'],
            ];

            $file_id = 'VIDEO_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $video_name = 'video';
            $video_path = 'uploads/videos/';
            $videoData['video'] = UtilsRepository::uploadFiles($data['request'], $video_name, $video_path, $file_id);
            if ($videoData['video'] === false) {
                unset($videoData['video']);
            } else {
                if ($video->video !== null && file_exists($video->video)) {
                    unlink($video->video);
                }
            }
            $image_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'photo';
            $image_path = 'uploads/videos/image/';
            $videoData['photo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $image_id);
            if ($videoData['photo'] === false) {
                unset($videoData['photo']);
            }else {
                if ($video->photo !== null && file_exists($video->photo)) {
                    unlink($video->photo);
                }
            }
            
            $updated = $video->update($videoData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
