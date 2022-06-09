<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';
    protected $fillable = ['user_id', 'vendor_id', 'rate', 'comment', 'is_help', 'name'];
}
