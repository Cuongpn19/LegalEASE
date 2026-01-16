<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'client_id',
        'lawyer_id',
        'question',
        'answer',
        'status'
    ];
    public function lawyer(){
        return $this->belongsTo(User::class, 'lawyer_id');
    }
    public function client(){
        return $this->belongsTo(User::class, 'client_id');
    }
}
