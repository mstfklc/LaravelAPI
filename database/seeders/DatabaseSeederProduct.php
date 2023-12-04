<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeederProduct extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Product::create([
                'name' => $faker->name,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 100),
            ]);
        }
    }
}
