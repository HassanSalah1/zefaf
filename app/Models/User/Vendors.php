<?php

namespace App\Models\User;

use App\Models\Setting\Category;
use App\Models\Setting\Membership;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    //
    protected $table = 'vendors';
    protected $fillable = ['user_id', 'biography', 'category_id', 'from_price'
        , 'to_price', 'membership_id', 'membership_duration', 'membership_date','locations'
        , 'category_questions', 'website' , 'instagram' , 'facebook'];

    protected $casts = [
        'from_price' => 'integer',
        'to_price' => 'integer',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
