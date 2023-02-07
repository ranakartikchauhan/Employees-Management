<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Facker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Facker::create();
        for ($i = 0; $i <= 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make($faker->password),
            ]);
        }
    }
}
