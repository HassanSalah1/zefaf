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

class VendorDetailsResource
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
        $city = City::where(['id' => $this->city_id])->first();
        $country = Country::where(['id' => $city->country_id])->first();
        $membership = Membership::where(['id' => $this->membership_id])->first();

        $user = auth()->user();
        $statistics = Statistics::where([
            'user_id' => $user->id,
            'vendor_id' => $this->id,
            'type' => StatisticsType::LIKE
        ])->first();

        $mainCategory = $category ? Category::where(['id' => $category->category_id])->first() : null;

        $review = Review::where(['user_id' => $user->id, 'vendor_id' => $this->id])
            ->first();

        $reviews = Review::where(['vendor_id' => $this->id])
            ->orderBy('id', 'DESC')
            ->get();
        $reviewData = null;
        if (count($reviews) > 0) {
            $reviewData = ReviewResource::make($reviews[0]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'from_price' => $this->from_price,
            'to_price' => $this->to_price,
            'country_name' => $country->name,
            'city_name' => $city->name,
            'membership' => $membership->type,
            'images' => array_map(function ($image) {
                return url($image);
            }, collect($this->vendor_images()->pluck('image'))
                ->toArray()),
            'biography' => $this->biography,
            'phone' => $this->phone,
            'website' => $this->website,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'locations' => $this->locations ? json_decode($this->locations) : [],
            'category_name' => ($category ? $category->name : '') .
                ( $mainCategory ? ' - ' . $mainCategory->name : ''),
            'question_type' => $category ? $category->question_type : null,
            'category_questions' => $this->category_questions ?
                json_decode($this->category_questions , true) : null,
            'is_favourite' => $statistics ? 1 : 0,
            'is_reviewed' => $review ? 1 : 0,
            'review' => $reviewData,
            'reviews_count' => count($reviews),
            'review_rate' => count($reviews) > 0 ? collect($reviews)->sum('rate') / count($reviews) : 0,
        ];
    }
}
