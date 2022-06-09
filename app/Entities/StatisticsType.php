<?php

namespace App\Entities;

use App\Interfaces\Enum;

class StatisticsType extends Enum
{
    const LIKE = 'like';
    const CLICK = 'click';
    const VISIT = 'visit';
}

?>
