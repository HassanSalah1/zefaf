<?php

namespace App\Http\Resources;

use App\Entities\StatisticsType;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\Setting\Membership;
use App\Models\User\Review;
use App\Models\User\Statistics;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource
    extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $category = Category::where(['id' => $this->category_id])->first();
        $mainCategory = $category ? Category::where(['id' => $category->category_id])->first() : null;

        $city = City::where(['id' => $this->city_id])->first();
        $country = $city ? Country::where(['id' => $city->country_id])->first() : null;
        $membership = Membership::where(['id' => $this->membership_id])->first();
        $user = auth()->user();
        $statistics = Statistics::where([
            'user_id' => $user->id,
            'vendor_id' => $this->id,
            'type' => StatisticsType::LIKE
        ])->first();

        $image = null;
        if ($this->vendor_images) {

            if(count($this->vendor_images) > 0) {
                $image = url($this->vendor_images[0]->image);
            }
        }

        $reviews = Review::where(['vendor_id' => $this->id])
            ->orderBy('id', 'DESC')
            ->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'from_price' => $this->from_price,
            'to_price' => $this->to_price,
            'country_name' => $country ? $country->name : null,
            'city_name' => $city ? $city->name : null,
            'membership' => $membership->type,
            'image' => $image,
            'category_id' => @$category->id,
            'main_category_id' => @$mainCategory->id,
            'category_name' => ($category ? $category->name : '') .
                ( $mainCategory ? ' - ' . $mainCategory->name : ''),
            'question_type' => @$category->question_type,
            'category_questions' => $this->category_questions ?
                json_decode($this->category_questions , true) : null,
            'is_favourite' => $statistics ? 1 : 0,
            'favourites_count' => Statistics::where(['vendor_id' => $this->id,
                'type' => StatisticsType::LIKE])->count(),
            'reviews_count' => count($reviews),
            'review_rate' => count($reviews) > 0 ? collect($reviews)->sum('rate') / count($reviews) : 0,
        ];
    }
}
