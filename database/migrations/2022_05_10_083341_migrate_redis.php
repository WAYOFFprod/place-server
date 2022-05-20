<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\PixelController;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pixels = (new PixelController())->getAll();
        Redis::pipeline(function ($pipe) use($pixels) {
            $gridWidth = 1000;//Redis::get('grid:width');
            foreach($pixels as $pixel){
                $iden = $pixel->x + ($gridWidth * $pixel->y);
                $pipe->set('pixel:'.$iden, $pixel->color);
            }
        });
        // $key_prefix = 'pixel:';
        // $keysR = Redis::keys($key_prefix.'*');
        // $keys = [];
        // foreach($keysR as $pixel_key){
        //     array_push($keys, explode(':',$pixel_key)[1]);
        // }

        // $colors = Redis::pipeline(function ($pipe) use($keys, $pixels) {
        //     for ($x = 0; $x < count($keys); $x++) {
        //         Redis::get("pixel:".$keys[$x]);
        //     }
        // });
        // $id = 1;
        // Redis::pipeline(function ($pipe) use($keys, $colors, $id) {
        //     for ($x = 0; $x < count($keys); $x++) {
        //         Redis::set("pixel-".$id.":".$keys[$x], $colors[$x]);
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
