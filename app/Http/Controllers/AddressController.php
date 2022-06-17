<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;



class AddressController extends Controller
{
    //
    public function get_data(Request $request){
        $type = $request->type;
        $code = $request->code;
        $length = ($type == 'province' ? 2 : ($type == 'district' ? 5: ($type == 'sub-district' ? 8 : 13)));
        
        $data = Address::whereRaw('LEFT(`kode`, '.strlen($code).') = "'.$code.'"')->whereRaw("CHAR_LENGTH(kode) =".$length)->orderBy('nama')->get();
        
		return response()->json($data);
    }

    public function index(){

        $type = 'province';
        $code = '';
        $length = ($type == 'province' ? 2 : ($type == 'district' ? 5: ($type == 'sub-district' ? 8 : 13)));
        
        $data = Address::whereRaw('LEFT(`kode`, '.strlen($code).') = "'.$code.'"')->whereRaw("CHAR_LENGTH(kode) =".$length)->orderBy('nama')->get();
        dd($data);
        return view('admin.admin');
        
    }
}
