<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $table = 'locations';
    protected $fillable = ['user_id' , 'link'];
}
