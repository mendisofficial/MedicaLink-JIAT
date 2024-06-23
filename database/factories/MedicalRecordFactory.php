<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\MedicalRecord::class;

    public function definition(): array
    {
        return [
            'patient_id' => $this->faker->numberBetween(1, 10),
            'hospital_id' => $this->faker->numberBetween(1, 10),
            'record_type' => $this->faker->randomElement(['vaccination', 'diagnosis', 'treatment']),
            'description' => $this->faker->sentence(),
            'file_path' => $this->faker->imageUrl()
        ];
    }
}
