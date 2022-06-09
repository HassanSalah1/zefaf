<?php
namespace App\Services\Dashboard\Journey;



use App\Repositories\Dashboard\Journey\LapTestJourneyRepository;
use App\Repositories\Dashboard\Journey\NurseVisitJourneyRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class NurseVisitJourneyService
{


    public static function getNurseVisitJourneyData(array $data)
    {
        return NurseVisitJourneyRepository::getNurseVisitJourneyData($data);
    }

    public static function assignNurse(array $data)
    {
        $rules = [
            'nurse_id' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = NurseVisitJourneyRepository::assignNurse($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>
