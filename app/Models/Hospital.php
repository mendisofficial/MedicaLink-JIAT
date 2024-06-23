<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'branch'
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }
}
