<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PixelController;
use App\Http\Controllers\GridController;
use App\Events\PixelEvent;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthController;

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

Route::get('/user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('/broadcast', function () {
    broadcast(new PixelEvent(0,0,"#ffffff"));
});

Route::post('/pixels/add', [PixelController::class, 'add'])->middleware('auth:sanctum');
Route::get('/pixels', [PixelController::class, 'index']);
Route::get('/pixels/{id}', [PixelController::class, 'show']);
Route::post('/pixels', [PixelController::class, 'store']);
Route::put('/pixels/{id}', [PixelController::class, 'update']);
Route::delete('/pixels/{id}', [PixelController::class, 'delete']);

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');