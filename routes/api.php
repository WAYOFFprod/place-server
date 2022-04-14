<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PixelController;
use App\Http\Controllers\GridController;
use App\Events\PixelEvent;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('/broadcast', function () {
    broadcast(new PixelEvent(0,0,"#ffffff"));
});

Route::post('/pixels/add', [PixelController::class, 'add']);
Route::get('/pixels', [PixelController::class, 'index']);
Route::get('/pixels/{id}', [PixelController::class, 'show']);
Route::post('/pixels', [PixelController::class, 'store']);
Route::put('/pixels/{id}', [PixelController::class, 'update']);
Route::delete('/pixels/{id}', [PixelController::class, 'delete']);

//Route::get('/grid-size/{width}', [GridController::class, 'updateGridSize']);
