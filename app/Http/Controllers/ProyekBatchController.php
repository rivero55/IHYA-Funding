<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProyekBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $proyek=proyek::find($id);
        return view('admin.proyek_batch.create',compact('proyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($proyek_id, Request $request)
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($store) {
            // Toastr::success('Data berhasil ditambahkan', 'Berhasil!');
            return redirect()->route('proyek.show', $proyek_id);
        } else {
            // Toastr::error('Data gagal ditambahkan, coba lagi', 'Gagal!');
            return redirect()->back();
        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProyekBatch  $proyekBatch
     * @return \Illuminate\Http\Response
     */
    public function show(ProyekBatch $proyekBatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProyekBatch  $proyekBatch
     * @return \Illuminate\Http\Response
     */
    public function edit($proyek_id, $proyek_batch_id)
    {
        $proyek = Proyek::find($proyek_id);
        $proyek_batch = Proyekbatch::find($proyek_batch_id);
        return view ('admin.proyek_batch.edit',compact('proyek','proyek_batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProyekBatch  $proyekBatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$proyek_id, $proyek_batch_id)
    {
        //
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if(!empty($request->total_pendapatan)){
            $update = $proyek_batch->update([
                'total_pendapatan' => $request->total_pendapatan,
            ]);
        }
        if ($update) {
            // Toastr::success('Data berhasil diubah', 'Berhasil!');
            return redirect()->route('proyek.show', $proyek_id);
        } else {
            // Toastr::error('Data gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProyekBatch  $proyekBatch
     * @return \Illuminate\Http\Response
     */
    public function destroy($proyek_id,$proyek_batch_id)
    {
        //
        $proyek_batch = ProyekBatch::find($proyek_batch_id);
        $delete = $proyek_batch -> delete();
        if ($delete) {
            // Toastr::success('Data berhasil diubah', 'Berhasil!');
            return redirect()->route('proyek.show', $proyek_id);
        } else {
            // Toastr::error('Data gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function updateStatus($proyek_id, $proyek_batch_id, Request $request)
    {
        $proyek_batch = ProyekBatch::find($proyek_batch_id);

        $update = $proyek_batch->update([
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        //otomatis in vest dana jika sebelumnya investasi tahunan
        if($request->status == 'ongoing'){
            //notifikasi user
            // foreach($proyek_batch->user_portofolios as $portofolio){
            //     $portofolio->user->notify(new UserNotification('investnak_start','Proyek '.$proyek_batch->fullName().' Telah Selesai Pengumumplan Dana, Akan diteruskan kepada penerima donasi', route('profile.portofolio')));
            // }
        }elseif($request->status == 'closed') {
            $validatedData = $request->validate([
                'gross_income' => 'required|numeric',
            ]);
            $update = $proyek_batch->update([
                'gross_income' => $request->gross_income,
                'updated_at' => Carbon::now(),
            ]);
        

            //notifikasi user
            // foreach($proyek_batch->user_portofolios as $portofolio){
            //     $portofolio->user->notify(new UserNotification('investnak_stop','Proyek '.$proyek_batch->fullName().'  telah Selesai!', route('profile.portofolio')));
            // }

        }
        if ($update) {
            // $log = [
            //     'user_id' => Auth::user()->id,
            //     'workflow_type' => 'proyek',
            //     'activity' => 'edit',
            //     'description' => $proyek_batch->fullName().' '.$notif,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $document = Log::create($log);
            // Toastr::success('Batch berhasil ' . $notif, 'Berhasil!');
            return redirect()->route('proyek.show', $proyek_id);
        } else {
            // Toastr::error('Batch gagal ' . $notif . ' coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }
}
