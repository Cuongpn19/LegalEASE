<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'name',
    ];

    public function lawyers() {
        return $this->belongsToMany(User::class, 'lawyer_specializations', 'specialization_id', 'lawyer_id');
    }
}
