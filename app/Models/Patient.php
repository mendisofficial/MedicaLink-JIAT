<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nic',
        'name',
        'date_of_birth',
        'address',
        'gender',
        'blood_group',
        'height',
        'weight',
        'contact_number',
        'password',
        'registered_by',
        'profile_photo_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'registered_by');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
