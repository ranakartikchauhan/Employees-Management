<?php

namespace Database\Seeders;

use Faker\Factory as Facker;
use Illuminate\Database\Seeder;
use App\Models\Employe;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $status = [
            'Active',
            'Inactive',
            
        ];
        $gender = [
            'Male',
            'Female',
            'Other'
            
        ];
        $user_id = [
            '1',
            '2',
            '3',
            '4'
            
        ];
        //
        $faker = Facker::create();

        for ($i = 0; $i <= 100; $i++) {

            $employe = Employe::create(
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'gender' => $gender[rand(0, count($gender) - 1)],
                    'status' => $status[rand(0, count($status) - 1)],
                    'phone' => $faker->phoneNumber,
                    'user_id' => $user_id[rand(0, count($user_id) - 1)],
                ]
            );
        }

    }
}
