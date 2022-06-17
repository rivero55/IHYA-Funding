<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\proyek;
use App\Models\ProyekOwner;
use App\Models\ProyekType;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek= Proyek::all();
        return view('admin.proyek.index', compact('proyek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyek_owners = ProyekOwner::all();
        $proyek_types= ProyekType::all();
        return view('admin.proyek.create',compact('proyek_owners','proyek_types'));
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
            $request->validate([
                'proyek_name' => 'required',
                'proyek_owner' => 'required',
                'type'=>'required',
                'location_code'=>'required',
                'image' => 'required|file',
                'description'=>'required|string',
            ]);
            #rename file image to new name 
            $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            #add to storage
            $image = $request->file('image')
                ->storeAs('public/images/proyek/', $fileNameImage);
            $store = Proyek::insert([
                'owner_id' => $request->proyek_owner,
                'name' => $request->proyek_name,
                'type' => $request->type,
                'location_code' => $request->location_code,
                'image'=> $fileNameImage,
                'description' => $request->description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            if($store){
            // $log = [
            //     'user_id' => Auth::user()->id,
            //     'workflow_type' => 'project',
            //     'activity' => 'add',
            //     'description' => 'Add Project '.$request->project_name,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $document = Log::create($log);
            // Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('proyek.index');
            }else{
                // Toastr::error('Data gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back()->withInput();
            dd($store);
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
        $proyek = Proyek::find($id);
        return view('admin.proyek.show', compact('proyek'));
        
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
        $proyek = Proyek::find($id);
        $proyek_owners = ProyekOwner::all();
        $proyek_types = ProyekType::orderBy('name')->get();
        return view('admin.proyek.edit', compact('proyek','proyek_owners', 'proyek_types'));
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
        
            $request->validate([
                'proyek_name' => 'required',
                'proyek_owner' => 'required',
                'type'=>'required',
                'location_code'=>'required',
                'image' => 'nullable|file',
                'description'=>'nullable|string',
            ]);
            $update= proyek::find($id);
            // Overwrite image
        if ($request->hasFile('image')) {
            $existingImage = proyek::find($id)->image;
            Storage::disk('public')->delete('images/proyek/' . $existingImage);


            $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            $image = $request->file('image')
            ->storeAs('public/images/proyek/', $fileNameImage);


            $image = Proyek::find($id)->update([
                'image' => $fileNameImage,
            ]);
        }
            $update->update([
                'owner_id' => $request->proyek_owner,
                'name' => $request->proyek_name,
                'type' => $request->type,
                'location_code' => $request->location_code,
                'description' => $request->description,
                'updated_at' => Carbon::now(),
            ]);
            if($update){
                // Toastr::success('Data berhasil diubah','Berhasil!');
                return redirect()->route('proyek.index');
            }else{
                // Toastr::error('Data gagal diubah, coba lagi','Gagal!');
                return redirect()->back();
            }
    
      
            
            //code...
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyek= proyek::findorFail($id);
        $delete= $proyek->delete();
        if($delete){
            return redirect()->route('proyek.index');
        }else{
            return redirect()->back();

        }
    }
}