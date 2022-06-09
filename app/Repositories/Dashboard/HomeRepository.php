<?php

namespace App\Repositories\Dashboard;


use App\Entities\Key;
use App\Models\Setting\Setting;
use App\Repositories\General\UtilsRepository;

class HomeRepository
{

    public static function saveSetting($data)
    {
        // VIDEO
        if (isset($data[Key::VIDEO])) {
            $video = Setting::where(['key' => Key::VIDEO])->first();

            $file_id = 'VID_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $video_name = 'video';
            $video_path = 'uploads/setting/';

            $data[Key::VIDEO] = UtilsRepository::uploadFiles($data['request'], $video_name, $video_path, $file_id);

            if ($video) {
                if (file_exists($video->value)) {
                    unlink($video->value);
                }
                $video->update(['value' => $data[Key::VIDEO]]);
            } else if ($data[Key::VIDEO]) {
                Setting::create(['key' => Key::VIDEO, 'value' => $data[Key::VIDEO]]);
            }
        }

        if (isset($data[Key::SUPPORT])) {
            $support = Setting::where(['key' => Key::SUPPORT])->first();
            if ($support) {
                $support->update(['value' => $data[Key::SUPPORT]]);
            } else if ($data[Key::SUPPORT]) {
                Setting::create(['key' => Key::SUPPORT, 'value' => $data[Key::SUPPORT]]);
            }
        }

        // loyality image
        if ($data['request']->hasFile(Key::LOYALITY_IMAGE)) {
            $loyality_image = Setting::where(['key' => Key::LOYALITY_IMAGE])->first();

            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = Key::LOYALITY_IMAGE;
            $image_path = 'uploads/loyality/';
            $data[Key::LOYALITY_IMAGE] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
            if ($data[Key::LOYALITY_IMAGE] === false) {
                unset($data[Key::LOYALITY_IMAGE]);
            } else if ($loyality_image && file_exists($loyality_image->value)) {
                unlink($loyality_image->value);
            }
            if ($loyality_image) {
                $loyality_image->update(['value' => $data[Key::LOYALITY_IMAGE]]);
            } else {
                Setting::create(['key' => Key::LOYALITY_IMAGE, 'value' => $data[Key::LOYALITY_IMAGE]]);
            }
        }

        // Service image
        if ($data['request']->hasFile(Key::Service_IMAGE)) {
            $service_image = Setting::where(['key' => Key::Service_IMAGE])->first();

            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = Key::Service_IMAGE;
            $image_path = 'uploads/loyality/';
            $data[Key::Service_IMAGE] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
            if ($data[Key::Service_IMAGE] === false) {
                unset($data[Key::Service_IMAGE]);
            } else if ($service_image && file_exists($service_image->value)) {
                unlink($service_image->value);
            }
            if ($service_image) {
                $service_image->update(['value' => $data[Key::Service_IMAGE]]);
            } else {
                Setting::create(['key' => Key::Service_IMAGE, 'value' => $data[Key::Service_IMAGE]]);
            }
        }

        return UtilsRepository::response(true, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function saveAddClientTerms(array $data)
    {
        // terms ar
        if (isset($data[Key::CLIENT_TERMS_AR])) {
            $terms_ar = Setting::where(['key' => Key::CLIENT_TERMS_AR])->first();
            if ($terms_ar) {
                $terms_ar->update(['value' => $data[Key::CLIENT_TERMS_AR]]);
            } else {
                Setting::create(['key' => Key::CLIENT_TERMS_AR, 'value' => $data[Key::CLIENT_TERMS_AR]]);
            }
        }

        // terms en
        if (isset($data[Key::CLIENT_TERMS_EN])) {
            $terms_en = Setting::where(['key' => Key::CLIENT_TERMS_EN])->first();
            if ($terms_en) {
                $terms_en->update(['value' => $data[Key::CLIENT_TERMS_EN]]);
            } else {
                Setting::create(['key' => Key::CLIENT_TERMS_EN, 'value' => $data[Key::CLIENT_TERMS_EN]]);
            }
        }

        return UtilsRepository::response(true, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function saveAddVendorTerms(array $data)
    {
        // terms ar
        if (isset($data[Key::VENDOR_TERMS_AR])) {
            $terms_ar = Setting::where(['key' => Key::VENDOR_TERMS_AR])->first();
            if ($terms_ar) {
                $terms_ar->update(['value' => $data[Key::VENDOR_TERMS_AR]]);
            } else {
                Setting::create(['key' => Key::VENDOR_TERMS_AR, 'value' => $data[Key::VENDOR_TERMS_AR]]);
            }
        }

        // terms en
        if (isset($data[Key::VENDOR_TERMS_EN])) {
            $terms_en = Setting::where(['key' => Key::VENDOR_TERMS_EN])->first();
            if ($terms_en) {
                $terms_en->update(['value' => $data[Key::VENDOR_TERMS_EN]]);
            } else {
                Setting::create(['key' => Key::VENDOR_TERMS_EN, 'value' => $data[Key::VENDOR_TERMS_EN]]);
            }
        }

        return UtilsRepository::response(true, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>
