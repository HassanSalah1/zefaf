<?php
namespace App\Services\Dashboard\Report;

use App\Repositories\Dashboard\Report\ReportRepository;
use App\Repositories\General\UtilsRepository;

class ReportService
{


    public static function getCategoryReportsData(array $data)
    {
        return ReportRepository::getCategoryReportsData($data);
    }

    public static function getMembershipsReportsData(array $data)
    {
        return ReportRepository::getMembershipsReportsData($data);
    }

    public static function getLoginReportsData(array $data)
    {
        return ReportRepository::getLoginReportsData($data);
    }

    public static function getRateReportsData(array $data)
    {
        return ReportRepository::getRateReportsData($data);
    }
    public static function getWeddingReportsData(array $data)
    {
        return ReportRepository::getWeddingReportsData($data);
    }


}

?>
