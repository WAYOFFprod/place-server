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
        $keys = Redis::keys($key_prefix.'*');
        //print_r($keys);
        foreach($keys as $pixel_key){
            //echo(Redis::get("pixel:".explode(':',$pixel_key)[1]));
            $pixels[explode(':',$pixel_key)[1]] = Redis::get("pixel:".explode(':',$pixel_key)[1]);
        }
        return $pixels;
        //return Pixel::all();
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
