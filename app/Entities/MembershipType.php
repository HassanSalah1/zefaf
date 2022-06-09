<?php

namespace App\Entities;

use App\Interfaces\Enum;

class MembershipType extends Enum
{
    const BASIC = 'basic';
    const PRO = 'pro';
    const VIP = 'vip';
    const FREE = 'free';

}

?>
