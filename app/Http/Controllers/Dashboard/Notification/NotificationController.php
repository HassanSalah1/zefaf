<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Models\Setting\Country;
use App\Models\User\User;
use App\Services\Dashboard\Notification\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NotificationController extends Controller
{
    //

    public function showNotifications()
    {
        $data['title'] = trans('admin.notifications_title');
        $data['user'] = auth()->user();
        $data['active'] = 'notifications';
        $data['locale'] = App::getLocale();
        $data['clients'] = User::where(['status' => UserStatus::ACTIVE, 'role' => UserRoles::CUSTOMER])
            ->get();
        $data['countries'] = Country::where(['is_deleted' => 0])->get();
        $data['categories'] = Category::where(['category_id' => null])->get();
        return view('admin.notification.notification')->with($data);
    }

    public function showVendorsNotifications()
    {
        $data['title'] = 'Vendors notifications';
        $data['user'] = auth()->user();
        $data['active'] = 'vendors_notifications';
        $data['locale'] = App::getLocale();
        $data['vendors'] = User::where(['status' => UserStatus::ACTIVE, 'role' => UserRoles::VENDOR])
            ->get();
        $data['countries'] = Country::where(['is_deleted' => 0])->get();
        $data['categories'] = Category::where(['category_id' => null])->get();
        return view('admin.notification.vendor_notification')->with($data);
    }


    public function sendNotification(Request $request)
    {
        $data = $request->all();
        return NotificationService::sendNotification($data);
    }

    public function deleteNotification(Request $request)
    {
        $data = $request->all();
        return $this->notification_service->deleteNotification($data);
    }

    public function showNotificationDetails($id)
    {
        return $this->notification_service->showNotificationDetails($id);
    }
}
