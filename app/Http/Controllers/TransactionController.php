<?php

namespace App\Http\Controllers;

use App\Models\ProyekBatch;
use App\Models\Transaction;
use App\Models\UserDonation;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Xendit\Xendit;
class TransactionController extends Controller
{
    private $token = 'xnd_development_w7VJDAI0a4a1D6oIQrn1zuaWy3cOOLuCUQKiJO2tlmUPkErMSA9Cbi6dCLP';
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
            'status' => 'PENDING',
            'description' => json_encode($description)
        ]);
        if ($request->payment_method == 'wallet') {
            $storeTransaction->user->minusBalance($nominal);
            $this->handlingDonation($storeTransaction);
            Toastr::success('Pembayaran berhasil dilakukan', 'Berhasil!');
            return redirect()->route('donation.show', $proyek_batch_id);
        } else {
            $invoice = $this->paymentxendit($storeTransaction);
            // dd($payment_token[0]);
            $storeTransaction->payment_token = $invoice['id'];
            // $storeTransaction->payment_url = $payment_token['invoice_url'];
            $invoice_url = $invoice['invoice_url'];
            $storeTransaction->payment_url = $invoice_url;
            $storeTransaction->save();
            return Redirect::to($invoice_url);
            // return redirect(Transaction::PAYMENT_URL() .$storeTransaction->payment_token);
        }
    }
    public function handlingDonation($transaction)
    {
        //jika request sudah settlement / capture di pembayaran wallet
        $transaction->update([
            'status' => 'PAID'
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
    
    public function paymentxendit($transaction){
        Xendit::setApiKey($this->token);
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $randNum = mt_rand(100, 999)
            . mt_rand(100, 999)
            . $chars[rand(0, strlen($chars) - 1)];

        // shuffle the result
        $randContractNum = str_shuffle($randNum);
        $contract_number = 'IHYAcharity' .  time() . $randContractNum;
        $params = [ 
            'external_id' => $contract_number,
            'amount' => (int)$transaction->nominal,
            'description' => $transaction->proyek_batch->fullName(),
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => Auth::user()->name,
                'email' => Auth::user()->email,
                'mobile_number' => '+6281287975596',
            ],
            'customer_notification_preference' => [
                'invoice_created' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_reminder' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_paid' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ],
                'invoice_expired' => [
                    'whatsapp',
                    'sms',
                    'email',
                    'viber'
                ]
            ],
            
            'success_redirect_url' => route('donation.show', [$transaction->proyek_batch_id,Toastr::success('Pembayaran berhasil dilakukan', 'Berhasil!')]),
            'failure_redirect_url' => route('donasiku.index'),
            'currency' => 'IDR',
            'items' => [
                [
                    'name' => $transaction->proyek_batch->fullName(),
                    'quantity' => 1,
                    'price' => (int)$transaction->nominal,
                    'category' => $transaction->proyek_batch->proyek->type,
                    'url' => url('/')
                ]
            ],
            'fees' => [
                [
                    'type' => 'ADMIN',
                    'value' => 5000
                ]
            ]
          ];
            
//   dd($params);
// if (empty($transaction->user_portofolio_id)) {

//     //portfolios
//     $description = json_decode($transaction->description, true);
//     $storePortfolio = UserDonation::create([
//         'user_id' => $transaction->user_id,
//         'proyek_id' => $transaction->proyek_batch->proyek->id,
//         'proyek_batch_id' => $transaction->proyek_batch_id,
//         'nominal' => $transaction->nominal,
//         'isAnonim'  => $description['anonim'],
//         'message'  => $description['message'],

//     ]);

//     $update = $transaction->update([
//         'user_donations_id' => $storePortfolio->id,
//     ]);
// }

    //update contract number
    // $update = $storePortfolio->update([
    //     'contract_number' => $storePortfolio->generateContractNumber(),
    // ]);
    // if ($update) {
    //     $transaction->user->notify(new UserNotification('transaction_outcome', 'Pembayaran anda sebesar Rp ' . number_format($transaction->nominal, 0, ",", ".") . ' telah berhasil dilakukan', route('profile.transaction')));
    // }
  $invoice = \Xendit\Invoice::create($params);
  return $invoice;

    }

    public function payoutXendit(Request $request, $id){
    $transaction = Transaction::where('proyek_batch_id',$id)->first();
        // $transaction->proyek_batch->currBalance();
    $currbalance= $transaction->proyek_batch->currBalance();
    if($request->nominal > $currbalance){
        Toastr::error('Tidak boleh melebihi Rp. '.number_format($currbalance,0,",",".") , 'Gagal!');
                return redirect()->back();
    }
    $request->validate([
        'nominal' => 'required|numeric',
        'description' => 'required|string'
    ]);
        Xendit::setApiKey($this->token);
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $randNum = mt_rand(100, 999)
            . mt_rand(100, 999)
            . $chars[rand(0, strlen($chars) - 1)];

        // shuffle the result
        $randContractNum = str_shuffle($randNum);
        $contract_number = 'payout' .  time() . $randContractNum;
        $storeTransaction = Transaction::create([
        'user_id' => Auth::user()->id,
        'type' => 'donasi',
        'transaction_type' => 'outcome',
        'proyek_batch_id' => $id,
        'nominal' => $request->nominal,
        'payment_method' => "TRANSFER PAYOUT",
        'description'=> $request->description,
        'status' => 'PENDING',
        ]);
    // $outcome = Transaction::where('proyek_batch_id',$id)->where('transaction_type', 'outcome')->where('status', 'completed')->sum('nominal');

        $params = [
            'external_id' => $contract_number,
            'amount' => (int)$request->nominal,
            'email' => Auth::user()->email,
        ];
          $createPayout = \Xendit\Payouts::create($params);
          $id = $createPayout['id'];
          $payment_token = \Xendit\Payouts::retrieve($id);
        //   dd($payment_token);
          $storeTransaction->payment_token = $payment_token['id'];
          $payout_url = $payment_token['payout_url'];
          $storeTransaction->payment_url = $payout_url;
          $storeTransaction->external_id = $payment_token['external_id'];;
          $storeTransaction->save();
          return Redirect::to($payout_url);
    }

    

}