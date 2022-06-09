<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name_ar', 'name_en', 'image', 'category_id', 'question_type',
        'tips', 'is_deleted'];

    protected $casts = [
        'category_id' => 'integer'
    ];

    public function getNameAttribute()
    {
        $column = App::getLocale() == 'en' ? 'name_en' : 'name_ar';
        return $this->$column;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
