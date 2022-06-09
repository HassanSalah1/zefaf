<?php

namespace App\Http\Resources;

use App\Models\Setting\City;
use http\Client\Curl\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $locale = App::getLocale();
        return [
            'id' => $this->id,
            'title' => $locale === 'en' ? $this->title_en: $this->title_ar,
            'message' => $locale === 'en' ? $this->message_en : $this->message_ar,
            'date' => date('Y-m-d' , strtotime($this->created_at))
        ];
    }
}
