<?php

namespace App\Http\Controllers;

use App\Models\ProyekType;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProyekTypeController extends Controller
{
    public function index(){
        $proyek_types= ProyekType::all();
        return view('admin.proyek_type.index',compact('proyek_types'));
    }

    public function create()
    {
        return view('admin.proyek_type.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        $store = ProyekType::insert([
            'name' => $request->name,
          
        ]);

        if($store){
            Toastr::success('Data berhasil ditambah','Berhasil!');
            return redirect()->route('proyek-type.index');
        }else{
            Toastr::error('Data gagal ditambah','Gagal!');

            return redirect()->back();

        }
    }

    public function edit($id)
    {
        $proyek_type = ProyekType::find($id);
        return view('admin.proyek_type.edit', compact('proyek_type'));
    }

    public function update(Request $request, $id)
    {
        $proyek_owner = ProyekType::find($id);
        $update = $proyek_owner->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ]);

        if($update){
            Toastr::success('Data berhasil diubah','Berhasil!');

            return redirect()->route('proyek-type.index');
        }else{
            Toastr::error('Data gagal diubah','Gagal!');

            return redirect()->back();
        }

    }
    public function destroy($id)
    {
        $delete = ProyekType::find($id)->delete();
        if($delete){
            Toastr::success('Data berhasil dihapus','Berhasil!');
            return redirect()->route('proyek-type.index');
        }else{
            Toastr::error('Data gagal dihapus','Gagal!');
            return redirect()->back();
        }
    }
}
