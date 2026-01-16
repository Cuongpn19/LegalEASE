<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $fillable = [
        'appointment_id',
        'client_id',
        'lawyer_id',
        'appointment_date',
        'start_time',
        'status',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    // Trong file App\Models\Appointments.php
public function client_profiles()
{
    // Một lịch hẹn thuộc về một hồ sơ khách hàng
    return $this->belongsTo(Client_profiles::class, 'client_id');
}
    public function review() {
        return $this->hasOne(Reviews::class, 'appointment_id', 'id');
    }
}
