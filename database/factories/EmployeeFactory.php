<?php

namespace Database\Factories;
use Faker\Factory as Facker;
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
        $faker = Facker::create();

        return [
            //

            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'gender'=>$faker->randomElement(['Male', 'Female']),
            'is_active'=>$faker->randomElement([0,1]),
            'phone'=>$faker->phoneNumber,
            'user_id'=>\App\Models\User::factory()->create()->id,
        ];
    }
}