<?php
namespace App\Services\Dashboard\Journey;


use App\Repositories\Dashboard\Journey\LapTestJourneyRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class LapTestJourneyService
{


    public static function getLapTestJourneyData(array $data)
    {
        return LapTestJourneyRepository::getLapTestJourneyData($data);
    }

    public static function assignLap(array $data)
    {
        $rules = [
            'lap_id' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = LapTestJourneyRepository::assignLap($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>
