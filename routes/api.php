<?php

use App\Http\Controllers\API\ProyekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('proyek', [ProyekController::class, 'index']);
Route::post('proyek/store', [ProyekController::class, 'store']);
Route::get('proyek/show/{id}', [ProyekController::class, 'show']);
Route::post('proyek/update/{id}', [ProyekController::class, 'update']);
Route::delete('proyek/delete/{id}', [ProyekController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
