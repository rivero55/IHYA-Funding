<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CrowdFundingBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('funding.batch');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $proyek = proyek::find($id);
        return view('funding.batch', compact('proyek'));
         //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $proyek_id)
    {
        $request->validate([
            'batch_no' => 'required|numeric',
            'minimum_fund' => 'required|numeric',
            'maximum_fund' => 'nullable|numeric',
            'target_nominal' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        
        $store = ProyekBatch::insert([
            'proyek_id' => $proyek_id,
            'batch_no' => $request->batch_no,
            'minimum_fund' => $request->minimum_fund,
            'maximum_fund' => $request->maximum_fund,
            'target_nominal' => $request->target_nominal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'draft',
            'verification_status' => 'process',
            'verified_at' =>Carbon::now() ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($store) {
            Toastr::success('Data berhasil ditambahkan', 'Berhasil!');
            return redirect()->route('funding.index');
        } else {
            Toastr::error('Data gagal ditambahkan, coba lagi', 'Gagal!');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   
        
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
