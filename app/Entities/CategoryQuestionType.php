<?php

namespace App\Entities;

use App\Interfaces\Enum;

class CategoryQuestionType extends Enum
{
    const NONE = 'none';
    const CAPACITY_RANGE = 'capacity_range';
    const VEIL_DESIGNER = 'veil_designer';
    const OFFERING_SWEETS = 'offering_sweets';
    const OFFERING_MEALS = 'offering_meals';
    const VIDEOGRAPHER = 'videographer';
    const SOIREE_SHOES = 'soiree_shoes';
    const DIAMOND_GOLD = 'diamond_gold';
}

?>
