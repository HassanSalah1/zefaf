<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Entities\PermissionKey;

Route::get('/run/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
//    \Illuminate\Support\Facades\Artisan::call('passport:install');

//    \Illuminate\Support\Facades\Artisan::call('dump-autoload');
});


Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Dashboard'
    , 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {


    Route::get('/login', 'Auth\AuthController@loginView'); // show login page
    Route::post('/login/process', 'Auth\AuthController@login'); //login user

    Route::get('/reset-password', 'Auth\AuthController@showResetPassword'); // show reset-password page
    Route::post('/reset-password', 'Auth\AuthController@processResetPassword'); // process reset-password

    Route::get('/change/password/{code}', 'Auth\AuthController@showChangePassword'); // show change-password page
    Route::post('/change/password/{code}', 'Auth\AuthController@processChangePassword'); // process change-password

    Route::middleware(["admin", "web"])->group(function () {


        Route::get('/logout', 'Auth\AuthController@logout'); // logout current user
        Route::get('/home', 'Home\HomeController@showHome'); // show home page

        Route::get('/update/token', 'Auth\AuthController@updateToken'); // update device token

        /////////////////////
        Route::get('/profile/update', 'Auth\AuthController@showUpdateProfile'); // show edit admin profile
        Route::post('/profile/update/save', 'Auth\AuthController@updateProfile'); // save edited admin profile

        //////////////////////////////////////////////////////////////////////////
        ///
        Route::post('/upload/image', 'Home\HomeController@uploadEditorImages'); // upload editor images inside text

        Route::middleware(["role_auth:" . PermissionKey::SETTINGS, "web"])->group(function () {
            Route::get('/setting', 'Home\HomeController@showSetting'); // show setting page
            Route::post('/setting/save', 'Home\HomeController@saveSetting'); // save setting data
        });

        Route::middleware(["role_auth:" . PermissionKey::CLIENT_TERMS, "web"])->group(function () {
            Route::get('/client/terms', 'Home\HomeController@showAddClientTerms'); // show disclaimer page
            Route::post('/client/terms/save', 'Home\HomeController@saveAddClientTerms'); // save disclaimer data
        });

        Route::middleware(["role_auth:" . PermissionKey::VENDOR_TERMS, "web"])->group(function () {
            Route::get('/vendor/terms', 'Home\HomeController@showAddVendorTerms'); // show disclaimer page
            Route::post('/vendor/terms/save', 'Home\HomeController@saveAddVendorTerms'); // save disclaimer data
        });

//        Route::middleware(["role_auth:" . PermissionKey::ABOUT, "web"])->group(function () {
//            Route::get('/about', 'Home\HomeController@showAbout'); // show about page
//            Route::post('/about/save', 'Home\HomeController@saveAbout'); // save about data
//        });


        ////////////////////////////////////////////////////////////////////////////
        //Countries
        Route::middleware(["role_auth:" . PermissionKey::COUNTRIES, "web"])->group(function () {
            Route::get('/countries', 'Setting\CountryController@showCountries'); // show Index page that control all Countries
            Route::get('/countries/data', 'Setting\CountryController@getCountriesData'); // get all Countries data for DataTable
            Route::post('/country/add', 'Setting\CountryController@addCountry'); // add Country
            Route::post('/country/data', 'Setting\CountryController@getCountryData'); // get Country data
            Route::post('/country/edit', 'Setting\CountryController@editCountry'); // edit Country
            Route::post('/country/delete', 'Setting\CountryController@deleteCountry'); // delete Country
            Route::post('/country/change', 'Setting\CountryController@changeCountry'); // change Country status
        });

        ////////////////////////////////////////////////////////////////////////////
        //memberships
        Route::middleware(["role_auth:" . PermissionKey::MEMBERSHIPS, "web"])->group(function () {
            Route::get('/memberships', 'Setting\MembershipController@showMemberships'); // show Index page that control all Memberships
            Route::get('/memberships/data', 'Setting\MembershipController@getMembershipsData'); // get all Memberships data for DataTable
            Route::post('/membership/add', 'Setting\MembershipController@addMembership'); // add Membership
            Route::post('/membership/data', 'Setting\MembershipController@getMembershipData'); // get Membership data
            Route::post('/membership/edit', 'Setting\MembershipController@editMembership'); // edit Membership
            Route::post('/membership/delete', 'Setting\MembershipController@deleteMembership'); // delete Membership
            Route::post('/membership/change', 'Setting\MembershipController@changeMembership'); // change Membership status
        });

        ////////////////////////////////////////////////////////////////////////////
        //areas
        Route::middleware(["role_auth:" . PermissionKey::AREAS, "web"])->group(function () {
            Route::get('/areas', 'Setting\AreaController@showAreas'); // show Index page that control all Areas
            Route::get('/areas/data', 'Setting\AreaController@getAreasData'); // get all Areas data for DataTable
            Route::post('/area/add', 'Setting\AreaController@addArea'); // add Area
            Route::post('/area/data', 'Setting\AreaController@getAreaData'); // get Area data
            Route::post('/area/edit', 'Setting\AreaController@editArea'); // edit Area
            Route::post('/area/delete', 'Setting\AreaController@deleteArea'); // delete Area
            Route::post('/area/change', 'Setting\AreaController@changeArea'); // change Area status
        });

        ////////////////////////////////////////////////////////////////////////////
        //categories
        Route::middleware(["role_auth:" . PermissionKey::CATEGORIES, "web"])->group(function () {
            Route::get('/categories', 'Setting\CategoryController@showCategories'); // show Index page that control all categories
            Route::get('/categories/data', 'Setting\CategoryController@getCategoriesData'); // get all Nurses data for DataTable
            Route::get('/category/add', 'Setting\CategoryController@showAddCategory'); // show add Category
            Route::post('/category/add', 'Setting\CategoryController@addCategory'); // add Category
            Route::post('/category/data', 'Setting\CategoryController@getCategoryData'); // get Category data
            Route::get('/category/edit/{id}', 'Setting\CategoryController@showEditCategory'); // show edit Category
            Route::post('/category/edit', 'Setting\CategoryController@editCategory'); // edit Category
            Route::post('/category/delete', 'Setting\CategoryController@deleteCategory'); // delete Category
            Route::post('/category/change', 'Setting\CategoryController@changeCategory'); // change Category status

            Route::get('/categories/sub/{id}', 'Setting\CategoryController@showSubCategories'); // show Index page that control all categories
            Route::get('/categories/sub/{id}/data', 'Setting\CategoryController@getSubCategoriesData');

        });


        ////////////////////////////////////////////////////////////
        /// users
        Route::middleware(["role_auth:" . PermissionKey::USERS, "web"])->group(function () {
            Route::get('/users', 'User\UserController@showUsers'); // show Index page that control all users
            Route::get('/users/data', 'User\UserController@getUsersData'); // get all users data for DataTable
            Route::get('/user/details/{id}', 'User\UserController@showUserDetails'); // show user details

            Route::get('/user/favourites/data/{id}', 'User\UserController@showUserFavouritesData');
            Route::post('/get/country/cities', 'User\UserController@getCountryCities');

            Route::post('/user/verify', 'User\UserController@verifyUser'); // verify user
            Route::post('/user/change', 'User\UserController@changeStatus'); // change user Status
            Route::post('/user/add', 'User\UserController@addUser'); // add user
        });

        ////////////////////////////////////////////////////////////
        /// vendors
        Route::middleware(["role_auth:" . PermissionKey::VENDORS, "web"])->group(function () {
            Route::get('/vendors', 'User\VendorController@showVendors'); // show Index page that control all Vendors
            Route::get('/vendors/data', 'User\VendorController@getVendorsData'); // get all Vendors data for DataTable
            Route::get('/vendor/details/{id}', 'User\VendorController@showVendorDetails'); // show Vendor details
            Route::post('/vendor/verify', 'User\VendorController@verifyVendor'); // verify Vendor
            Route::post('/vendor/change', 'User\VendorController@changeStatus'); // change Vendor Status

            Route::get('/vendor/packages/data/{id}', 'User\VendorController@getVendorPackagesData');
            Route::get('/vendor/reviews/data/{id}', 'User\VendorController@getVendorReviewsData');


            Route::get('/vendors/review', 'User\VendorController@showVendorsReview'); // show Index page that control all Vendors
            Route::get('/vendors/review/data', 'User\VendorController@getVendorsReviewData'); // get all Vendors data for DataTable

            Route::get('/requests', 'User\RequestController@showRequests'); // show Index page that control all Vendors
            Route::get('/requests/data', 'User\RequestController@getRequestsData'); // get all Vendors data for DataTable
            Route::post('/request/change', 'User\RequestController@changeStatus');

            /////////////////

            Route::get('/vendor/add', 'User\VendorController@showAddVendor');
            Route::post('/vendor/add', 'User\VendorController@saveAddVendor');

            Route::get('/vendor/edit/{vendors}', 'User\VendorController@showEditVendor');
            Route::post('/vendor/edit/{id}', 'User\VendorController@saveEditVendor');
        });

        Route::post('/vendors/get/categories', 'User\VendorController@getSearchCategories');
        Route::post('/countries/get/cities', 'User\VendorController@getCountryCities');


        ////////////////////////////////////////////////////////////
        /// vendors
        Route::middleware(["role_auth:" . PermissionKey::VENDORS, "web"])->group(function () {

            Route::get('/vendor/details/{id}', 'User\VendorController@showVendorDetails'); // show Vendor details
            Route::post('/vendor/verify', 'User\VendorController@verifyVendor'); // verify Vendor
            Route::post('/vendor/change', 'User\VendorController@changeStatus'); // change Vendor Status

        });

        ////////////////////////////////////////////////
        /// contacts
        Route::middleware(["role_auth:" . PermissionKey::CONTACTS, "web"])->group(function () {
            Route::get('/contact/messages', 'Contact\ContactController@showContactMessages'); // show Index page that control all contact messages
            Route::get('/contacts/data', 'Contact\ContactController@getContactMessagesData'); // get all contact messages data for DataTable
            Route::post('/contact/delete', 'Contact\ContactController@deleteContact'); // delete contact
            Route::get('/contact/details/{id}', 'Contact\ContactController@showContactDetails'); // show contact details
            Route::post('/contact/replay', 'Contact\ContactController@sendReplayMessage'); // send replay message
        });


        ///////////////////////////////////////////////
        // permissions
        Route::middleware(["role_auth:" . PermissionKey::PERMISSIONS, "web"])->group(function () {
            Route::get('permissions', 'User\PermissionController@showPermissions'); // show Index page that control all Permissions
            Route::get('/permissions/data', 'User\PermissionController@getPermissionsData'); // get all Permissions data for DataTable
            Route::post('/permission/add', 'User\PermissionController@addPermission'); // add permission
            Route::post('/permission/delete', 'User\PermissionController@deletePermission'); // delete permission
            Route::post('/permission/data', 'User\PermissionController@getPermissionData'); // get permission data
            Route::post('/permission/edit', 'User\PermissionController@editPermission'); // edit permission
        });
        ///////////////////////////////////////////////////////////////
        // employees
        Route::middleware(["role_auth:" . PermissionKey::EMPLOYEES, "web"])->group(function () {
            Route::get('/employees', 'User\EmployeeController@showEmployees'); // show Index page that control all Employees
            Route::get('/employees/data', 'User\EmployeeController@getEmployeesData'); // get all Employees data for DataTable
            Route::post('/employee/add', 'User\EmployeeController@addEmployee'); // add Employee
            Route::post('/employee/data', 'User\EmployeeController@getEmployeeData'); // get Employee data
            Route::post('/employee/edit', 'User\EmployeeController@editEmployee'); // edit Employee
            Route::post('/employee/delete', 'User\EmployeeController@deleteEmployee'); // delete Employee
            Route::post('/employee/change', 'User\EmployeeController@changeEmployee'); // change Employee
        });

        ///  translations
        Route::middleware(["role_auth:" . PermissionKey::TRANSLATIONS, "web"])->group(function () {
            Route::get('/translations/', 'Setting\TranslatorController@showTranslations'); // show translations page
            Route::get('/translations/data', 'Setting\TranslatorController@getTranslationsData'); // get file keys/values by selected locale and file
            Route::post('/translation/data', 'Setting\TranslatorController@getTranslationData'); // get value by selected kay from specific lang file
            Route::post('/translation/edit', 'Setting\TranslatorController@updateTranslation'); // edit value in lang file
        });

        ///  REPORTS
        Route::middleware(["role_auth:" . PermissionKey::REPORTS, "web"])->group(function () {
            Route::get('/reports/categories', 'Report\ReportController@showCategoryReport');
            Route::get('/reports/categories/data', 'Report\ReportController@getCategoryReportsData');

            Route::get('/reports/vendors', 'Report\ReportController@showVendorsReport');


            Route::post('/category/get/vendors', 'Report\ReportController@getCategoryVendors');

            Route::get('/reports/memberships', 'Report\ReportController@showMembershipsReport');
            Route::get('/reports/memberships/data', 'Report\ReportController@getMembershipsReportsData');

            Route::get('/reports/login', 'Report\ReportController@showLoginReport');
            Route::get('/reports/login/data', 'Report\ReportController@getLoginReportsData');

            Route::get('/reports/rate', 'Report\ReportController@showRateReport');
            Route::get('/reports/rate/data', 'Report\ReportController@getRateReportsData');

            Route::get('/reports/wedding', 'Report\ReportController@showWeddingReport');
            Route::get('/reports/wedding/data', 'Report\ReportController@getWeddingReportsData');

        });
        /////////////////////////////////////////////////////////////
        Route::middleware(["role_auth:" . PermissionKey::NOTIFICATIONS, "web"])->group(function () {
            Route::get('/notifications', 'Notification\NotificationController@showNotifications'); // show page for all Notifications
            Route::get('/notifications/vendors', 'Notification\NotificationController@showVendorsNotifications'); // show page for all Notifications
            Route::post('/notification/send', 'Notification\NotificationController@sendNotification'); // send Notification
//
//            Route::get('/notifications/data', 'Notification\NotificationController@getNotificationsData'); // get all Notifications data for DataTable

//            Route::post('/notification/delete', 'Notification\NotificationController@deleteNotification'); // delete Notification
//            Route::get('/notification/details/{id}', 'Notification\NotificationController@showNotificationDetails'); // show Notification details
        });


    });

});

////////////////////////
///
/// ALTER TABLE `permissions` ADD `reports` INT NOT NULL DEFAULT '0' AFTER `contacts`;
/// ALTER TABLE `users` ADD `login_count` INT NOT NULL DEFAULT '0' AFTER `lang`;

/////////////////////////////////////////////////////////////

// landing page

//Route::get('/website', 'Landing\LandingController@showLandingPage'); // show Notification details
