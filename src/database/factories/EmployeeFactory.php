<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'contract_type_id' => fake()->numberBetween(1, 5),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'last_name_kana' => fake()->lastKanaName(),
            'first_name_kana' => fake()->firstKanaName(),
            'post_code' => fake()->postcode(),
            'prefecture_id' => fake()->numberBetween(1, 47),
            'address' => fake()->streetAddress(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'birthday' => fake()->date($format='Y-m-d',$max='now'),
        ];
    }
}
