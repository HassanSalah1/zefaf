<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class CategoryStatistics extends Model
{
    //
    protected $table = 'category_statistics';
    protected $fillable = ['user_id' , 'category_id'];
}
