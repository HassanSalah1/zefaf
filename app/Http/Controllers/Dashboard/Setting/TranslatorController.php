<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\Facades\DataTables;

class TranslatorController extends Controller
{
    //


    public function showTranslations()
    {
        $data['locales'] = [
            'en'
        ];
        $data['user'] = auth()->user();
        $data['locale'] = App::getLocale();
        $data['title'] = trans('admin.translations_title');
        $data['active'] = 'translations';
        $data['debatable_names'] = array(trans('admin.key'), trans('admin.value'),
            trans('admin.actions'));
        return view('admin.setting.translation')->with($data);
    }


    // get lang file keys/values show them in datatable.
    public function getTranslationsData(Request $request)
    {
        $langArr = Lang::get($request->file_name, [], $request->lang_locale);

        $temp = [];
        foreach ($langArr as $key => $value) {
            $temp[] = [
                'key' => $key,
                'value' => $value
            ];
        }
        $langArr = $temp;
        return DataTables::of($langArr)->addColumn('actions', function ($lang) {
            $ul = '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $lang['key'] . '" onclick="edit_translation(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
            return $ul;
        })->make(true);
    }

    // get value by it's key from lang file.
    public function getTranslationData(Request $request)
    {
        $langArr = Lang::get($request->file_name, [], $request->lang_locale);
        return response()->json([
            'code' => 1,
            'data' => $langArr[$request->key],
        ]);
    }

    // edit value by it's key in lang file.
    public function updateTranslation(Request $request)
    {
        $langArr = Lang::get($request->file_name, [], $request->lang_locale);
        $langArr[$request->key] = $request->value;

        $langFile = App::langPath().'/' . $request->lang_locale . '/' . $request->file_name . '.php';

        if (file_exists($langFile)) {
            $openFile = fopen($langFile, 'w');
            $output = "<?php\n\nreturn " . var_export($langArr, true) . ";\n";
            fwrite($openFile, $output);
            fclose($openFile);
            return response()->json([
                'code' => 1,
                'message' => trans('admin.edit_success_message'),
                'title' => trans('admin.success_title')
            ]);
        }
        return response()->json([
            'code' => 2,
            'message' => trans('admin.general_error_message'),
            'title' => trans('admin.error_title')
        ]);
    }

}
