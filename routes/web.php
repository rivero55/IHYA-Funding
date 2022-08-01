<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyekOwnerController;
use App\Http\Controllers\ProyekBatchController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CrowdFundingBatchController;
use App\Http\Controllers\CrowdFundingController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProyekTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserCrowdfundingVerification;
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
    Route::get('/{batch_id}/donatur', [DonasiController::class, 'donasiDonatur'])->name('donation.donatur');
    Route::get('/{batch_id}/doa-orang-baik', [DonasiController::class, 'donasiDoa'])->name('donation.doa');
});

Route::post('region',[AddressController::class, 'get_data'])->name('region');
Route::get('region-check',[AddressController::class, 'index'])->name('region-check');
Route::get('/penggalang/{owner_id}', [DonasiController::class, 'penggalang'])->name('donation.penggalang');

Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function(){ 
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::resource('proyek-owner', ProyekOwnerController::class);
    Route::resource('proyek-type', ProyekTypeController::class);
    Route::resource('proyek', ProyekController::class);
    Route::resource('proyek.batch', ProyekBatchController::class);
    Route::get('verification_proyek', [UserCrowdfundingVerification::class, 'userVerificationIndex'])->name('verification_proyek');
    Route::patch('/user_verification/reject', [UserCrowdfundingVerification::class, 'userVerificationReject'])->name('user.verification.reject');
    Route::patch('/user_verification/accept', [UserCrowdfundingVerification::class, 'userVerificationAccept'])->name('user.verification.accept');
    Route::get('/user_verification/{user_id}', [UserCrowdfundingVerification::class, 'userVerificationModalBody'])->name('user.verification.modal-body');
    Route::patch('proyek/{proyek_id}/batch/{batch_id}/status/update', [ProyekBatchController::class, 'updateStatus'])->name('proyek.batch.status.update');
});
Route::middleware(['auth', 'checkRole:user,admin'])->group(function(){ 
Route::post('/pay/donation/{proyek_id}/{proyek_batch_id}', [TransactionController::class, 'payDonation'])->name('pay.donation');
Route::resource('funding', CrowdFundingController::class);
Route::resource('funding.batch', CrowdFundingBatchController::class);
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
