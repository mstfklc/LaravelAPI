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
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'email' => $faker->unique()->safeEmail,
                'name' => $faker->firstName,
                'password' => Hash::make($faker->password),
                'is_admin' => true,
                ]);
        }
    }
}
