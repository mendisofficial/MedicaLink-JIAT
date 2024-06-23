<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineName extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_name',
        'vaccine_brand_id'
    ];

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function vaccineBrand()
    {
        return $this->belongsTo(VaccineBrand::class);
    }
}
