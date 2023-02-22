<?php

namespace Database\Factories;

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hobby>
 */
class HobbyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'hobbies' => 'Dancing',
            'employee_id' => $this->faker->randomElement(Employee::pluck('id')),

        ];
    }
}
