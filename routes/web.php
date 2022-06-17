<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyekOwnerController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/landing', function () {
    return view('index');
})->name('landing');

Route::get('/event', [App\Http\Controllers\LandingController::class, 'listevent'])->name('event');
Route::get('/admin/proyek', function () {
    return view('admin.proyek.create');})->name('admin.proyek.create');

Route::post('region',[AddressController::class, 'get_data'])->name('region');
Route::get('region-check',[AddressController::class, 'index'])->name('region-check');


Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function(){ 
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::resource('proyek-owner', ProyekOwnerController::class);
    Route::resource('proyek', ProyekController::class);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
