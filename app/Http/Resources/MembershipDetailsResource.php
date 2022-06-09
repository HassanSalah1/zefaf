<?php

namespace App\Http\Resources;

use App\Models\User\Vendors;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MembershipDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $duration = $this->duration;
        $user = auth()->user();
        $days = 0;
        if ($user) {
            $vendor = Vendors::where(['user_id' => $user->id])
                ->select('*', DB::raw('DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY)) AS end_date'))
                ->first();
            if ($vendor) {
                if ($vendor->membership_duration !== null) {
                    $duration = $vendor->membership_duration / 30;
                    $days = Carbon::parse($vendor->end_date)->diffInDays(Carbon::now());
                }
            }
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'features' => json_decode($this->features, true),
            'price' => $this->price,
            'duration' => $duration,
            'discount' => $this->discount,
            'image' => $this->image !== null ? url($this->image) : null,
            'days' => $days
        ];
    }
}
