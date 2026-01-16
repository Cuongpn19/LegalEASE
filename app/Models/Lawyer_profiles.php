<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer_profiles extends Model
{
    protected $fillable = [
        'specialization',
        'bio',
        'location',
        'experience_years',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specializations() {
        return $this->belongsToMany(Specialization::class, 'lawyer_specializations', 'lawyer_id', 'specialization_id');
    }

}
