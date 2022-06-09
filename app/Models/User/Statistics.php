<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    //
    protected $table = 'statistics';
    protected $fillable = ['user_id' , 'vendor_id' , 'type'];
}
