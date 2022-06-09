<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource
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
//        $reviewUser = User::where(['id' => $this->user_id])->first();
        return [
            'username' => $this->name,
            'is_help' => $this->is_help,
            'rate' => $this->rate,
            'comment' => $this->comment,
            'create' => date('M Y', strtotime($this->created_at))
        ];
    }
}
