<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availabilities extends Model
{
    protected $fillable = [
        'lawyer_id',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

}
