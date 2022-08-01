<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekOwner;
use App\Models\ProyekType;
use App\Models\UserDonation;
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
        $user_donations = UserDonation::where('proyek_batch_id', $id)->get();
        $donatur = $user_donations->count();
        $user_donations_message = UserDonation::where('proyek_batch_id', $id)->where('message' ,'!=', null)->get();
        // dd($user_donations);
        return view('donation.show', compact('proyek_batch', 'user_donations','user_donations_message','donatur'));
    }
    public function donasiDonatur($proyek_batch_id)
    {
        $user_donations_donatur = UserDonation::where('proyek_batch_id', $proyek_batch_id)->get();
        return view('donation.donation-donatur')->with(compact('user_donations_donatur'));
        
    }
    public function donasiDoa($proyek_batch_id)
    {
        $user_donations_doa = UserDonation::where('proyek_batch_id', $proyek_batch_id)->where('message' ,'!=', null)->get();
        return view('donation.donation-doa')->with(compact('user_donations_doa'));
        
    }
    public function penggalang($owner_id)
    {
        $proyek_owner= ProyekOwner::find($owner_id);
        $proyek = proyek::where('owner_id', $proyek_owner->id ?? 0)->get('id');
        $penggalang_crowdfunding = ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->get();
        return view('donation.penggalang')->with(compact('proyek_owner','penggalang_crowdfunding'));
        
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
