<?php

namespace App\Http\Controllers;

use App\Models\ProyekBatch;
use App\Models\Transaction;
use App\Models\UserDonation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function payDonation($proyek_id, $proyek_batch_id, Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric',
            'payment_method' => 'required|string'
        ]);
        $proyek_batch = ProyekBatch::find($proyek_batch_id);

        //cek apakah sudah fullyfunded
        if ($proyek_batch->isFullyFunded()) {
            Toastr::error('Investasi sudah ditutup', 'Gagal!');
            return redirect()->back();
        }

        //hitung nominal
        $nominal = $request-> nominal;
        $maks_fund= $proyek_batch->maximum_fund; 
        // dd($maks_fund);
        if($maks_fund != null){
            // dd($maks_fund);
        if ($nominal > $maks_fund ) {
            //cek saldo
                Toastr::error('Tidak boleh melebihi Rp. '.number_format($maks_fund,0,",",".") , 'Gagal!');
                return redirect()->back();
        }
    }
        //cek saldo jika pake wallet
        if ($request->payment_method == 'wallet') {
            //cek saldo
            if (Auth::user()->balance < $nominal) {
                Toastr::error('Saldo tidak mencukupi', 'Gagal!');
                return redirect()->back();
            }
        }
        $description = [
            'anonim' => $request->anonim ? 1 : 0,
            'message' => $request->message,
        ];
        // dd($description);

        //transaction
        $storeTransaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'type' => 'donasi',
            'transaction_type' => 'income',
            'proyek_batch_id' => $proyek_batch_id,
            'nominal' => $nominal,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'description' => json_encode($description)
        ]);
        if ($request->payment_method == 'wallet') {
            $storeTransaction->user->minusBalance($nominal);
            $this->handlingDonation($storeTransaction);
            Toastr::success('Pembayaran berhasil dilakukan', 'Berhasil!');
            return redirect()->back();
        } else {
            $payment_token = $this->_generatePaymentToken($storeTransaction->id, $nominal);
            $storeTransaction->payment_token = $payment_token;
            $storeTransaction->save();

            return redirect(Transaction::PAYMENT_URL() .$storeTransaction->payment_token);
        }
    }
    public function handlingDonation($transaction)
    {
        //jika request sudah settlement / capture
        $transaction->update([
            'status' => 'success'
        ]);
        if (empty($transaction->user_portofolio_id)) {

            //portfolios
            $description = json_decode($transaction->description, true);
            $storePortfolio = UserDonation::create([
                'user_id' => $transaction->user_id,
                'proyek_id' => $transaction->proyek_batch->proyek->id,
                'proyek_batch_id' => $transaction->proyek_batch_id,
                'nominal' => $transaction->nominal,
                'isAnonim'  => $description['anonim'],
                'message'  => $description['message'],

            ]);

            $update = $transaction->update([
                'user_donations_id' => $storePortfolio->id,
            ]);

            //update contract number
            // $update = $storePortfolio->update([
            //     'contract_number' => $storePortfolio->generateContractNumber(),
            // ]);
            // if ($update) {
            //     $transaction->user->notify(new UserNotification('transaction_outcome', 'Pembayaran anda sebesar Rp ' . number_format($transaction->nominal, 0, ",", ".") . ' telah berhasil dilakukan', route('profile.transaction')));
            // }
        }
    }

    

}

