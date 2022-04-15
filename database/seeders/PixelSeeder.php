<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Seeder;
use App\Models\Pixel;

class PixelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pixel::truncate();
        Redis::flushDB();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        // for ($i = 0; $i < 50; $i++) {
        //     Pixel::create([
        //         'x' => $faker->randomNumber(4, false),
        //         'y' => $faker->randomNumber(4, false),
        //         'color' => $faker->hexColor(),
        //     ]);
        // }

    }
}
