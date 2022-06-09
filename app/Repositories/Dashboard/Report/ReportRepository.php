<?php
namespace App\Repositories\Dashboard\Report;


use App\Entities\StatisticsType;
use App\Entities\UserRoles;
use App\Models\Setting\Category;
use App\Models\User\Client;
use App\Models\User\LoginStatistics;
use App\Models\User\Statistics;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportRepository
{

    public static function getCategoryReportsData(array $data)
    {
        $categoryStatistics = DB::table('category_statistics')
            ->where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->whereDate('created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
            })
            ->select(DB::raw('count(*) as clicks_count, category_id'))
            ->groupBy('category_id');

        return DataTables::of($categoryStatistics)
            ->addColumn('category_name', function ($area) {
                $category = Category::where(['id' => $area->category_id])->first();
                return ($category) ? $category->name : null;
            })->make(true);
    }

    public static function getVendorsReportsData(array $data)
    {

        $statisticsClickDetails = Statistics::where([
            'type' => StatisticsType::CLICK,
        ])
            ->where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->whereDate('created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
                if (isset($data['vendor_id']) && $data['vendor_id'] != -1) {
                    $query->where(['vendor_id' => $data['vendor_id']]);
                }
            })
//            ->whereYear('created_at', '=', date('Y'))
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();
        $statisticsVisitDetails = Statistics::where([
            'type' => StatisticsType::VISIT,
        ])
            ->where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->whereDate('created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
                if (isset($data['vendor_id']) && $data['vendor_id'] != -1) {
                    $query->where(['vendor_id' => $data['vendor_id']]);
                }
            })
//            ->whereYear('created_at', '=', date('Y'))
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();
        $statisticsLikeDetails = Statistics::where([
            'type' => StatisticsType::LIKE,
        ])
            ->where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->whereDate('created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
                if (isset($data['vendor_id']) && $data['vendor_id'] != -1) {
                    $query->where(['vendor_id' => $data['vendor_id']]);
                }
            })
//            ->whereYear('created_at', '=', date('Y'))
            ->select(DB::raw('count(id) as `count`'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get();
        return [
            'visits' => ($statisticsVisitDetails->sum('count')),
            'clicks' => ($statisticsClickDetails->sum('count')),
            'likes' => ($statisticsLikeDetails->sum('count')),
            'click_details' => $statisticsClickDetails,
            'like_details' => $statisticsLikeDetails,
            'visit_details' => $statisticsVisitDetails
        ];
    }

    public static function getMembershipsReportsData(array $data)
    {
        $categoryStatistics = DB::table('memberships')
            ->join('vendors', 'vendors.membership_id', '=', 'memberships.id')
            ->join('users', 'users.id', '=', 'vendors.user_id')
            ->where(function ($query) use ($data) {
                if (isset($data['category_id']) && $data['category_id'] !== -1) {
                    $query->where(['category_id' => $data['category_id']]);
                }
                if (isset($data['from'])) {
                    $query->whereDate('vendors.created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('vendors.created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
            })
            ->select(DB::raw('count(vendors.id) as vendors_count, type as membership'))
            ->groupBy('membership');

        return DataTables::of($categoryStatistics)
            ->make(true);
    }

    public static function getLoginReportsData(array $data)
    {
        $logins = LoginStatistics::where('type', '=', $data['type'])
        ->where(function ($query) use ($data) {
        if (isset($data['from'])) {
            $query->whereDate('created_at', '>=',
                date('Y-m-d', strtotime($data['from'])));
        }
        if (isset($data['to'])) {
            $query->whereDate('created_at', '<=',
                date('Y-m-d', strtotime($data['to'])));
        }
        })->with('user.vendor.category.category');
        return DataTables::of($logins)
            ->addColumn('category', function ($login) {
                return @$login->user->vendor->category->name;
            })
            ->addColumn('sub_category', function ($login) {
                return @$login->user->vendor->category->category->name;
            })
            ->make(true);
    }

    public static function getRateReportsData(array $data)
    {
        $users = User::join('vendors', 'vendors.user_id', '=', 'users.id')
            ->where([
                'role' => UserRoles::VENDOR,
            ])
            ->where(function ($query) use ($data) {
                if (isset($data['category_id']) && $data['category_id'] !== -1) {
                    $query->where(['category_id' => $data['category_id']]);
                }
                if (isset($data['from'])) {
                    $query->whereDate('reviews.created_at', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('reviews.created_at', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
            })
            ->select([
                'users.id',
                'users.name',
//                DB::raw('CONVERT(SUM(reviews.rate) / COUNT(reviews.id), UNSIGNED INTEGER) AS vendorRate'),
//                DB::raw('COUNT(reviews.id) AS rateCount')
            ]);
        return DataTables::of($users)
            ->addColumn('vendorRate' , function ($user){
                $sum = $user->reviews->sum('rate');
                $count = $user->reviews->count();

                return $count > 0 ? $sum / $count : 0;
            })
            ->addColumn('rateCount' , function ($user){
                $count = $user->reviews->count();
                return $count;
            })
            ->make(true);
    }

    public static function getWeddingReportsData(array $data)
    {
        //dd('reports/wedding/data');
        $logins = Client::where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->whereDate('wedding_date', '>=',
                        date('Y-m-d', strtotime($data['from'])));
                }
                if (isset($data['to'])) {
                    $query->whereDate('wedding_date', '<=',
                        date('Y-m-d', strtotime($data['to'])));
                }
            })->orderBy('wedding_date', 'DESC')->with('user');
        return DataTables::of($logins)

            ->make(true);
    }
}
?>
