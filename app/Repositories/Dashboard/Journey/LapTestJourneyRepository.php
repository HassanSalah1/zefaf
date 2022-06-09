<?php
namespace App\Repositories\Dashboard\Journey;


use App\Entities\DeviceType;
use App\Entities\NotificationType;
use App\Models\Journey;
use App\Models\Lap;
use App\Models\LapTest;
use App\Models\LapTestJourney;
use App\Models\User\Notification;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class LapTestJourneyRepository
{

    // get lapTests journey and create datatable data.
    public static function getLapTestJourneyData(array $data)
    {
        $lapTests = LapTestJourney::join('journeys', 'lap_test_journeys.journey_id', '='
            , 'journeys.id')->where(['status' => 0, 'lap_id' => null])
            ->get(['lap_test_journeys.id', 'lap_test_id', 'lap_id', 'address', 'requested_date'
                , 'from', 'to' , 'user_id']);
        return DataTables::of($lapTests)
            ->addColumn('lap_test', function ($lapTest) {
                $lapTest = LapTest::where(['id' => $lapTest->lap_test_id])->first();
                return ($lapTest) ? $lapTest->name : null;
            })
            ->addColumn('userName', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->name : null;
            })
            ->addColumn('phone', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->phone : null;
            })
            ->addColumn('actions', function ($lapTest) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.assign_lap') . '" id="' . $lapTest->id . '" onclick="editLapTest(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                return $ul;
            })->make(true);
    }

    public static function assignLap(array $data)
    {
        $lapTestJourney = LapTestJourney::where(['id' => $data['id']])->first();
        if ($lapTestJourney) {
            $lapTestJourney->update(['lap_id' => $data['lap_id']]);

            // notification
            $journey = Journey::where(['id' => $lapTestJourney->journey_id])->first();
            $user = User::where(['id' => $journey->user_id])->first();
            $locale = App::getLocale();
            App::setLocale($user->lang);
            $notification_obj = [
                'title_key' => 'notification_lap_message_title',
                'message_key' => 'notification_lap_message_message',
                'user_id' => $user->id,
                'lap_test_journey_id' => $lapTestJourney->id,
                'type' => NotificationType::LAPTESTS
            ];
            if ($user->device_token != null) {
                // send push notification
                $lap = Lap::where(['id' => $data['lap_id']])->first();
                $notification_data = [
                    'title' => trans('api.' . $notification_obj['title_key']),
                    'message' => str_replace(['{lap}'],
                        [$lap->name],
                        trans('api.' . $notification_obj['message_key'])),
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $user->id,
                    'lap_test_journey_id' => $lapTestJourney->id,
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
            App::setLocale($locale);
            // end notification
            return true;
        }
        return false;
    }


}

?>
