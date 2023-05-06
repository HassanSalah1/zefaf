<?php

namespace App\Http\Resources;

use App\Models\User\Vendors;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $duration = $this->duration ; //!== null  ? $this->duration / 30 : null;
//        $user = auth()->user();
//        if($user){
//            $vendor = Vendors::where(['user_id' => $user->id])->first();
//            if($vendor) {
//                $duration = $vendor->membership_duration !== null ? $vendor->membership_duration / 30 : null;
//            }
//        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'features' => json_decode($this->features, true),
            'price' => $this->price,
            'duration' => $duration,
            'discount' => $this->discount,
            'image' => $this->image !== null ? url($this->image) : null,
        ];
    }
}
