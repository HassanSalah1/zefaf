<?php

namespace App\Repositories\General;

use App\Entities\Constants;
use App\Entities\DeviceType;
use App\Entities\HttpCode;
use App\Entities\NotificationType;
use App\Entities\PermissionKey;
use App\Entities\UserRoles;
use App\Models\User\Notification;
use App\Models\User\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Exception\ImageException;
use Intervention\Image\Facades\Image;
use Ladumor\OneSignal\OneSignal;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class UtilsRepository
{

    public static function sendNotificationTOAdmins($notification_obj, $notification_data)
    {
        $admins = User::where(function ($query) {
            $query->where(['role' => UserRoles::ADMIN]);
            $query->orWhere(['role' => UserRoles::EMPLOYEE]);
        })->get();

        foreach ($admins as $user) {
            if ($user->role == UserRoles::EMPLOYEE) {
                if (!$user->hasPermission(PermissionKey::USERS . '|' . PermissionKey::LAP_TESTS_JOURNEY
                    . '|' . PermissionKey::NURSE_VISIT_JOURNEY . '|' . PermissionKey::PRODUCT_DELIVERY_JOURNEY)) {
                    continue;
                }
            }
            if ($user->device_token != null) {
                $notification_data_obj = array_merge($notification_data, [
                    'type' => $notification_obj['type']
                ]);
                UtilsRepository::sendIosFCM($notification_data, $notification_data_obj, $user->device_token, true);
            }
        }
//        Notification::create($notification_obj);
    }


    public static function fullPath(array $images)
    {
        foreach ($images as $key => $image) {
            $images[$key] = url(Constants::URL . $image);
        }
        return $images;
    }

    public function sortByDate($array)
    {
        usort($array, [$this, 'date_compare']);
        return array_reverse($array);
    }

    public function date_compare($a, $b)
    {
        $t1 = strtotime($a['messages']['created_at']);
        $t2 = strtotime($b['messages']['created_at']);
        return $t1 - $t2;
    }

    // create verification code
    public static function createVerificationCode($id, $length)
    {
        $code = substr(mt_rand(000000000000000, mt_getrandmax()) . $id . mt_rand(00000000000000, mt_getrandmax()), 0, $length);
        return $code;
    }

    public static function getMsgCode($key)
    {
        $codes = [
            'validation_errors' => 33,
            'social_unique' => 34,
            'email_unique' => 37,
            'success' => 200,
            'error' => 404,
            'not_login' => 303,
            'not_accessible' => 606,
            'inactive_status' => 38,
            'requested_status' => 88,
            'blocked_status' => 39,
            'not_found' => 40,
            'credentials' => 41,
            'Confirmed' => 42,
            'old_password' => 43,
            'not_receive_order' => 44,
            'change_status' => 666,
            'phone_error' => 46,

        ];
        return $codes[$key];
    }

    public static function handleResponseApi(array $response)
    {
        $responseArray = [];
        if (isset($response['message']) && !empty($response['message'])) {
            $responseArray['message'] = $response['message'];
        }
        if (isset($response['data'])) {
            $responseArray['data'] = $response['data'];
        }
        return response()->json($responseArray, $response['code']);
    }

    public static function calcDiffDates($wedding_date){
        $diff = strtotime($wedding_date . " UTC") - strtotime(date('Y-m-d H:i:s') . " UTC");
        $ddss = $diff % 86400;
        $dd = ($diff - $ddss) / 86400;
        $hhss = $ddss % 3600;
        $hh = ($ddss - $hhss) / 3600;
        $mmss = $hhss % 60;
        $mm = ($hhss - $mmss) / 60;
        $ss = $mmss % 60;

        return [
            'days' => $dd,
            'hours' => $hh,
            'minutes' => $mm,
            'seconds' => $ss
        ];
    }

    public static function getHttpCodes($key)
    {
        $codes = HttpCode::getArray();
        return $codes[$key];
    }

    // send email
    public static function sendEmail($data)
    {
        try {
            $email = 'support@zefaf.net';
            $data['from'] = $email;
            $data['lang'] = App::getLocale();
            Mail::send($data['template'], ['data' => $data,], function ($message) use ($data, $email) {
                $message->to($data['email']);
                $message->setPriority(1);
                $message->from($email);
                $message->subject($data['subject']);
            });
        } catch (\Exception $ex) {
            dd($ex);
        }
    }


    // return json response for web
    public static function response($response, $success_message = null, $success_title = null,
                                    $error_message = null, $error_title = null)
    {
        if (is_object($response) || is_array($response)) {
            return response()->json([
                'data' => $response,
                'message' => $success_message,
                'title' => $success_title
            ], 200);
        } else if ($response === true) {
            return response()->json([
                'message' => $success_message,
                'title' => $success_title
            ], 200);
        } else {
            if ($error_message !== null && $error_title !== null) {
                return response()->json([
                    'message' => $error_message,
                    'title' => $error_title
                ], 403);
            }
            return response()->json([
                'message' => trans('admin.general_error_message'),
                'title' => trans('admin.error_title')
            ], 403);
        }
    }

    // upload image
    public static function createImage($request, $image_name, $image_path, $image_id, $reseize = false)
    {
        if ($request->hasFile($image_name)) {
            $image = $request[$image_name];
            $file_name = $image_id . '.png';

            if (!file_exists(public_path($image_path))) {
                mkdir(public_path($image_path), 0755, true);
            }
            try {
                // finally we save the image as a new file
                $img = Image::make($image);
                if ($reseize) {
                    $img->resize(400, 400);
                }
                $img->save($image_path . $file_name);
                return $image_path . $file_name;
            } catch (ImageException $ex) {
//                echo $ex->getMessage();
            }
        }
        return false;
    }


    // upload image
    public static function createImageFormBase64($request, $image_name, $image_path, $image_id, $reseize = false)
    {
        if ($request->has($image_name)) {
            $image=explode(",",$request[$image_name]);
            if (is_array($image) && count($image) >= 2){
                $image = $image[1];
                $file_name = $image_id . '.png';

                if (!file_exists(public_path($image_path))) {
                    mkdir(public_path($image_path), 0755, true);
                }
                try {
                    // finally we save the image as a new file
                    $img = Image::make(base64_decode($image));
                    if ($reseize) {
                        $img->resize(400, 400 , function ($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save($image_path . $file_name);
                    return $image_path . $file_name;
                } catch (ImageException $ex) {
                }
            }
        }
        return false;
    }


//     public static function createImageFromApi($request, $image_name, $image_path, $image_id)
//     {

//             $image = $request[$image_name];
//             $file_name = $image_id . '.png';

//             if (!file_exists(public_path($image_path))) {
//                 mkdir(public_path($image_path), 0755, true);
//             }
//             try {
//                 // finally we save the image as a new file
//                 $img = Image::make($image);
// //                $img->resize(400, 400);
//                 $img->save($image_path . $file_name);
//                 return $image_path . $file_name;
//             } catch (ImageException $ex) {
// //                echo $ex->getMessage();
//             }

//     }
    public static function uploadFiles($request, $file_name, $filePath, $file_id)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->file($file_name);
            $newFileName = $file_id . '.' . $file->getClientOriginalExtension();
            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0755, true);
            }
            // move file from ~/tmp to "uploads" directory
            if (!$file->move($filePath, $newFileName)) {
                return false;
            }
            return $filePath . $newFileName;
        }
    }


    // send android push notification
    public static function sendAndroidFCM($notification_data, $device_tokens)
    {
        $fields['include_player_ids'] = [$device_tokens];
        OneSignal::sendPush($fields, $notification_data['message']);
//        $optionBuiler = new OptionsBuilder();
//        $optionBuiler->setTimeToLive(60 * 20);
//        $notificationBuilder = new PayloadNotificationBuilder($notification_data['title']);
//        $notificationBuilder->setBody($notification_data['message'])
//            ->setClickAction('FLUTTER_NOTIFICATION_CLICK')
//            ->setSound('default');
//
//        $option = $optionBuiler->build();
//        $dataBuilder = new PayloadDataBuilder();
//        $dataBuilder->addData($notification_data);
//        $data = $dataBuilder->build();
//        $notification = $notificationBuilder->build();
//        $downstreamResponse = FCM::sendTo($device_tokens, $option, $notification, $data);
//        if ($downstreamResponse->numberSuccess()) {
//            return true;
//        } else {
//            return false;
//        }
    }

    // send ios push notification
    public static function sendIosFCM($notification_data, $notification_data_obj, $device_tokens, $web = false)
    {
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder($notification_data['title']);
        $notificationBuilder->setBody($notification_data['message'])
            ->setSound('default');
        if (!$web) {
            $notificationBuilder->setClickAction('FLUTTER_NOTIFICATION_CLICK');
        } else {
            $click = '';
//            if ($notification_data_obj['type'] === NotificationType::USER) {
//                $click = 'users';
//            } else if ($notification_data_obj['type'] === NotificationType::NURSE) {
//                $click = 'journey/nurse';
//            } else if ($notification_data_obj['type'] === NotificationType::PRODUCT) {
//                $click = 'journey/product';
//            } else if ($notification_data_obj['type'] === NotificationType::LAPTESTS) {
//                $click = 'journey/lapTests';
//            }
            $notificationBuilder->setClickAction($click);
        }
        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($notification_data_obj);

        $data = $dataBuilder->build();
        $downstreamResponse = FCM::sendTo($device_tokens, $option, $notification, $data);
        if ($downstreamResponse->numberSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendSMS($phone, $message, $lang)
    {
//        $url = 'https://smsvas.vlserv.com/KannelSending/service.asmx/SendSMS';
//        $userName = "Amgen 350 Care";
//        $Password = "j9fO91LGww";
//        $SMSText = $message;
//        $SMSLang = ($lang === 'en') ? 'E' : 'A';
//        $SMSSender = "El-Mohamady";
//        $SMSReceiver = $phone;
//        $ch = curl_init();
//        $data = [
//            "Username" => $userName,
//            "Password" => $Password,
//            "SMSText" => $SMSText,
//            "SMSLang" => $SMSLang,
//            "SMSSender" => $SMSSender,
//            "SMSReceiver" => $SMSReceiver
//        ];
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//        $server_output = curl_exec($ch);
//        curl_close($ch);
//        $xml = simplexml_load_string($server_output);
//        $json = json_encode($xml);
//        $arr = json_decode($json, true);
//        if (count($arr) > 0 && $arr[0] === 0) {
//            return true;
//        } else {
//            return false;
//        }
    }

    private static function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    public static function sendNotification($user, array $notification_obj, array $notification_data, array $notification_data_obj)
    {
        // if user has device token
        if ($user->device_token != null) {
            // send  push notification to user based on device type
            if ($user->device_type == DeviceType::IOS) {
                self::sendIosFCM($notification_data, $notification_data_obj, $user->device_token);
            } else if ($user->device_type == DeviceType::ANDROID) {
                self::sendAndroidFCM($notification_data_obj, $user->device_token);
            }
        }
        Notification::create($notification_obj);
    }

}

?>
