<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeederDevice extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Device::create([
                'uuid' => $faker->uuid,
                'config_info' => $faker->word,
                'premium_status' => $faker->boolean,
            ]);
        }
    }
}
