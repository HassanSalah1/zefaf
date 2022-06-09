<?php

namespace App\Repositories\General;

use App\Entities\HttpCode;
use Illuminate\Support\Facades\Validator;

class ValidationRepository
{

    public static function validateWebGeneral(array $data, $rules, $extra_messages = [])
    {
        $messages = [
            'required' => trans('admin.required_error_message'),
            'date_format' => trans('admin.date_format_error_message'),
        ];

        $messages = array_merge($messages, $extra_messages);
        $validator = Validator::make($data, $rules, $messages);
        $msg = "";
        if ($validator->fails()) {
            $ul = '<ul>';
            $errors = $validator->errors();
            $index = 0;
            foreach ($rules as $input => $rule) {
                if ($errors->has($input)) {
                    $index++;
                    $ul .= '<li>' . trans('admin.' . $input) . ' : ' . $errors->first($input) . '</li>';
                }
                if ($index > 5) break;
            }

            $ul .= '</ul>';
            return response()->json([
                'message' => $ul,
                'title' => trans('admin.error_title')
            ], 403);
        }
        return true;
    }

    //    validate api general data
    public static function validateAPIGeneral(array $data, array $keys, array $messages = [])
    {
        $rules = [];
        foreach ($keys as $key => $value) {
            $rules[$key] = $value;
        }

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $validationErrors = [];
            if (count($messages) === 0) {
                $validation_errors = $validator->failed();
            } else {
                $validation_errors = $validator->errors()->toArray();
                foreach ($validation_errors as $key => $error) {
                    $validationErrors[] = [
                        'type' => $key,
                        'message' => $error[0]
                    ];
                }
            }
            return Response()->json($validationErrors, HttpCode::ERROR);
        }
        return true;
    }

}

?>
