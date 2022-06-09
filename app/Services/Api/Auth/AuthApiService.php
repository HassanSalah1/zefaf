<?php

namespace App\Services\Api\Auth;

use App\Entities\CategoryQuestionType;
use App\Entities\HttpCode;
use App\Entities\UserRoles;
use App\Models\Setting\Category;
use App\Repositories\Api\Auth\AuthApiRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class AuthApiService
{

    public static function signup(array $data)
    {
        $keys = [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'city_id' => 'required',
            'role' => 'required|in:' . implode(',', UserRoles::getUserKeys()),
            'type' => 'required|in:form,facebook',
            'device_type' => 'required',
            'device_token' => 'required',
        ];

        if (isset($data['role']) && $data['role'] === UserRoles::VENDOR) {
            $keys = array_merge($keys, [
                'image' => 'required',
                'biography' => 'required',
                'price_from' => 'required',
                'price_to' => 'required',
                'category_id' => 'required',
            ]);

            if (isset($data['category_id'])) {
                $category = Category::where(['id' => $data['category_id']])->first();
                if($category && $category->category_id === null){
                    return UtilsRepository::handleResponseApi([
                        'message' => 'error',
                        'code' => HttpCode::ERROR
                    ]);
                }
                if ($category && $category->question_type !== CategoryQuestionType::NONE) {
                    $keys = array_merge($keys, [
                        'question' => 'required',
                    ]);
                    $data['category'] = $category;
                }
            }
        }

        if (isset($data['type']) && $data['type'] === 'form') {
            $keys = array_merge($keys, [
                'email' => 'required|unique:users',
                'password' => 'required'
            ]);
        } else if (isset($data['type']) && $data['type'] === 'facebook') {
            $keys = array_merge($keys, [
                'facebook_id' => 'required'
            ]);
        }

        $messages = [
            'required' => trans('api.required_error_message'),
            'email.unique' => trans('api.email_unique_error_message'),
            'phone.unique' => trans('api.phone_unique_error_message'),
            'role.in' => trans('api.role_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        if (isset($data['question']) && !empty($data['question']) && isset($data['category']) && $data['category']->question_type !== CategoryQuestionType::NONE) {
            $question = json_decode($data['question'], true);
            if(count($question) > 0 &&
                ( (!isset($question[$data['category']->question_type]) && $data['category']->question_type !== CategoryQuestionType::DIAMOND_GOLD)
                    || (!isset($question['diamond']) && !isset($question['diamond']) && $data['category']->question_type === CategoryQuestionType::DIAMOND_GOLD)
                )){
                return UtilsRepository::handleResponseApi([
                    'message' => 'error',
                    'code' => HttpCode::ERROR
                ]);
            }
        }
        $response = AuthApiRepository::signup($data);
        return UtilsRepository::handleResponseApi($response);
    }


    public static function login(array $data)
    {
        $keys = [
            'type' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
        ];
        if (isset($data['type']) && $data['type'] === 'form') {
            $keys = array_merge($keys, [
                'email' => 'required',
                'password' => 'required'
            ]);
        } else if (isset($data['type']) && $data['type'] === 'facebook') {
            $keys = array_merge($keys, [
                'facebook_id' => 'required'
            ]);
        }
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        return AuthApiRepository::login($data);
    }

    public static function getVerificationCode(array $data)
    {
        $keys = [
            'email' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = AuthApiRepository::getVerificationCode($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function resendVerificationCode(array $data)
    {
        $keys = [
            'email' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = AuthApiRepository::resendVerificationCode($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function checkVerificationCode(array $data)
    {
        $keys = [
            'email' => 'required',
            'code' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = AuthApiRepository::checkVerificationCode($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function forgetPassword(array $data)
    {
        $keys = [
            'email' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = AuthApiRepository::forgetPassword($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function changeForgetPassword(array $data)
    {
        $keys = [
            'email' => 'required',
            'password' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
        ];
        $messages = [
            'required' => trans('api.required_error_message'),
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }
        $response = AuthApiRepository::changeForgetPassword($data);
        return UtilsRepository::handleResponseApi($response);
    }


    public static function editProfile(array $data)
    {
        $user = auth()->user();
        $keys = [];

        if (isset($data['email'])) {
            $keys['email'] = 'required|email' . (($data['email'] !== $user->email) ? '|unique:users' : '');
        }
        if (isset($data['name'])) {
            $keys['name'] = 'required|min:3';
        }

        if (isset($data['image'])) {
            $keys['image'] = 'required|image';
        }
        if (isset($data['birth_date'])) {
            $keys['birth_date'] = 'required|date';
        }
        if (isset($data['password']) || isset($data['old_password'])) {
            $keys = [
                'password' => 'required|regex:/^.*(?=.{3,})(?=.*\d)(?=.*[a-zA-Z]).*$/|min:6',
                'old_password' => 'required',
            ];
        }
        $messages = [
            'required' => trans('api.required_error_message'),
            'name.min' => trans('api.student_name_min_error_message'),
            'email.email' => trans('api.valid_email_error_message'),
            'email.unique' => trans('api.email_unique_error_message'),
            'password.regex' => trans('api.password_error_message'),
            'password.min' => trans('api.password_error_message'),
            'image.image' => trans('api.image_error_message'),
            'birth_date.date' => trans('api.date_error_message')
        ];
        $validated = ValidationRepository::validateAPIGeneral($data, $keys, $messages);
        if ($validated !== true) {
            return $validated;
        }

        $response = AuthApiRepository::editProfile($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function logout()
    {
        $response = AuthApiRepository::logout();
        return UtilsRepository::handleResponseApi($response);
    }

    public static function authFacebook(array $data)
    {
    }

}

?>
