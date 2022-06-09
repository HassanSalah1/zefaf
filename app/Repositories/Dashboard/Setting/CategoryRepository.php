<?php
namespace App\Repositories\Dashboard\Setting;


use App\Models\Setting\Category;
use App\Repositories\General\UtilsRepository;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository
{

    // get Categories and create datatable data.
    public static function getCategoriesData(array $data)
    {
        $categories = Category::where(['category_id' => null, 'is_deleted' => 0])->get();
        return DataTables::of($categories)
            ->editColumn('image', function ($meal) {
                if ($meal->image !== null) {
                    return '<a href="' . url($meal->image) . '" data-popup="lightbox">
                    <img src="' . url($meal->image) . '" class="img-rounded img-preview"
                    style="max-height:50px;max-width:50px;"></a>';
                }
            })
            ->addColumn('main_category', function ($category) {
                $categoryObj = Category::where(['id' => $category->category_id])->first();
                if ($categoryObj) {
                    return $categoryObj->name;
                }
            })
            ->addColumn('subcategories_count', function ($category) {
                $count = Category::where('category_id', '=', $category->id)
                    ->where(['is_deleted' => 0])->count();
                return '<a href="' . url('/categories/sub/' . $category->id)
                    . '" target="_blank" style="text-decoration: underline;">' . $count . '</a>';
            })
            ->addColumn('actions', function ($category) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $category->id . '" href="' . url('/category/edit/' . $category->id) . '" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $category->id . '" onclick="deleteCategory(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }


    public static function getSubCategoriesData(array $data)
    {
        $categories = Category::where([['category_id' , '=' , $data['id']], 'is_deleted' => 0])->get();
        return DataTables::of($categories)
            ->editColumn('image', function ($meal) {
                if ($meal->image !== null) {
                    return '<a href="' . url($meal->image) . '" data-popup="lightbox">
                    <img src="' . url($meal->image) . '" class="img-rounded img-preview"
                    style="max-height:50px;max-width:50px;"></a>';
                }
            })
            ->addColumn('main_category', function ($category) {
                $categoryObj = Category::where(['id' => $category->category_id])->first();
                if ($categoryObj) {
                    return $categoryObj->name;
                }
            })
            ->addColumn('subcategories_count', function ($category) {
                $count = Category::where('category_id', '!=', null)
                    ->where(['is_deleted' => 0])->count();
                return '<a href="' . url('/categories/sub/' . $category->id)
                    . '" target="_blank" style="text-decoration: underline;">' . $count . '</a>';
            })
            ->addColumn('actions', function ($category) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $category->id . '" href="' . url('/category/edit/' . $category->id) . '" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $category->id . '" onclick="deleteCategory(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addCategory(array $data)
    {
        $data['tips'] = [];
        if(isset($data['tips_en'])){
            foreach($data['tips_en'] as $key => $tip){
                $data['tips'][] = [
                    'ar' => (isset($data['tips_ar'][$key]))  ?$data['tips_ar'][$key] : null,
                    'en' => $tip
                ];
            }
        }
        $categoryData = [
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'category_id' => (isset($data['category_id'])) ? $data['category_id'] : null,
            'tips' => (isset($data['tips']) && !empty($data['tips']))
                ? json_encode($data['tips']) : null,
            'question_type' => $data['question_type']
        ];
        //image
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'image';
        $image_path = 'uploads/categories/';
        $categoryData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id, true);

        if ($categoryData['image'] === false) {
            unset($categoryData['image']);
        }
        $created = Category::create($categoryData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteCategory(array $data)
    {
        $category = Category::where(['id' => $data['id']])->first();
        if ($category) {
            $category->update(['is_deleted' => 1]);
            return true;
        }
        return false;
    }

    public static function changeCategory(array $data)
    {
        $category = Category::where(['id' => $data['id']])->first();
        if ($category) {
            $category->update(['is_active' => !$category->is_active]);
            return true;
        }
        return false;
    }

    public static function getCategoryData(array $data)
    {
        $category = Category::where(['id' => $data['id']])->first();
        if ($category) {
            return $category;
        }
        return false;
    }

    public static function editCategory(array $data)
    {
        $category = Category::where(['id' => $data['id']])->first();
        if ($category) {

            $data['tips'] = [];
            if(isset($data['tips_en'])){
                foreach($data['tips_en'] as $key => $tip){
                    $data['tips'][] = [
                        'ar' => (isset($data['tips_ar'][$key]))  ?$data['tips_ar'][$key] : null,
                        'en' => $tip
                    ];
                }
            }

            $categoryData = [
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'category_id' => (isset($data['category_id'])) ? $data['category_id'] : null,
                'tips' => (isset($data['tips']) && !empty($data['tips']))
                    ? json_encode($data['tips']) : null,
                'question_type' => $data['question_type']
            ];
            // image
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/categories/';
            $categoryData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id, true);
            if ($categoryData['image'] === false) {
                unset($categoryData['image']);
            } else {
                if ($category->image !== null && file_exists($category->image)) {
                    unlink($category->image);
                }
            }
            $updated = $category->update($categoryData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
