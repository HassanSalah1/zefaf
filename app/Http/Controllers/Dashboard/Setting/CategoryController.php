<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Services\Dashboard\Setting\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoryController extends Controller
{
    //
    public function showCategories()
    {
        $data['title'] = trans('admin.categories_title');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'categories';
        $data['debatable_names'] = array(trans('admin.title_arabic'), trans('admin.title_english'),
            trans('admin.image'), 'sub categories count', trans('admin.actions'));
        return view('admin.setting.category.category')->with($data);
    }

    public function getCategoriesData(Request $request)
    {
        $data = $request->all();
        $data['locale'] = App::getLocale();
        return CategoryService::getCategoriesData($data);
    }


    public function showSubCategories($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->to(url('/categories'));
        }
        $data['id'] = $id;
        $data['title'] = 'sub categories - (' . $category->name . ')';
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'categories';
        $data['debatable_names'] = array(trans('admin.title_arabic'), trans('admin.title_english'),
            trans('admin.image'), trans('admin.actions'));
        return view('admin.setting.category.subcategory')->with($data);
    }

    public function getSubCategoriesData($id , Request $request)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['locale'] = App::getLocale();
        return CategoryService::getSubCategoriesData($data);
    }

    public function showAddCategory(Request $request)
    {
        $data['title'] = trans('admin.add_category');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'categories';

        $data['categories'] = Category::where(['category_id' => null, 'is_deleted' => 0])->get();

        return view('admin.setting.category.add_category')->with($data);
    }

    public function addCategory(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return CategoryService::addCategory($data);
    }

    public function deleteCategory(Request $request)
    {
        $data = $request->all();
        return CategoryService::deleteCategory($data);
    }

    public function getCategoryData(Request $request)
    {
        $data = $request->all();
        return CategoryService::getCategoryData($data);
    }

    public function showEditCategory(Request $request, $id)
    {
        $category = Category::where(['id' => $id])->first();
        if (!$category) {
            return redirect()->to(url('/categories'));
        }
        $tips = ($category->tips !== null) ? json_decode($category->tips, true) : [];
        $data['tips'] = $tips;
        $data['category'] = $category;
        $data['title'] = trans('admin.edit_category');
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['active'] = 'categories';
        $data['categories'] = Category::where(['category_id' => null])->get();
        return view('admin.setting.category.edit_category')->with($data);
    }

    public function editCategory(Request $request)
    {
        $data = $request->all();
        $data['request'] = $request;
        return CategoryService::editCategory($data);
    }

    public function changeCategory(Request $request)
    {
        $data = $request->all();
        return CategoryService::changeCategory($data);
    }

}
