<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'hospital_id',
        'vaccine_id',
        'dose',
        'date_administered',
        'description'
    ];

    protected $appends = ['formatted_created_at','formatted_updated_at'];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('Y-m-d');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function vaccineBrand()
    {
        return $this->belongsTo(VaccineBrand::class, 'id');
    }

    public function vaccineName()
    {
        return $this->belongsTo(VaccineName::class, 'vaccine_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(VaccineName::class);
    }
}
