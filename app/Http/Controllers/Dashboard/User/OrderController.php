<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Addition;
use App\Models\Branch;
use App\Models\Bread;
use App\Models\Category;
use App\Models\Meal;
use App\Models\MealAddition;
use App\Models\Size;
use App\Models\User\User;
use App\Repositories\Api\User\OrderApiRepository;
use App\Repositories\General\UtilsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderController extends Controller
{
    //

    public function showAddOrder(Request $request)
    {
        $data['title'] = trans('admin.add_order_title');
        $data['active'] = 'orders';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();

        $data['users'] = User::where(['role' => UserRoles::CUSTOMER])->enabled()->get();

        $data['branches'] = Branch::enabled()->get();
        $data['categories'] = Category::where(['category_id' => null])->enabled()->get();

        $data['meals'] = (count($data['branches']) > 0 && count($data['categories']) > 0) ?
            OrderApiRepository::getCityCategoryMeals($data['branches'][0]->city_id , $data['categories'][0]->id)
            : [];
        return view('admin.user.add_order')->with($data);
    }

    public function getMeals(Request $request){
        $branch = Branch::where(['id' => $request->branch_id])->first();
        $meals = [];
        if($branch){
            $meals = OrderApiRepository::getCityCategoryMeals($branch->city_id , $request->category_id);
        }
        return UtilsRepository::response($meals);
    }


}
