<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekType;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function show($proyek_id, $proyek_batch_id)
    {
        $funding_detail = ProyekBatch::find($proyek_batch_id);
        return view('funding.show',compact('funding_detail'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($proyek_id,$proyek_batch_id)
    {
        $funding_batch = ProyekBatch::find($proyek_batch_id);
        $proyek_types= ProyekType::all();
        return view('funding.edit',compact('funding_batch','proyek_types'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $proyek_id, $proyek_batch_id)
    {
        $request->validate([
            'proyek_name' => 'required',
            'proyek_type'=>'required',
            'location'=>'required',
            'image' => 'nullable|file',
            'description'=>'nullable|string',
        ]);
        $update= proyek::find($proyek_id);
        // Overwrite image
    if ($request->hasFile('image')) {
        $existingImage = proyek::find($proyek_id)->image;
        Storage::disk('public')->delete('images/proyek/' . $existingImage);


        $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
        $image = $request->file('image')
        ->storeAs('public/images/proyek/', $fileNameImage);


        $image = Proyek::find($proyek_id)->update([
            'image' => $fileNameImage,
        ]);
    }
        $update_proyek=$update->update([
            'name' => $request->proyek_name,
            'type' => $request->type,
            'location' => $request->location_code,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
        ]);
        if (!$update_proyek) {
            Toastr::error('Gagal ', 'gagal!');
            return redirect()->back()->withInput();
        }

        $request->validate([
            'batch_no' => 'required|numeric',
            'minimum_fund' => 'required|numeric',
            'maximum_fund' => 'nullable|numeric',
            'target_nominal' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $proyek_batch = ProyekBatch::find($proyek_batch_id);
        
        $update = $proyek_batch->update([
            'proyek_id' => $proyek_id,
            'batch_no' => $request->batch_no,
            'minimum_fund' => $request->minimum_fund,
            'maximum_fund' => $request->maximum_fund,
            'target_nominal' => $request->target_nominal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'draft',
            'verification_status' => 'process',
            'updated_at' => Carbon::now(),
        ]);
        if(!empty($request->total_pendapatan)){
            $update = $proyek_batch->update([
                'total_pendapatan' => $request->total_pendapatan,
            ]);
        }
        if ($update) {
            Toastr::success('Data berhasil diubah', 'Berhasil!');
            return redirect()->route('funding.batch.show', [$proyek_id,$proyek_batch_id]);
        } else {
            Toastr::error('Data gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
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
