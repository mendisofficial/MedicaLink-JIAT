<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'nic' => $this->faker->unique()->numerify('############'),
            'name' => $this->faker->name,
            'date_of_birth' => $this->faker->date(),
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'height' => $this->faker->randomFloat(2, 1.5, 2.0),
            'weight' => $this->faker->randomFloat(2, 50, 100),
            'contact_number' => $this->faker->phoneNumber,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'registered_by' => $this->faker->numberBetween(1, 10),
            'profile_photo_path' => $this->faker->imageUrl(450, 450, 'people', true, 'Profile', false, 'jpg'),
        ];
    }
}
