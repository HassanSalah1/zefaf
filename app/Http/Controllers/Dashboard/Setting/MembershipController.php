<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Country;
use App\Services\Dashboard\Setting\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MembershipController extends Controller
{
    //
    public function showMemberships()
    {
        $data['title'] = trans('admin.memberships_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'memberships';
        $data['debatable_names'] = array(trans('admin.image'), trans('admin.features'),
            trans('admin.price'), trans('admin.discount'), trans('admin.actions'));
        return view('admin.setting.membership')->with($data);
    }

    public function getMembershipsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return MembershipService::getMembershipsData($data);
    }

    public function addMembership(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return MembershipService::addMembership($data);
    }

    public function deleteMembership(Request $request)
    {
        $data = $request->all();
        return MembershipService::deleteMembership($data);
    }

    public function getMembershipData(Request $request)
    {
        $data = $request->all();
        return MembershipService::getMembershipData($data);
    }

    public function editMembership(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return MembershipService::editMembership($data);
    }

    public function changeMembership(Request $request){
        $data = $request->all();
        return MembershipService::changeMembership($data);
    }

}
