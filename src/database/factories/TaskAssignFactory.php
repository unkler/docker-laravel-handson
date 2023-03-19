<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskAssignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'workplace_id' => fake()->numberBetween(1, 50),
            'employee_id' => fake()->numberBetween(1, 100),
            'implementation_date' => fake()->date($format='Y-m-d',$min='now'),
        ];
    }
}
