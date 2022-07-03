<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekType;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
            $proyek_batch = ProyekBatch::where('status','!=','draft')->limit(6)->get();
            return view('index')->with(compact('proyek_batch'));
        
    }
}
