<?php

namespace Database\Factories;

use App\Models\VaccineBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineBrand>
 */
class VaccineBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = VaccineBrand::class;

    public function definition(): array
    {
        return [
            'brand_name' => $this->faker->randomElement(['Pfizer', 'Moderna', 'AstraZeneca', 'Sinovac', 'Sputnik V', 'Johnson & Johnson']),
        ];
    }
}
