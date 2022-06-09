<?php
namespace App\Repositories\Dashboard\Journey;


use App\Entities\DeviceType;
use App\Entities\NotificationType;
use App\Models\Journey;
use App\Models\Lap;
use App\Models\LapTest;
use App\Models\LapTestJourney;
use App\Models\Nurse;
use App\Models\NurseVisitJourney;
use App\Models\ProductDeliveryJourney;
use App\Models\User\Notification;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class NurseVisitJourneyRepository
{

    // get lapTests journey and create datatable data.
    public static function getNurseVisitJourneyData(array $data)
    {
        $nurseVisits = NurseVisitJourney::join('journeys', 'nurse_visit_journeys.journey_id', '='
            , 'journeys.id')->where(['status' => 0 , 'nurse_id' => null])
            ->get(['nurse_visit_journeys.id', 'nurse_id', 'address', 'requested_date'
                , 'from', 'to' , 'user_id']);
        return DataTables::of($nurseVisits)
            ->addColumn('userName', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->name : null;
            })
            ->addColumn('phone', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->phone : null;
            })
            ->addColumn('actions', function ($nurseVisit) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.assign_nurse') . '" id="' . $nurseVisit->id . '" onclick="editNurse(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                return $ul;
            })->make(true);
    }


    public static function assignNurse(array $data)
    {
        $nurseVisitJourney = NurseVisitJourney::where(['id' => $data['id']])->first();
        if ($nurseVisitJourney) {
            $nurseVisitJourney->update(['nurse_id' => $data['nurse_id']]);
            // notification
            $journey = Journey::where(['id' => $nurseVisitJourney->journey_id])->first();
            $user = User::where(['id' => $journey->user_id])->first();
            $locale = App::getLocale();
            App::setLocale($user->lang);
            $notification_obj = [
                'title_key' => 'notification_nurseryVisit_message_title',
                'message_key' => 'notification_nurseryVisit_message_message',
                'user_id' => $user->id,
                'nurse_journey_id' => $nurseVisitJourney->id,
                'type' => NotificationType::NURSE
            ];
            if ($user->device_token != null) {
                // send push notification
                $nurse = Nurse::where(['id' => $data['nurse_id']])->first();
                $notification_data = [
                    'title' => trans('api.' . $notification_obj['title_key']),
                    'message' => str_replace(['{nurse}'],
                        [$nurse->name],
                        trans('api.' . $notification_obj['message_key'])),
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $user->id,
                    'nurse_journey_id' => $nurseVisitJourney->id,
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
