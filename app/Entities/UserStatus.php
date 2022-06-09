<?php

namespace App\Entities;

use App\Interfaces\Enum;

class UserStatus extends Enum
{
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const REVIEW = 'review';
}

?>
