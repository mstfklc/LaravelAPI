<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeederUser extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        /*$faker = Faker::create();
            \App\Models\User::create([
                'email' => 'testemail@test.com',
                'name' => 'testuser',
                'password' => Hash::make('123456'),
                'is_admin' => true,
            ]);*/
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            \App\Models\User::create([
                'email' => $faker->email,
                'name' => $faker->firstName,
                'password' => Hash::make($faker->password),
                'is_admin' => true,
            ]);
        }
    }
}
