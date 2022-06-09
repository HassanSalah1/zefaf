<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class EditRequest extends Model
{
    //
    protected $table = 'edit_requests';
    protected $fillable = ['user_id', 'name', 'phone', 'email', 'city_id', 'biography',
        'category_questions', 'from_price', 'to_price', 'instagram', 'facebook', 'website',
        'locations', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
