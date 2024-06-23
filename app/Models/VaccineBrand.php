<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
    ];

    public function vaccineNames()
    {
        return $this->hasMany(VaccineName::class);
    }
}
