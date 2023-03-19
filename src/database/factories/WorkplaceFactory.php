<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workplce>
 */
class WorkplaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => fake()->numberBetween(1, 30),
            'name' => fake()->streetName() . '店',
            'post_code' => fake()->postcode(),
            'prefecture_id' => fake()->numberBetween(1, 47),
            'address' => fake()->streetAddress(),
            'phone_number' => fake()->unique()->phoneNumber(),
        ];
    }
}
