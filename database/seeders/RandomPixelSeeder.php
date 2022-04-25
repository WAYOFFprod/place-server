<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pixel;

class RandomPixelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 200000; $i++) {
            Pixel::create([
                'x' => $faker->randomNumber(4, false),
                'y' => $faker->randomNumber(4, false),
                'color' => $faker->hexColor(),
            ]);
        }
    }
}
