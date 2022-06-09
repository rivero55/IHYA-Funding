<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProyekController;
use App\Http\Controllers\ProyekOwnerController;

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
Route::get('/admin', function () {
    return view('admin.admin');})->name('admin');
Route::get('/event', [App\Http\Controllers\LandingController::class, 'listevent'])->name('event');
Route::get('/admin/proyek', function () {
    return view('admin.proyek.create');})->name('admin.proyek.create');
Route::get('/admin/proyek_owner', [ProyekOwnerController::class, 'index'])->name('admin.proyek_owner');;
Route::get('/admin/proyek_owner/create', [ProyekOwnerController::class, 'create'])->name('admin.proyek_owner.create');;
