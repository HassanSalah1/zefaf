<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Entities\Key;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Repositories\Dashboard\HomeRepository;
use App\Repositories\General\UtilsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    //
    public function showHome(Request $request)
    {
        $data = $request->all();
        $data['title'] = trans('admin.home_title');
        $data['active'] = 'home';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();

        $data['all_clients'] = User::where(['role' => UserRoles::CUSTOMER])->get()->count();
        $data['all_vendors'] = User::where(['role' => UserRoles::VENDOR])->get()->count();
        $data['active_vendors'] = User::where([
            'role' => UserRoles::VENDOR, 'status' => UserStatus::ACTIVE
        ])->get()->count();
        $data['pending_vendors'] = User::where([
            'role' => UserRoles::VENDOR, 'status' => UserStatus::REVIEW
        ])->get()->count();
        $data['blocked_vendors'] = User::where([
            'role' => UserRoles::VENDOR, 'status' => UserStatus::BLOCKED
        ])->get()->count();

        $data['categories'] = Category::where(['is_deleted' => 0])->get()->count();
        $data['employees'] = User::where(['role' => UserRoles::EMPLOYEE])->get()->count();

        $data['partner_clients'] = User::join('clients' , 'clients.user_id' , '=' , 'users.id')
            ->where(['role' => UserRoles::CUSTOMER , ['partner_name' , '!=' , null]])
            ->get()
            ->count();


        return view('admin.general.home')->with($data);
    }

    // show  client terms page
    public function showAddClientTerms(Request $request)
    {
        $data = $request->all();
        $data['title'] = trans('admin.client_terms_title');
        $data['active'] = 'client_terms';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['terms_ar'] = Setting::where(['key' => Key::CLIENT_TERMS_AR])->first();
        $data['terms_en'] = Setting::where(['key' => Key::CLIENT_TERMS_EN])->first();

        return view('admin.setting.client_terms')->with($data);
    }

    // save client terms
    public function saveAddClientTerms(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return HomeRepository::saveAddClientTerms($data);
    }

    // show  vendor terms page
    public function showAddVendorTerms(Request $request)
    {
        $data = $request->all();
        $data['title'] = trans('admin.vendor_terms_title');
        $data['active'] = 'vendor_terms';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['terms_ar'] = Setting::where(['key' => Key::VENDOR_TERMS_AR])->first();
        $data['terms_en'] = Setting::where(['key' => Key::VENDOR_TERMS_EN])->first();

        return view('admin.setting.vendor_terms')->with($data);
    }

    //save vendor terms
    public function saveAddVendorTerms(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return HomeRepository::saveAddVendorTerms($data);
    }

    public function showSetting(Request $request)
    {
        $data = $request->all();
        $data['title'] = trans('admin.setting_title');
        $data['active'] = 'setting';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['video'] = Setting::where(['key' => Key::VIDEO])->first();
        $data['support'] = Setting::where(['key' => Key::SUPPORT])->first();
        $data['loyality_image'] = Setting::where(['key' => Key::LOYALITY_IMAGE])->first();
        $data['service_image'] = Setting::where(['key' => Key::Service_IMAGE])->first();
        return view('admin.general.setting')->with($data);
    }

    public function saveSetting(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return HomeRepository::saveSetting($data);
    }

    public function uploadEditorImages(Request $request)
    {
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'file';
        $image_path = 'uploads/content/';
        $image = UtilsRepository::createImage($request, $image_name, $image_path, $file_id);
        if ($image !== false) {
            return json_encode(array('location' => url($image)));
        }
    }

    public function showTerms(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        $data['terms'] = Setting::where(['key' =>
            ($data['locale'] === 'ar') ? Key::TERMS_AR : Key::TERMS_EN])->first();

        return view('site.terms')->with($data);
    }

//
}
