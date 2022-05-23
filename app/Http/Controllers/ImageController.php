<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

use App\Models\Image;
use App\Models\Canvas;

use App\Rules\Base64;

class ImageController extends Controller
{
    public function upload(Request $request) {
        $file = null;
        $path = '';
        $canvas_id = $request->input('canvas_id');

        $validator = Validator::make($request->all(),[ 
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'canvas_id' => 'required|numeric',
            'name' => 'required|string|max:255'
        ]);

        $validator->sometimes('file', new Base64, function ($input) {
            return str_contains($input->file, ';base64,');
        });
        $validator->sometimes('file', 'required|mimes:jpg,png,jpeg,gif|max:10000', function ($input) {
            return !str_contains($input->file, ';base64,');
        });

        if($validator->fails()) {         
            // check if base64 image 
            return response()->json(['error'=>$validator->errors()], 401);
        } else {
            print_r("not failed");
        }

        if(str_contains($request->input('file'), ';base64,')) {
            $bin = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$request->input('file'))); 
            $file = imageCreateFromString($bin);
            Storage::disk('public')->put('/' . 'canvas-'.$canvas_id.'.png', $bin);
            $path = 'storage/' . 'canvas-'.$canvas_id.'.png';
        } else if($file == null && $request->file('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('public', 'canvas-'.$canvas_id.'.png' );
            $path = str_replace('public/', 'storage/', $path);
        }
    
        //store your file into directory and db
        $image = Image::create([
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'name' => $request->input('name'),
            'path' => $path,
        ]);

        $canvas = Canvas::findOrFail($canvas_id);
        $canvas->preview()->associate($image);

        $canvas->save();
        
        return response()->json([
            "success" => true,
            "message" => "File was successfully uploaded",
            "file" => $path
        ]);

        return response()->json(array(
            'code'      =>  401,
            'message'   =>  "missing file"
        ), 401);
    }
    
}
