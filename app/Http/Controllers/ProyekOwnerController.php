<?php

namespace App\Http\Controllers;

use App\Models\ProyekOwner;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
class ProyekOwnerController extends Controller
{
    public function index(){
        $proyek_owners= ProyekOwner::all();
        return view('admin.proyek_owner.index',compact('proyek_owners'));
    }

    public function create()
    {
        return view('admin.proyek_owner.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $store = ProyekOwner::insert([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if($store){
            ApiFormatter::createApi(200, 'Success' , $store);
            return redirect()->route('proyek-owner.index');
        }else{
            ApiFormatter::createApi(400,'Failed');
            return redirect()->back();

        }
    }

    public function edit($id)
    {
        $project_owner = ProyekOwner::find($id);
        return view('admin.proyek_owner.edit', compact('project_owner'));
    }

    public function update(Request $request, $id)
    {
        $project_owner = ProyekOwner::find($id);
        $update = $project_owner->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);

        if($update){
            ApiFormatter::createApi(200, 'Success' , $update);
            return redirect()->route('proyek-owner.index');
        }else{
            ApiFormatter::createApi(400,'Failed');
            return redirect()->back();
        }

    }
    public function destroy($id)
    {
        $delete = ProyekOwner::find($id)->delete();
        if($delete){
            ApiFormatter::createApi(200, 'Success' , $delete);
            return redirect()->route('proyek-owner.index');
        }else{
            ApiFormatter::createApi(400,'Failed');
            return redirect()->back();
        }
    }

}
