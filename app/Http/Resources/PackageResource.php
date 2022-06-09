<?php

namespace App\Http\Resources;

use App\Entities\StatisticsType;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Country;
use App\Models\Setting\Membership;
use App\Models\User\Statistics;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => intval($this->price),
            'description' => $this->description,
        ];
    }
}
