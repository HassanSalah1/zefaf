<?php
namespace App\Services\Dashboard\Setting;

use App\Entities\MembershipType;
use App\Repositories\Dashboard\Setting\MembershipRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class MembershipService
{


    public static function getMembershipsData(array $data)
    {
        return MembershipRepository::getMembershipsData($data);
    }

    public static function addMembership(array $data)
    {
        $rules = [
            'type' => 'required',
            'features_ar' => 'required',
            'features_en' => 'required',
        ];

        if(isset($data['type']) && $data['type'] === MembershipType::FREE){
            $rules = array_merge($rules , [
                'duration' => 'required',
            ]);
        } else {
            $rules = array_merge($rules , [
                'price' => 'required',
            ]);
        }

        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = MembershipRepository::addMembership($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteMembership(array $data)
    {
        $response = MembershipRepository::deleteMembership($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeMembership(array $data)
    {
        $response = MembershipRepository::changeMembership($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getMembershipData(array $data)
    {
        $response = MembershipRepository::getMembershipData($data);
        return UtilsRepository::response($response);
    }

    public static function editMembership(array $data)
    {
        $rules = [
            'type' => 'required',
            'features_ar' => 'required',
            'features_en' => 'required',

        ];

        if(isset($data['type']) && $data['type'] === MembershipType::FREE){
            $rules = array_merge($rules , [
                'duration' => 'required',
            ]);
        } else {
            $rules = array_merge($rules , [
                'price' => 'required',
            ]);
        }
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = MembershipRepository::editMembership($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
