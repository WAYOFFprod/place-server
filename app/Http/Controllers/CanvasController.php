<?php

namespace App\Http\Controllers;
use App\Models\Canvas;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CanvasController extends Controller
{
    public function create(Request $request) {
        // get user that sent request using attached token
        $user = Auth::user();
        $userID = $user->id;

        $ownedCanvases = Canvas::where('user_id', $userID)->count();
        if($ownedCanvases >= env('CANVAS_PER_USER', 2) && $userID != 1) {
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "You have too many canvas"
            ), 401);
        }

        return Canvas::create([
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'script_allowed' => $request->input('script_allowed'),
            'manual_allowed' => $request->input('manual_allowed'),
            'user_id' => $userID,
            'private' => $request->input('private'),
            'label' => $request->input('label'),
        ]);
    }

    public function get($id) {
        $canvas = Canvas::where('id', $id)->get();
        return $canvas;
    }

    public function getAll()
    {
        $user = auth('sanctum')->user();
        if(!is_null($user)) {
            $userID = $user->id;
            $canvas = Canvas::where('private', false)->orWhere('user_id', $userID)->get();
            //print_r($canvas);
            return $canvas;
        }
        $canvas = Canvas::where('private', false)->get();
        //print_r($canvas);
        return $canvas;
    }

    public function update(Request $request, $id)
    {
        $article = Canvas::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Canvas::findOrFail($id);
        $article->delete();

        return 204;
    }
}
