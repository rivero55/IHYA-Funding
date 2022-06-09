<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function listevent()
    {
        $datas= proyek::all();
        return view('event')->with(compact('datas'));
    }
}
