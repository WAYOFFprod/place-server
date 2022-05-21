<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColorSelection;
use App\Models\PixelArray;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PresetController extends Controller
{
    public function add(Request $request) {
        $user = Auth::user();
        $userID = $user->id;

        $cs = ColorSelection::create([
            'label' => $request->input('c_label'),
            'data' => $request->input('c_data'),
            'is_private' => $request->input('c_is_private'),
            'user_id' => $userID,
        ]);

        $pa = PixelArray::create([
            'label' => $request->input('p_label'),
            'data' => $request->input('p_data'),
            'is_private' => $request->input('p_is_private'),
            'user_id' => $userID,
        ]);

        $pa->colorSelection()->associate($cs);

        $pa->save();
        
        return $pa;
    }

    public function getArrays() {
        return PixelArray::all()->loadMissing('colorSelection');
    }

    public function getColors() {
        return ColorSelection::all();
    }
}
