<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekOwner;
use App\Models\UserDonation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $donasi = UserDonation::get()->count();
        $proyek_aktif = ProyekBatch::where('status','funding')->count();
        $verifikasi = ProyekBatch::where('verification_status','process')->count();
        $owner = ProyekOwner::get()->count();
        return view('admin.admin')->with(compact('donasi','proyek_aktif','verifikasi','owner'));
    }
}
