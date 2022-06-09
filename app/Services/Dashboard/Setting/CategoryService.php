<?php
namespace App\Services\Dashboard\Setting;

use App\Repositories\Dashboard\Setting\CategoryRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;

class CategoryService
{


    public static function getCategoriesData(array $data)
    {
        return CategoryRepository::getCategoriesData($data);
    }

    public static function getSubCategoriesData(array $data)
    {
        return CategoryRepository::getSubCategoriesData($data);
    }

    public static function addCategory(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'image' => 'required',
            'question_type' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = CategoryRepository::addCategory($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function deleteCategory(array $data)
    {
        $response = CategoryRepository::deleteCategory($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


    public static function changeCategory(array $data)
    {
        $response = CategoryRepository::changeCategory($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getCategoryData(array $data)
    {
        $response = CategoryRepository::getCategoryData($data);
        return UtilsRepository::response($response);
    }

    public static function editCategory(array $data)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
        $validated = ValidationRepository::validateWebGeneral($data, $rules);
        if ($validated !== true) {
            return $validated;
        }
        $response = CategoryRepository::editCategory($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }


}

?>
