<?php

namespace App\Entities;

use App\Interfaces\Enum;

class PermissionKey extends Enum
{
    const SETTINGS = 'settings';
    const COUNTRIES = 'countries';
    const AREAS = 'areas';
    const CLIENT_TERMS = 'client_terms';
    const VENDOR_TERMS = 'vendor_terms';
    const USERS = 'users';
    const CATEGORIES = 'categories';
    const MEMBERSHIPS = 'memberships';
    const VENDORS = 'vendors';
    const UPDATE_REQUESTS = 'update_requests';
    const NOTIFICATIONS = 'notifications';
    const EMPLOYEES = 'employees';
    const PERMISSIONS = 'permissions';
    const TRANSLATIONS = 'translations';
    const CONTACTS = 'contacts';

    const REPORTS = 'reports';
}

?>
