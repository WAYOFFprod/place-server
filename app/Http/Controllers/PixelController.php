<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Pixel;
use App\Events\PixelEvent;

class PixelController extends Controller
{

    public function add(Request $request) {
        $gridWidth = 1000;//Redis::get('grid:width');
        $x = $request->input('x');
        $y = $request->input('y');
        if($x < $gridWidth && $y < $gridWidth && $x >= 0  && $y >= 0) {
            $c = $request->input('color');
            $iden = $x + ($gridWidth * $y);
            Redis::set('pixel:'.$iden, $c);
            // Redis::publish('test-channel', json_encode([
            //     $iden => $c
            // ]));
            event(new PixelEvent($x, $y, $c));
            return Pixel::create($request->all());
        }
        return false;
    }
    public function index()
    {
        $key_prefix = 'pixel:';
        $pixels = [];
        $keysR = Redis::keys($key_prefix.'*');
        $keys = [];
        foreach($keysR as $pixel_key){
            array_push($keys, explode(':',$pixel_key)[1]);
        }

        $colors = Redis::pipeline(function ($pipe) use($keys, $pixels) {
            for ($x = 0; $x < count($keys); $x++) {
                Redis::get("pixel:".$keys[$x]);
                //$pixels[$keys[$x]] = Redis::get("pixel:".$keys[$x]);
            }
        });
        $pixels = [];
        for ($x = 0; $x < count($keys); $x++) {
            $pixels[$keys[$x]] = $colors[$x];
        }
        return $pixels;
        //return Pixel::all();
    }

    public function getAll()
    {
        return Pixel::get();
    }
 
    public function show($id)
    {
        return Pixel::find($id);
    }

    public function store(Request $request)
    {
        return Pixel::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Pixel::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Pixel::findOrFail($id);
        $article->delete();

        return 204;
    }
}
