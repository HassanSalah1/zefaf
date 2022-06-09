<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Membership extends Model
{
    //
    protected $table = 'memberships';
    protected $fillable = ['type', 'features_ar', 'features_en'
        , 'price', 'discount', 'image', 'duration', 'is_active'];

    protected $casts = [
        'price' => 'integer',
        'discount' => 'integer'
    ];

    public function getFeaturesAttribute()
    {
        $column = App::getLocale() == 'en' ? 'features_en' : 'features_ar';
        return $this->$column;
    }
}
