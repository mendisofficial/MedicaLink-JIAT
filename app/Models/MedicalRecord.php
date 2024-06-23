<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'hospital_id',
        'record_type',
        'description',
        'file_path',
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
}
