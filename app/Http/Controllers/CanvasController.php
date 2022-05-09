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

        $ownedCanvases = Canvas::where('owner', $userID)->count();
        if($ownedCanvases >= env('CANVAS_PER_USER', 2)) {
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
            'owner' => $userID,
            'private' => $request->input('is_private'),
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
            return Canvas::where('private', false)->orWhere('owner', $userID)->get();
        }
        return Canvas::where('private', false)->get();
    }

    public function update(Request $request, $id)
    {
        $article = Canvas::findOrFail($id);
        $article->update($request->all());

        return $article;
    }
}
