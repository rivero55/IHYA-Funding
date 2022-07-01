<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyekOwnerController;
use App\Http\Controllers\ProyekBatchController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonasiController;
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
    return view('index');
})->name('landing');

Route::prefix('donasi')->group(function(){
    Route::get('/', [DonasiController::class, 'index'])->name('donation');
    Route::get('/{id}', [DonasiController::class, 'show'])->name('donation.show');
    Route::get('/{id}/donasi-amount', [DonasiController::class, 'donasiAmount'])->name('donation.amount');
});

Route::post('region',[AddressController::class, 'get_data'])->name('region');
Route::get('region-check',[AddressController::class, 'index'])->name('region-check');


Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function(){ 
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::resource('proyek-owner', ProyekOwnerController::class);
    Route::resource('proyek', ProyekController::class);
    Route::resource('proyek.batch', ProyekBatchController::class);
    Route::patch('proyek/{proyek_id}/batch/{batch_id}/status/update', [ProyekBatchController::class, 'updateStatus'])->name('proyek.batch.status.update');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
