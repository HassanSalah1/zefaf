<?php

namespace App\Http\Resources;

use App\Entities\StatisticsType;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Models\Setting\Category;
use App\Models\User\Statistics;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $categoryIds = [];
        if ($this->category_id === null) {
            $categoryIds = Category::where([
                'is_deleted' => 0,
                'category_id' => $this->id
            ])->pluck('id')->toArray();
        }
        $likes_count = User::join('vendors', 'users.id', '=', 'vendors.user_id')
            ->join('statistics' , 'statistics.vendor_id' , '=' , 'users.id')
            ->where([
                'statistics.type' => StatisticsType::LIKE,
                'role' => UserRoles::VENDOR,
                'status' => UserStatus::ACTIVE,
                ['membership_id', '!=', null],
            ])
            ->whereRaw("NOW() BETWEEN DATE(membership_date) AND DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY))")
            ->where(function ($query) use ($categoryIds) {
                if (count($categoryIds)) {
                    $query->whereIn('category_id', $categoryIds);
                }
                $query->orWhere(['category_id' => $this->id]);
            })
            ->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => url($this->image),
            'question_type' => $this->question_type,
            'likes_count' => $likes_count
        ];
    }
}
