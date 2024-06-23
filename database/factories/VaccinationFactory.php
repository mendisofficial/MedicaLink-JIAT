<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Vaccination::class;

    public function definition(): array
    {
        return [
            'patient_id' => $this->faker->numberBetween(1, 10),
            'hospital_id' => $this->faker->numberBetween(1, 10),
            'vaccine_id' => $this->faker->numberBetween(1, 10),
            'dose' => $this->faker->randomElement(['First', 'Second']),
            'date_administered' => $this->faker->date(),
            'description' => $this->faker->sentence()
        ];
    }
}
