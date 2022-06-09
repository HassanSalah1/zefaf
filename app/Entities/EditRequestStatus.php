<?php

namespace App\Entities;

use App\Interfaces\Enum;

class EditRequestStatus extends Enum
{
    const APPROVED = 'approved';
    const REFUSED = 'refused';
    const PENDING = 'pending';
}

?>
