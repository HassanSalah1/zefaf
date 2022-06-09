<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';
    protected $fillable = ['user_id' , 'wedding_date' , 'partner_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
