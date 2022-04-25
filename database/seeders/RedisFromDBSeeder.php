<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Redis;
use App\Models\Pixel;
use App\Http\Controllers\PixelController;

class RedisFromDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Redis::pipeline(function ($pipe) {
            $gridWidth = 1000;//Redis::get('grid:width');
            $pixels = (new PixelController())->getAll();
            foreach($pixels as $pixel){
                $iden = $pixel->x + ($gridWidth * $pixel->y);
                $pipe->set('pixel:'.$iden, $pixel->color);
            }
        });
    }
}
