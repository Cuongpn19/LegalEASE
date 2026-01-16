<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client_profiles extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'phone_number',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
