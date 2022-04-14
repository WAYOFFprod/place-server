<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class GridController extends Controller
{
    public function updateGridSize(Request $request) {
        $width = $request->input('width');
        return Redis::set('grid:width', $width);
    }
}
