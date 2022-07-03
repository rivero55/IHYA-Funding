<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekType;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $types = ProyekType::all();
            $proyek_batch = ProyekBatch::where('status','!=','draft')->limit(5)->get();
            return view('donation.donation')->with(compact('types','proyek_batch'));
        
    }
    public function donasiAmount($proyek_id,$proyek_batch_id)
    {
            $proyek = proyek::find($proyek_id);
            $proyek_batch= ProyekBatch::find($proyek_batch_id);
            return view('donation.donation-amount')->with(compact('proyek','proyek_batch'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyek_batch= ProyekBatch::find($id);
        return view('donation.show', compact('proyek_batch'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
