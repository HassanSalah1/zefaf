<?php
namespace App\Repositories\Dashboard\Journey;


use App\Entities\DeviceType;
use App\Entities\NotificationType;
use App\Models\Journey;
use App\Models\LapTest;
use App\Models\LapTestJourney;
use App\Models\Nurse;
use App\Models\Pharmacy;
use App\Models\Product;
use App\Models\ProductDeliveryJourney;
use App\Models\User\Notification;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class ProductDeliveryJourneyRepository
{

    // get product delivery journey and create datatable data.
    public static function getProductDeliveryJourneyData(array $data)
    {
        $productDeliveries = ProductDeliveryJourney::join(
            'journeys', 'product_delivery_journeys.journey_id', '=', 'journeys.id')
            ->where(['status' => 0 , 'pharmacy_id' => null])
            ->get(['product_delivery_journeys.id', 'product_id', 'pharmacy_id', 'address', 'requested_date'
                , 'packets_number' , 'user_id']);
        return DataTables::of($productDeliveries)
            ->addColumn('product', function ($productDelivery) {
                $product = Product::where(['id' => $productDelivery->product_id])->first();
                return ($product) ? $product->name: null;
            })
            ->addColumn('userName', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->name : null;
            })
            ->addColumn('phone', function ($lapTest) {
                $lapTest = User::where(['id' => $lapTest->user_id])->first();
                return ($lapTest) ? $lapTest->phone : null;
            })
            ->addColumn('actions', function ($productDelivery) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.assign_pharmacy') . '" id="' . $productDelivery->id . '" onclick="editProduct(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                return $ul;
            })->make(true);
    }

    public static function assignPharmacy(array $data)
    {
        $productDeliveryJourney = ProductDeliveryJourney::where(['id' => $data['id']])->first();
        if ($productDeliveryJourney) {
            $productDeliveryJourney->update(['pharmacy_id' => $data['pharmacy_id']]);
            // notification
            $journey = Journey::where(['id' => $productDeliveryJourney->journey_id])->first();
            $user = User::where(['id' => $journey->user_id])->first();
            $locale = App::getLocale();
            App::setLocale($user->lang);
            $notification_obj = [
                'title_key' => 'notification_productDelivery_message_title',
                'message_key' => 'notification_productDelivery_message_message',
                'user_id' => $user->id,
                'product_journey_id' => $productDeliveryJourney->id,
                'type' => NotificationType::PRODUCT
            ];
            if ($user->device_token != null) {
                // send push notification
                $pharmacy = Pharmacy::where(['id' => $data['pharmacy_id']])->first();
                $notification_data = [
                    'title' => trans('api.' . $notification_obj['title_key']),
                    'message' => str_replace(['{pharmacy}'],
                        [$pharmacy->name],
                        trans('api.' . $notification_obj['message_key'])),
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $user->id,
                    'product_journey_id' => $productDeliveryJourney->id,
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
