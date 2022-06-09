<?php

namespace App\Entities;

use App\Interfaces\Enum;

class UserRoles extends Enum
{
    const ADMIN = 'admin';
    const EMPLOYEE = 'employee';
    const CUSTOMER = 'customer';
    const VENDOR = 'vendor';

    public static function getUserKeys(): array
    {
        return [self::CUSTOMER, self::VENDOR];
    }
}

?>
