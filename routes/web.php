<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyekOwnerController;
use App\Http\Controllers\ProyekBatchController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TransactionController;
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


Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('donasi')->group(function(){
    Route::get('/', [DonasiController::class, 'index'])->name('donation');
    Route::get('/{id}', [DonasiController::class, 'show'])->name('donation.show');
    Route::get('/donasi-amount/{id}/{batch_id}', [DonasiController::class, 'donasiAmount'])->name('donation.amount');
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
Route::middleware(['auth', 'checkRole:admin,user,instansi'])->group(function(){ 

Route::post('/pay/donation/{proyek_id}/{proyek_batch_id}', [TransactionController::class, 'payDonation'])->name('pay.donation');
});

Auth::routes();

Route::get('/redirects', function(){
	// You can replace above line with the following to return to previous page
	return redirect()->back()->getTargetUrl();
})->name(('redirects'));
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
