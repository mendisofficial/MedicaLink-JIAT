<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Hospital;
use App\Models\MedicalRecord;
use App\Models\Patient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vaccination;
use App\Models\VaccineBrand;
use App\Models\VaccineName;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Hospital::factory(10)->create();
        Patient::factory(10)->create();
        Admin::factory(10)->create();
        VaccineBrand::factory(10)->create();
        VaccineName::factory(10)->create();
        Vaccination::factory(100)->create();
        MedicalRecord::factory(100)->create();
    }
}
