<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

use App\Models\Image;
use App\Models\Canvas;

class ImageController extends Controller
{
    public function upload(Request $request) {
        $file = null;
        $canvas_id = $request->input('canvas_id');

        $validator = Validator::make($request->all(),[ 
            'file' => 'required|mimes:jpg,png,jpeg,gif|max:2048',
        ]);   

        if($validator->fails()) {         
            // check if base64 image 
            if(str_contains($request->input('file'), ';base64,')) {
                $bin = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$request->input('file'))); 
                $file = imageCreateFromString($bin);
                Storage::disk('public')->put('/' . 'canvas-'.$canvas_id.'.png', $bin);
                $path = 'storage/' . 'canvas-'.$canvas_id.'.png';
            } else {
                return response()->json(['error'=>$validator->errors()], 401);
            }
        }


        if($file == null && $request->file('file')) {
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
        print_r($image->id);
        $article = Canvas::findOrFail($canvas_id);
        $article->update(array('preview_id' => $image->id));
        
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
