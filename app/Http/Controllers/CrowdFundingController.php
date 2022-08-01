<?php

namespace App\Http\Controllers;

use App\Models\proyek;
use App\Models\ProyekBatch;
use App\Models\ProyekOwner;
use App\Models\ProyekType;
use App\Models\UserDonation;
use App\Models\UserProfile;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrowdFundingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        $user = Auth::user();
        $proyek_owner = ProyekOwner::where('user_id', $user->id)->get('id');
        $proyek = proyek::whereIn('owner_id', $proyek_owner)->get('id');
        // dd($proyek);
        $user_crowdfunding = ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->get();
        $user_crowdfunding_active = ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->where('status', 'funding' )->get();
        $user_crowdfunding_rejected= ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->where('verification_status', 'rejected' )->get();
        $user_crowdfunding_review= ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->where('verification_status', 'process' )->get();
        $user_crowdfunding_closed= ProyekBatch::whereIn('proyek_id', $proyek ?? 0)->where('status', 'closed' )->get();
        // dd($user_crowdfunding);
        // $portofolio_progress = UserDonation::where('user_id', $user->id)->whereHas('project_batch', function($query){
        //     $query->whereNotIn('status', ['paid', 'closed']);
        // })->get();
        return view('funding.funding', compact('user','user_crowdfunding','user_crowdfunding_active','user_crowdfunding_rejected','user_crowdfunding_review','user_crowdfunding_closed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user=Auth::user();
        $proyek_types=ProyekType::all();
        $proyek_owners=ProyekOwner::where('user_id', $user->id)->first();
        $user_profile=UserProfile::where('user_id', $user->id)->first();
    
        return view('funding.create',compact('proyek_types','proyek_owners','user_profile'));

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
        
        $user_profile=  $request->validate([
            'nama_ktp' => 'required|string',
            'no_ktp'=>'required|digits:16',
            'job'=>'required|string',
            'job_detail' => 'required|string',
            'social_media'=>'required|string',
            'social_media_link'=>'required|string',
            
        ]);
        $proyek_owner=  $request->validate([
            'user_id' => 'required|int',
            'tujuan_penggalang' => 'required|string'
            
        ]);
        $crowdfunding= $request->validate([
            'proyek_name' => 'required',
            'proyek_type'=>'required',
            'location'=>'required',
            'image' => 'required|image',
            'description'=>'required|string',
        ]);
        $proyek_batch=$request->validate([
            'batch_no' => 'required|numeric',
            'minimum_fund' => 'required|numeric',
            'maximum_fund' => 'nullable|numeric',
            'target_nominal' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $store_user_profile = UserProfile::firstOrCreate([
            'user_id' => $request->user_id,
        ],[
            'ktp_name' => $request->nama_ktp,
            'ktp_number' => $request->no_ktp,
            'job' => $request->job,
            'job_detail' => $request->job_detail,
            'social_media' => $request->social_media,
            'social_link' => $request->social_media_link,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if (!$store_user_profile) {
            Toastr::error('Gagal ', 'gagal!');
            return redirect()->back()->withInput();
        }
        $proyek_owner_check = ProyekOwner::firstOrCreate([
            'user_id' => Auth::user()->id
        ],
        [
            'name' => Auth::user()->name,
            'description' => $request->tujuan_penggalang
        ]);
        if (!$proyek_owner_check) {
            Toastr::error('Gagal ', 'gagal!');
            return redirect()->back()->withInput();
        }
    


        #rename file image to new name 
        $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
        #add to storage
        $image = $request->file('image')
            ->storeAs('public/images/proyek/', $fileNameImage);
        $store_proyek = proyek::create([
            'owner_id' => $proyek_owner_check->id,
            'name' => $request->proyek_name,
            'type' => $request->proyek_type,
            'location' => $request->location,
            'image'=> $fileNameImage,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // dd($store_proyek);
        if (!$store_proyek) {
            Toastr::error('Gagal ', 'gagal!');
            return redirect()->back()->withInput();
        }
        $store_proyek_batch = ProyekBatch::insert([
            'proyek_id' => $store_proyek->id,
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
        if($store_proyek_batch){
            // $log = [
            //     'user_id' => Auth::user()->id,
            //     'workflow_type' => 'project',
            //     'activity' => 'add',
            //     'description' => 'Add Project '.$request->project_name,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $document = Log::create($log);
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('funding.index');
            }else{
                Toastr::error('Data gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back()->withInput();
            dd($store_proyek);
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
        //
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
