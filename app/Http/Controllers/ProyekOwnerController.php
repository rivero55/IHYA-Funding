<?php

namespace App\Http\Controllers;

use App\Models\ProyekOwner;

use Illuminate\Http\Request;

class ProyekOwnerController extends Controller
{
    public function index(){
        $proyek_owners= ProyekOwner::all();
        return view('admin.proyek_owner.index',compact('proyek_owners'));
    }
    public function create()
    {
        return view('admin.proyek_owner.create');
    }

}
