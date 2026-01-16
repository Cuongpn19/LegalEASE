<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // app/Models/User.php

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isLawyer(): bool
    {
        return $this->role === 'lawyer';
    }
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function lawyerProfile()
    {
        return $this->hasOne(Lawyer_profiles::class, 'user_id');
    }

    public function clientProfile()
    {
        return $this->hasOne(Client_profiles::class, 'user_id');
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'lawyer_specializations', 'lawyer_id', 'specialization_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointments::class, 'lawyer_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availabilities::class, 'lawyer_id');
    }

    public function reviewsReceived() {
        return $this->hasMany(Reviews::class, 'lawyer_id');
    }
}
