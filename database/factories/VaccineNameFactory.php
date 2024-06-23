<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineName>
 */
class VaccineNameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vaccine_brand_id' => $this->faker->numberBetween(1, 10),
            'vaccine_name' => $this->faker->randomElement(['BNT162b2', 'mRNA-1273', 'AZD1222', 'CoronaVac', 'Gam-COVID-Vac', 'JNJ-78436735']),
        ];
    }
}
