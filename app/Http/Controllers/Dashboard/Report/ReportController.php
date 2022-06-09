<?php

namespace App\Http\Controllers\Dashboard\Report;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Models\User\Vendors;
use App\Repositories\Dashboard\Report\ReportRepository;
use App\Services\Dashboard\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    //
    public function showCategoryReport()
    {
        $data['title'] = 'Category Reports';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'category_reports';
        $data['debatable_names'] = array('category name', 'clicks count');
        return view('admin.reports.category_report')->with($data);
    }

    public function getCategoryReportsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return ReportService::getCategoryReportsData($data);
    }

    public function showVendorsReport(Request $request)
    {
        $data = $request->All();
        $data['title'] = 'Vendors Reports';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'vendors_reports';
        $data['categories'] = Category::where(['category_id' => null, 'is_deleted' => 0])->get();
        $data['vendors'] = [];
        $data['vendors_reports'] = ReportRepository::getVendorsReportsData($data);
        return view('admin.reports.vendors_report')->with($data);
    }

    public function getCategoryVendors(Request $request)
    {
        return response()->json([
            'data' => Vendors::join('users', 'users.id', '=', 'vendors.user_id')
                ->where(['category_id' => $request->category_id])->get(['users.id' , 'users.name'])
        ]);
    }

    public function showMembershipsReport()
    {
        $data['title'] = 'Memberships Reports';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'memberships_reports';
        $data['categories'] = Category::where(['category_id' => null, 'is_deleted' => 0])->get();
        $data['debatable_names'] = array('membership', 'vendors count');
        return view('admin.reports.membership_report')->with($data);
    }

    public function getMembershipsReportsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return ReportService::getMembershipsReportsData($data);
    }

    public function showLoginReport(Request $request)
    {
        $data = $request->all();
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        if ($request->type === UserRoles::CUSTOMER) {
            $data['active'] = 'clogin_reports';
            $data['title'] = 'Clients Login Reports';
            $data['debatable_names'] = array('id','user name', 'login date');
        } else {
            $data['active'] = 'vlogin_reports';
            $data['title'] = 'Vendors Login Reports';
            $data['debatable_names'] = array('id','vendor name', 'category', 'sub category', 'login date');
        }

        return view('admin.reports.login_report')->with($data);
    }

    public function getLoginReportsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return ReportService::getLoginReportsData($data);
    }


    public function showRateReport()
    {
        $data['title'] = 'Rating Reports';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'rate_reports';
        $data['categories'] = Category::where(['category_id' => null, 'is_deleted' => 0])->get();
        $data['debatable_names'] = array('Vendor name', 'rate', 'rating count');
        return view('admin.reports.rate_report')->with($data);
    }

    public function getRateReportsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return ReportService::getRateReportsData($data);
    }
    public function showWeddingReport()
    {
        $data['title'] = 'Rating Reports';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'wedding';
        $data['debatable_names'] = array('Name','Partner name', 'Wedding Date');
        return view('admin.reports.wedding')->with($data);
    }

    public function getWeddingReportsData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return ReportService::getWeddingReportsData($data);
    }

}
