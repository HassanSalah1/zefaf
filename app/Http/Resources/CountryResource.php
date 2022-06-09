<?php

namespace App\Http\Resources;

use App\Models\Setting\City;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $cities = City::where(['country_id' => $this->id , 'is_deleted' => 0])
            ->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'cities' => CityResource::collection($cities),
        ];
    }
}
