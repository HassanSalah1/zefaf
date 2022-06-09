<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notifications';
    protected $fillable = ['title_ar', 'message_ar', 'title_en', 'message_en', 'user_id' , 'read'];
}
