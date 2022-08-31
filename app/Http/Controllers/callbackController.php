<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Transaction;
use App\Models\UserDonation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class callbackController extends Controller
{
    //
    public function callback(Request $request){
        try {        
           $xenditXCallbackToken = 'xTWwgafVhCS3LJURnJXGJZ8vdb4A63zi4Tbgxf2PcEje764q';
           $reqHeaders = getallheaders();
           $xIncomingCallbackTokenHeader = isset($reqHeaders['X-CALLBACK-TOKEN']) ? $reqHeaders['X-CALLBACK-TOKEN'] : "";
           if($xIncomingCallbackTokenHeader == $xenditXCallbackToken){
            $json = json_decode($request->getContent(), true);
            Log::info($json);
        

            $trans = Transaction::updateOrCreate(
            [
                'payment_token' => $json['id'],
                'nominal' => $json['amount'],
            ],
            [
                
                'status' => $json['status'],
                'update_at' => Carbon::parse(Log::info(isset($json['paid_at']) ? $json['paid_at'] : $json['updated']))->format('Y-m-d H:i:s'),

            ]
            );
            if($trans->status == "PAID"){
            if (empty($trans->user_portofolio_id)) {

                //portfolios
                $description = json_decode($trans->description, true);
                $storePortfolio = UserDonation::create([
                    'user_id' => $trans->user_id,
                    'proyek_id' => $trans->proyek_batch->proyek->id,
                    'proyek_batch_id' => $trans->proyek_batch_id,
                    'nominal' => $trans->nominal,
                    'isAnonim'  => $description['anonim'],
                    'message'  => $description['message'],
            
                ]);
            
                $update = $trans->update([
                    'user_donations_id' => $storePortfolio->id,
                ]);
            }}

            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $json
               
            ]);
           }
           //code...
        } catch (Exception $error) {
            //throw $th;
            return ApiFormatter::createApi(400, 'Failed');
        }
       
    }
    public function callbackpayout(Request $request){
        try {        
           $xenditXCallbackToken = 'xTWwgafVhCS3LJURnJXGJZ8vdb4A63zi4Tbgxf2PcEje764q';
           $reqHeaders = getallheaders();
           $xIncomingCallbackTokenHeader = isset($reqHeaders['X-CALLBACK-TOKEN']) ? $reqHeaders['X-CALLBACK-TOKEN'] : "";
           if($xIncomingCallbackTokenHeader == $xenditXCallbackToken){
            $json = json_decode($request->getContent(), true);
            Log::info($json);
            $trans = Transaction::updateOrCreate(
                [
                    'external_id' => $json['external_id'],
                    'nominal' => $json['amount'],
                ],
                [
                    
                    'status' => $json['status'],
                    'update_at' => Carbon::parse(Log::info(isset($json['status_updated']) ? $json['status_updated'] : $json['updated']))->format('Y-m-d H:i:s'),
    
                ]
                );
                Log::info($trans);

            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $json
               
            ]);
           }
           //code...
        } catch (Exception $error) {
            //throw $th;
            return ApiFormatter::createApi(400, 'Failed we');
        }
       
    }

}
