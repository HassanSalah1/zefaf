<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class LoginStatistics extends Model
{
    protected $table = 'login_statistics';
    protected $fillable = [ 'user_id' ,'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
