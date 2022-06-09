<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //
    protected $table = 'packages';
    protected $fillable = ['user_id' , 'title' , 'price' , 'description'];

    protected $casts = [
        'price' => 'integer',
    ];
}
