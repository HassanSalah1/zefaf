<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Country extends Model
{
    //
    protected $table = 'countries';
    protected $fillable = ['name_ar' , 'name_en' , 'is_deleted'];

    public function getNameAttribute()
    {
        $column = App::getLocale() == 'en' ? 'name_en' : 'name_ar';
        return $this->$column;
    }
}
