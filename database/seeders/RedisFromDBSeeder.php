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
        $pixels = (new PixelController())->getAll();
        Redis::pipeline(function ($pipe) use($pixels) {
            $gridWidth = 1000;//Redis::get('grid:width');
            foreach($pixels as $pixel){
                $iden = $pixel->x + ($gridWidth * $pixel->y);
                $pipe->set('pixel:'.$iden, $pixel->color);
            }
        });
    }
}
