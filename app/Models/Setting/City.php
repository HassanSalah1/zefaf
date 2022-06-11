<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class City extends Model
{
    //
    protected $table = 'cities';
    protected $fillable = ['country_id' , 'name_ar' , 'name_en' , 'is_deleted'];

    public function getNameAttribute()
    {
        $column = App::getLocale() == 'en' ? 'name_en' : 'name_ar';
        return $this->$column;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
