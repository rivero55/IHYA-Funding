<?php

namespace App\Http\Controllers;

use App\Models\ProyekBatch;
use App\Models\ProyekType;
use App\Models\UserProfile;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserCrowdfundingVerification extends Controller
{
    //
    public function userVerificationIndex()
    {
        $user_proyek = ProyekBatch::where('verification_status', 'process')->get();
        return view('admin.verification_proyek.index', compact('user_proyek'));
    }
    public function userVerificationModalBody($id){
        $proyek_batch = ProyekBatch::find($id);
        $profile = UserProfile::where('user_id', $proyek_batch->proyek->proyek_owner->user_id)->first();
        $documentBody = view('admin.verification_proyek.modal-body',compact('profile','proyek_batch'))->render();
        $documentFooter = view('admin.verification_proyek.modal-footer',compact('profile','proyek_batch'))->render();
        $rejectBody = view('admin.verification_proyek.modal-reject',compact('profile','proyek_batch'))->render();

        return response()->json([
            'documentBody' => $documentBody,
            'documentFooter' => $documentFooter,
            'rejectBody' => $rejectBody,
            
        ]);
    }
    public function userVerificationAccept(Request $request){
        $validatedData = $request->validate([
            'proyek_batch_id' => 'required',
        ]);

        $profile = ProyekBatch::find($request->proyek_batch_id);

        $update = $profile->update([
            'verification_status' => 'accepted',
            'verified_at' => Carbon::now(),
            'verification_feedback' => null,
            
        ]);
        if($update){
            // $log = [
            //     'user_id' => Auth::user()->id,
            //     'workflow_type' => 'user',
            //     'activity' => 'edit',
            //     'description' => 'Acc User Email: '.$profile->user->email,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $document = Log::create($log);
            // $profile->user->notify(new UserNotification('verification_accept','Selamat data anda telah diverifikasi, Anda sudah dapat melakukan investasi di Investnak', route('investnak')));
            Toastr::success('Verifikasi Crowdfunding User berhasil disetujui','Berhasil!');
            return redirect()->back();
        }else{
            Toastr::error('Verifikasi Crowdfunding User gagal disetujui, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function userVerificationReject(Request $request){
        $validatedData = $request->validate([
            'profile_id' => 'required',
            'verification_feedback' => 'required|string'
        ]);

        $profile = UserProfile::find($request->profile_id);

        $update = $profile->update([
            'verification_status' => 'rejected',
            'verification_feedback' => $request->verification_feedback,
        ]);
        if($update){
        //     $log = [
        //         'user_id' => Auth::user()->id,
        //         'workflow_type' => 'user',
        //         'activity' => 'edit',
        //         'description' => 'Reject User Email: '.$profile->user->email,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ];
        //     $document = Log::create($log);
        //     $profile->user->notify(new UserNotification('verification_reject','Mohon maaf data anda belum bisa diverifikasi, silahkan periksa kembali data anda', route('profile',['tab'=>'document'])));
            Toastr::success('Verifikasi Crowdfunding User berhasil ditolak','Berhasil!');
            return redirect()->back();
        }else{
            Toastr::error('Verifikasi Crowdfunding User gagal ditolak, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

