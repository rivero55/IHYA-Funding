<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\proyek;
use Exception;
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
        $datas= proyek::all();
        if($datas){
            return ApiFormatter::createApi(200, 'Success' , $datas);
        }else{
            return ApiFormatter::createApi(400,'Failed');

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proyek.create');
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
        try {
            $request->validate([
                'name' => 'required',
                'type'=>'required',
                'location_code'=>'required',
                'description'=>'required',
            ]);
            $proyek=proyek::create([
                'name' => $request->name,
                'type'=>$request->type,
                'location_code'=>$request->location_code,
                'description'=>$request->description,

            ]);
            $data = proyek::where('id', '=', $proyek->id)->get();
            if($data){
                return ApiFormatter::createApi(200, 'Success' , $data);
            }else{
                return ApiFormatter::createApi(400,'Failed');
    
            }
            //code...
        } catch (Exception $error) {
            //throw $th;
            return ApiFormatter::createApi(400, 'Failed');
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
        $data = proyek::where('id', '=', $id)->get();
        if($data){
            return ApiFormatter::createApi(200, 'Success' , $data);
        }else{
            return ApiFormatter::createApi(400,'Failed');
    
        }
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
        try {
            $request->validate([
                'name' => 'required',
                'type'=>'required',
                'location_code'=>'required',
                'description'=>'required',
            ]);
            $proyek= proyek::findOrFail($id);

            $proyek->update([
                'name' => $request->name,
                'type'=>$request->type,
                'location_code'=>$request->location_code,
                'description'=>$request->description,

            ]);
            $data = proyek::where('id', '=', $proyek->id)->get();
            if($data){
                return ApiFormatter::createApi(200, 'Success Update' , $data);
            }else{
                return ApiFormatter::createApi(400,'Failed');
    
            }
            //code...
        } catch (Exception $error) {
            //throw $th;
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= proyek::findorFail($id);
        if($data){
            $data->delete();
            return ApiFormatter::createApi(200, 'Success Delete' , $data);
                
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}
