<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Facker;
use Illuminate\Database\Seeder;

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
            $user = User::Factory()->count(1)->create();
        }
    }
}
