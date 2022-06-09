<?php
namespace App\Services\Dashboard\Journey;



use App\Repositories\Dashboard\Journey\LapTestJourneyRepository;
use App\Repositories\Dashboard\Journey\ProductDeliveryJourneyRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class ProductDeliveryJourneyService
{


    public static function getProductDeliveryJourneyData(array $data)
    {
        return ProductDeliveryJourneyRepository::getProductDeliveryJourneyData($data);
    }

    public static function assignPharmacy(array $data)
    {
        $rules = [
            'pharmacy_id' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = ProductDeliveryJourneyRepository::assignPharmacy($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>
