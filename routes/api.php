<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
//header('Access-Control-Allow-Origin: *');
Route::group(['middleware' => 'cors' ], function () {
    Route::group(['middleware' => 'lang'], function () {
        Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {


            Route::get('/get/countries_cities', 'Setting\SettingController@getCountriesCities'); // get countries / cities
            Route::get('/settings', 'Setting\SettingController@getSettings');
            Route::get('/terms/client', 'Setting\SettingController@getClientTerms'); // get client terms
            Route::get('/terms/vendor', 'Setting\SettingController@getVendorTerms'); // get vendor terms


            Route::post('/register', 'Auth\AuthController@register'); // register new user
            Route::post('/auth/facebook', 'Auth\AuthController@authFacebook'); // auth facebook

            Route::post('/login', 'Auth\AuthController@login'); // login user

            Route::post('/categories/click', 'Client\ActionController@clickCategories'); // login user

            //////////////////////////////
//            Route::get('/get/verification/code', 'Auth\AuthController@getVerificationCode'); // get verification code
            Route::post('/verify/check', 'Auth\AuthController@checkVerificationCode'); // check verification code
            Route::post('/verify/resend', 'Auth\AuthController@resendVerificationCode'); // resend verification code

            Route::post('/password/forget', 'Auth\AuthController@forgetPassword'); // forget password
            Route::post('/password/forget/change', 'Auth\AuthController@changeForgetPassword'); // change forget password
            ///////////////////////////

            Route::get('/get/categories', 'Client\ActionController@getCategories'); // get categories
            Route::get('/get/subcategories', 'Client\ActionController@getSubCategories'); // get categories

            Route::group(['middleware' => 'auth:api'], function () {
                Route::group(['middleware' => 'authApi'], function () {

                    Route::post('/logout', 'Auth\AuthController@logout'); // login user

                    Route::group(['middleware' => 'clientApi'], function () {
                        Route::group(['prefix' => 'client'], function () {
                            Route::post('/setWeddingDate', 'Client\ActionController@setWeddingDate'); // set Wedding Date
                            Route::get('/getWeddingDate', 'Client\ActionController@getWeddingDate');
                            Route::get('/get/tips', 'Client\ActionController@getCategoryTips'); // search tips by category

                            Route::get('/get/vendors', 'Client\VendorController@getVendors'); // get vendors
                            Route::get('/get/vendor/details/{id}', 'Client\VendorController@getVendorDetails'); // get vendor details
                            Route::post('/vendor/favourite/toggle', 'Client\VendorController@toggleFavourite'); // favourite/unfavourite vendor
                            Route::post('/vendor/review', 'Client\VendorController@reviewFavourite'); // review vendor
                            Route::get('/get/vendor/reviews/{id}', 'Client\VendorController@getVendorReviews'); // get vendor reviews
                            Route::get('/get/vendor/packages/{id}', 'Client\VendorController@getVendorPackages'); // get vendor packages

                            Route::post('/vendor/contact', 'Client\VendorController@clickVendorContact');
                            Route::get('/get/favourite/vendors', 'Client\VendorController@getFavouriteVendors'); // get favourite vendors
                        });
                    });

                    Route::group(['middleware' => 'vendorApi'], function () {
                        Route::group(['prefix' => 'vendor'], function () {

                            Route::get('/memberships', 'Vendor\MembershipController@getMemberships'); // get memberships
                            Route::get('/membership/details/{id}', 'Vendor\MembershipController@getMembershipDetails'); // get Membership Details

                            Route::post('/start/trial', 'Vendor\VendorActionsController@startFreeTrial'); // start Free Trial

                            Route::post('/image/remove/{id}', 'Vendor\VendorActionsController@removeImage'); // start Free Trial

                            Route::get('/packages', 'Vendor\VendorActionsController@getMyPackages'); // get my packages
                            Route::post('/package/add', 'Vendor\VendorActionsController@addPackage'); // add package
                            Route::post('/package/edit/{id}', 'Vendor\VendorActionsController@editPackage'); // edit package
                            Route::delete('/package/delete/{id}', 'Vendor\VendorActionsController@deletePackage'); // delete package

                            Route::get('/profile', 'Vendor\VendorActionsController@getProfile'); // get profile
                            Route::post('/edit/profile', 'Vendor\VendorActionsController@editProfile'); // edit profile

                            Route::get('/reviews', 'Vendor\VendorActionsController@getMyReviews'); // get my reviews

                            Route::post('/upload', 'Vendor\VendorActionsController@upload');

                            Route::get('/statistics', 'Vendor\VendorActionsController@getStatistics'); // get statistics

                            Route::post('/renew/package', 'Vendor\VendorActionsController@renewPackage');
                        });
                    });

                    Route::get('/notifications/count', 'User\UserController@getMyNotificationsCount');
                    /////////////////////////////////

                    Route::post('/contact', 'Setting\SettingController@addContact'); // add Contact

                    Route::get('/notifications', 'User\UserController@getMyNotifications'); // get my notifications

                });
            });


            Route::get('/handle/payment', 'Vendor\VendorActionsController@handlePayment');
            Route::get('/acceptance/post_pay', 'Vendor\VendorActionsController@post_pay');
            Route::get('/payment_error', 'Vendor\VendorActionsController@payment_error');
        });
    });
});
