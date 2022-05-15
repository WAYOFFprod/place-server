<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Pixel;
use App\Models\Canvas;
use App\Events\PixelEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PixelController extends Controller
{

    public function add(Request $request) {
        $canvas_id = $request->input('canvas_id');
        $canvas = Canvas::find($canvas_id);
        if(is_null($canvas)) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "canvas '".$canvas_id."' doesn't exist"
            ), 400);
        }

        $gridWidth = $canvas->width;

        // get user that sent request using attached token
        $user = Auth::user();
        $userID = $user->id;

        if($canvas->private == 1) {
            if($userID != $canvas->owner) {
                return response()->json(array(
                    'code'      =>  401,
                    'message'   =>  "you are not allowed to place pixels on this canvas"
                ), 401);
            }
        }

        
        $isManual = $request->input('is_manual') && $request->header('Client') == 'og-place' && $request->headers->get('origin') == env('APP_ORIGIN_URL', 'http://localhost:8080');
        if(!$canvas->script_allowed && !$isManual) {
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "scripts and bot not allowed on this canvas"
            ), 401);
        }

        if(!$canvas->manual_allowed && $isManual) {
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Manual pixel placement not allowed on this canvas"
            ), 401);
        }

        $x = $request->input('x');
        $y = $request->input('y');
        if($x < $gridWidth && $y < $gridWidth && $x >= 0  && $y >= 0) {
            $c = $request->input('color');
            $iden = $x + ($gridWidth * $y);
            Redis::set('pixel-'.$canvas_id.':'.$iden, $c);
            // Redis::publish('test-channel', json_encode([
            //     $iden => $c
            // ]));
            event(new PixelEvent($x, $y, $c, $canvas_id));
            return Pixel::create([
                'x' => $x,
                'y' => $y,
                'user_id' => $userID,
                'color' => $c,
                'is_manual' => $isManual,
                'canvas_id' => $canvas_id
            ]);
        }
        return response()->json(array(
            'code'      =>  400,
            'message'   =>  "The pixel is outside the canvas"
        ), 400);
    }
    public function getPixels($id)
    {
        $key_prefix = 'pixel-'.$id.':';
        $pixels = [];
        $keysR = Redis::keys($key_prefix.'*');
        $keys = [];
        foreach($keysR as $pixel_key){
            array_push($keys, explode(':',$pixel_key)[1]);
        }

        $colors = Redis::pipeline(function ($pipe) use($keys, $pixels, $id) {
            for ($x = 0; $x < count($keys); $x++) {
                Redis::get("pixel-".$id.":".$keys[$x]);
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

    public function getUser($x, $y) {
        $pixel = Pixel::where('canvas_id', 1)->where('x', $x)->where('y', $y)->orderBy('created_at', 'desc')->first();
        if(is_null($pixel)) {
            return $pixel;
        }
        return $pixel->user;
    }

    public function getUserWithBoard($board, $x, $y) {
        $pixel = Pixel::where('canvas_id', $board)->where('x', $x)->where('y', $y)->orderBy('created_at', 'desc')->first();
        if(is_null($pixel)) {
            return $pixel;
        }
        return $pixel->user;
    }

    public function get($board, $x, $y) {
        $pixel = Pixel::where('canvas_id', $board)->where('x', $x)->where('y', $y)->orderBy('created_at', 'desc')->first();
        if(is_null($pixel)) {
            return $pixel;
        }
        return $pixel->loadMissing('user');
    }

    public function getColor($canvas_id, $x, $y) {
        $canvas = Canvas::find($canvas_id);
        if(is_null($canvas)) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "canvas '".$canvas_id."' doesn't exist"
            ), 400);
        }
        $gridWidth = $canvas->width;

        $iden = $x + ($gridWidth * $y);
        return Redis::get("pixel-".$canvas_id.":".$iden);
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
