<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer_specialization extends Model
{
    protected $fillable = [
        'lawyer_id',
        'specialization_id',
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

        public function specializations()
    {
        // Phải khớp với bảng trung gian bạn đã tạo trong Migration
        return $this->belongsToMany(Specialization::class, 'lawyer_specializations', 'lawyer_id', 'specialization_id');
    }

}
