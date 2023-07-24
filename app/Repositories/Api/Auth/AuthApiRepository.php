<?php

namespace App\Repositories\Api\Auth;


use App\Entities\HttpCode;
use App\Entities\IsActive;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Models\Setting\City;
use App\Models\User\Client;
use App\Models\User\LoginStatistics;
use App\Models\User\User;
use App\Models\User\UserImage;
use App\Models\User\Vendors;
use App\Models\User\VerificationCode;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiRepository
{

    // process user login
    public static function signup(array $data): array
    {
        if ($data['type'] === 'facebook') {
            $loginData = [
                'facebook_id' => $data['facebook_id'],
            ];
            $user = User::where($loginData)->first();
            if ($user) {
                return self::login($data);
            }
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['type'] === 'form' ? $data['email'] : null,
            'phone' => $data['phone'],
            'city_id' => $data['city_id'],
            'password' => $data['type'] === 'form' ? Hash::make($data['password']) : null,
            'role' => $data['role'],
            'status' => ($data['role'] === UserRoles::CUSTOMER) ? UserStatus::ACTIVE : UserStatus::REVIEW,
            'lang' => App::getLocale(),
            'device_type' => $data['device_type'],
            'device_token' => $data['device_token'],
            'facebook_id' => $data['type'] === 'facebook' ? $data['facebook_id'] : null
        ];
        if ($data['role'] === UserRoles::VENDOR) {
            //image
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/users/';
            $userData['image'] = UtilsRepository::createImageFormBase64($data['request'], $image_name, $image_path, $file_id, true);

            if ($userData['image'] === false) {
                unset($userData['image']);
            }
        }
        $user = User::create($userData);
        if ($user) {

            if(isset($userData['image'])){
                UserImage::create([
                    'user_id' => $user->id,
                    'image' => $userData['image']
                ]);
            }
            if ($user->role === UserRoles::VENDOR) {
                $vendorData = [
                    'user_id' => $user->id,
                    'biography' => $data['biography'],
                    'category_id' => $data['category_id'],
                    'from_price' => $data['price_from'],
                    'to_price' => $data['price_to'],
                    'membership_id' => null,
                    'membership_duration' => null,
                    'membership_date' => null,
                    'category_questions' => isset($data['question']) ? $data['question'] : null,
                    'website' => null,
                    'instagram' => null,
                    'facebook' => null
                ];
             Vendors::create($vendorData);

            }
            if ($user->role === UserRoles::VENDOR) {
                return [
                    'message' => trans('api.create_account_vendor_success_message'),
                    'code' => HttpCode::SUCCESS
                ];
            } else { // client
                if ($data['type'] === 'form') {
                    $loginData = [
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ];
                    Auth::attempt($loginData);
                } else if ($data['type'] === 'facebook') {
                    $loginData = [
                        'facebook_id' => $data['facebook_id'],
                    ];
                    $user = User::where($loginData)->first();
                    if ($user) {
                        Auth::loginUsingId($user->id);
                    }
                }
                $user->increment('login_count');
                $user = self::getUserData($user->id, true);
                // return success response
                return [
                    'data' => $user,
                    'message' => trans('api.create_account_success_message'),
                    'code' => HttpCode::SUCCESS
                ];
            }
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    // get user data
    public static function getUserData($id, $token = false)
    {
        $user = User::where(['id' => $id])
            ->first(['id', 'name', 'phone', 'email', 'lang', 'city_id',
                'role', 'status', 'login_count']);
        if ($token) {
            $user->token = $user->createToken('zefaf')->accessToken;
        }

        $user->images = array_map(function ($image) {
            return url($image);
        }, collect($user->vendor_images()->pluck('image'))
            ->toArray());

        $city = City::where(['id' => $user->city_id])->first();
        $user->city_name = $city ? $city->name : null;
        $user->country_id = $city ? $city->country_id : null;
        if ($user->role === UserRoles::CUSTOMER) {
            $client = Client::where(['user_id' => $user->id])->first();
            $clientData['wedding_date'] = null;
            $clientData['partner_name'] = null;
            if ($client) {
                $clientData['wedding_date'] = UtilsRepository::calcDiffDates($client->wedding_date);
                $clientData['partner_name'] = $client->partner_name;
            }
            $user->client = $clientData;
        } else if ($user->role === UserRoles::VENDOR) {
            $vendor = Vendors::where(['user_id' => $user->id])->first();
            $vendorData = [
                'has_membership' => 0,
                'membership_id' => null,
                'membership_duration' => null,
                'membership_date' => null
            ];
            if ($vendor) {
                $vendorData = [
                    'has_membership' => $vendor->membership_id !== null ? 1 : 0,
                    'membership_id' => $vendor->membership_id,
                    'membership_duration' => $vendor->membership_duration,
                    'membership_date' => $vendor->membership_date
                ];
            }
            $user->vendor = $vendorData;
        }

        return $user;
    }

    // process user login
    public static function login(array $data)
    {
        $user = null;
        if ($data['type'] === 'form') {
            $remember = (isset($data['remember']) && $data['remember']);
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
                $user = auth()->user();
                $user->update([
                    'device_type' => $data['device_type'],
                    'device_token' => $data['device_token'],
                ]);
            }
        } else if ($data['type'] === 'facebook') {
            $loginData = [
                'facebook_id' => $data['facebook_id'],
            ];
            $user = User::where($loginData)->first();
            if ($user) {
                Auth::loginUsingId($user->id);
            }
        }

        if ($user && $user->role === UserRoles::VENDOR && $user->status === UserStatus::REVIEW) {
            return [
                'message' => trans('api.pending_review_message'),
                'code' => HttpCode::ERROR
            ];
        } else if ($user && $user->isBlocked()) {
            return [
                'message' => trans('api.block_status_error_message'),
                'code' => HttpCode::ERROR
            ];
        } else if ($user && $user->isActiveUser()) {

            $user->increment('login_count');
            LoginStatistics::create([
                'user_id' => $user->id,
                'type' => $user->role
            ]);
            $user = self::getUserData($user->id, true);
            return [
                'data' => $user,
                'message' => trans('api.login_success_message'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.credentials_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    // forget password
    public static function forgetPassword(array $data)
    {
        $user = User::select('id', 'email')
            ->where('email', '=', $data['email'])
            ->first(['id', 'email']);
        if ($user) {
            $is_sent = self::sendVerificationCode($user);
            if ($is_sent) {
                return [
                    'message' => trans('api.forget_password_success_message'),
                    'code' => HttpCode::SUCCESS
                ];
            } else {
                return [
                    'message' => trans('api.general_error_message'),
                    'code' => HttpCode::ERROR
                ];
            }
        }
        return [
            'message' => trans('api.not_found_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    // change password for forget password process
    public static function changeForgetPassword(array $data)
    {
        $user = User::where('email', '=', $data['email'])->first(['id', 'email']);
        if ($user) {
            $user->update([
                'password' => Hash::make($data['password']),
                'device_type' => $data['device_type'],
                'device_token' => $data['device_token']
            ]);
            $user = self::getUserData($user->id, true);
            return [
                'data' => $user,
                'message' => trans('api.change_password_success_message'),
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.not_found_error_message'),
            'code' => HttpCode::ERROR
        ];
    }


    // logout current user
    public static function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['device_token' => null, 'device_type' => null]);
            $user->token()->revoke();
            $user->token()->delete();
        }
        return [
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }


    public static function editProfile(array $data)
    {
        $user = auth()->user();
        if (isset($data['password']) && isset($data['old_password'])) {
            if (Auth::guard('web')->attempt(['email' => $user->email, 'password' => $data['old_password']])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                return [
                    'message' => trans('api.old_password_message'),
                    'code' => HttpCode::ERROR
                ];
            }
        }

        $userData = [];
        if ($data['request']->hasFile('image')) {
            $image = UtilsRepository::createImage($data['request'], 'image',
                'uploads/Students/');
            if ($image === false) {
                return [
                    'message' => trans('api.upload_error_message'),
                    'code' => HttpCode::ERROR
                ];
            }
            if (file_exists($user->image)) {
                unlink($user->image);
            }
            $userData['image'] = $image;
        }
        if (isset($data['name'])) {
            $userData['name'] = $data['name'];
        }
        if (isset($data['email'])) {
            $userData['email'] = $data['email'];
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $userData['password'] = $data['password'];
        }
        if (isset($data['birth_date'])) {
            $userData['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }
        if (isset($data['class_code']) && !empty($data['class_code'])) {
            $userData['role'] = Roles::SCHOOL_STUDENT;
            $class = SchoolClass::checkClassCode($data['class_code'])->first();
            if (!$class) {
                return [
                    'message' => trans('api.class_not_found_error_message'),
                    'code' => HttpCode::ERROR
                ];
            }
        }

        $user->update($userData);
        if (isset($userData['role']) && $userData['role'] === Roles::SCHOOL_STUDENT) {
            SchoolStudent::create([
                'school_class_id' => $class->class_id,
                'user_id' => $user->id
            ]);
        }
        $user = self::getUserData($user->id, true);
        return [
            'data' => $user,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];

    }

    // get verification code
    public static function getVerificationCode(array $data)
    {
        $user = User::where('email', '=', $data['email'])
            ->first(['id']);
        if ($user) {
            $verificationCode = VerificationCode::where(['user_id' => $user->id])->first();
            if ($verificationCode) {
                return [
                    'data' => [
                        'code' => $verificationCode->code
                    ],
                    'message' => 'success',
                    'code' => HttpCode::SUCCESS
                ];
            }
        }
        return [
            'message' => 'error',
            'code' => HttpCode::ERROR
        ];
    }

    // resend verification code
    public static function resendVerificationCode(array $data)
    {

        $user = User::select('id', 'email')
            ->where('email', '=', $data['email'])
            ->first(['id', 'email']);
        if ($user) {
            $is_sent = self::sendVerificationCode($user);
            if ($is_sent) {
                return [
                    'message' => trans('api.resend_success_message'),
                    'code' => HttpCode::SUCCESS
                ];
            }
        }

        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

    private static function sendVerificationCode($user)
    {
        VerificationCode::where(['user_id' => $user->id])->forceDelete();
        $code = self::createUserVerificationCode($user);
        $verificationCode = VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code
        ]);
        if ($verificationCode) {
            // send email
            $email = $user->email;
            $locale = App::getLocale();
            $subject = 'Zefaf Forget password';
            $template = 'general/email/forget_password';
            $data = [
                'subject' => $subject,
                'user' => $user,
                'code' => $code,
                'template' => $template,
                'verificationCode' => $verificationCode,
                'email' => $email
            ];
            UtilsRepository::sendEmail($data);
            return true;
        } else {
            return false;
        }
    }

    // create unique verification code
    public static function createUserVerificationCode($user)
    {
        $code = UtilsRepository::createVerificationCode($user->id, 4);
        if (VerificationCode::where(['code' => $code])->first()) {
            $code = self::createUserVerificationCode($user);
        }
        return env('APP_ENV') === 'local' ? '0000' : $code;
    }

    // check verification code
    public static function checkVerificationCode(array $data)
    {
        $user = User::select('id', 'email', 'status', 'role')
            ->where('email', '=', $data['email'])
            ->first(['id', 'email', 'status', 'role']);
        if ($user) {
            $verificationCode = VerificationCode::where([
                'user_id' => $user->id,
                'code' => $data['code']
            ])->first();
            if ($verificationCode) {
                $verificationCode->forceDelete();
                $response = [
                    'code' => HttpCode::SUCCESS
                ];
                $response['message'] = trans('api.verify_code_success_message');
                return $response;
            }
            return [
                'message' => trans('api.verify_error_message'),
                'code' => HttpCode::ERROR
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }

}
