<?php

namespace App\Repositories\Api\Vendor;

use App\Entities\HttpCode;
use App\Entities\MembershipType;
use App\Http\Resources\MembershipDetailsResource;
use App\Http\Resources\MembershipResource;
use App\Models\Setting\Membership;

class MembershipApiRepository
{

    public static function getMemberships(array $data): array
    {
        $memberships = Membership::where([
            'is_active' => 1,
            ['type', '!=', MembershipType::FREE]
        ])->get();
        return [
            'data' => MembershipResource::collection($memberships),
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getMembershipDetails(array $data)
    {
        $membership = Membership::where(['is_active' => 1])
            ->where(function ($query) use ($data){
                $query->where(['id' => $data['id']])
                    ->orWhere(['type' => $data['id']]);
            })
            ->first();
        if ($membership) {
            return [
                'data' => MembershipDetailsResource::make($membership),
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        } else {
            return [
                'message' => 'error',
                'code' => HttpCode::SUCCESS
            ];
        }
    }


}
