<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    //
    protected $table = 'verification_codes';
    protected $fillable = ['user_id' , 'code'];
}
