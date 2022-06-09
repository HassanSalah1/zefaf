<?php

namespace App\Repositories\Api\User;




use App\Models\Addition;
use App\Models\Bread;
use App\Models\Meal;
use App\Models\Size;

class OrderApiRepository
{

    public static function getCityCategoryMeals($city_id , $category_id){
        return Meal::join('city_meals', 'meals.id', '=', 'city_meals.meal_id')
            ->where([
                'category_id' => $category_id,
                'city_id' => $city_id,
            ])
            ->get(['meals.id', 'name_ar', 'name_en', 'category_id', 'has_weight', 'price'])
            ->each(function ($meal) {
                $meal->sizes = Size::join('city_meals' , 'city_meals.size_id' , '=' , 'sizes.id')
                    ->where(['meal_id' => $meal->id])
                    ->get(['sizes.id' , 'price' , 'name_ar' , 'name_en']);
                $meal->breads = Bread::join('city_meals' , 'city_meals.bread_id' , '=' , 'breads.id')
                    ->where(['meal_id' => $meal->id])
                    ->get(['breads.id' , 'price' , 'name_ar' , 'name_en']);
                $meal->additions = Addition::join('meal_additions' , 'meal_additions.addition_id' , '=' , 'additions.id')
                    ->where(['meal_id' => $meal->id])
                    ->get(['additions.id' , 'price' , 'name_ar' , 'name_en']);
            });
    }

}
?>
