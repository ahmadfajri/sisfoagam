<?php

namespace App\Http\Controllers\Admin\MasterData\Akomodasi;

use Illuminate\Http\Request;
use App\Models\FasilitasAkomodasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.master_data.akomodasi.fasilitas.index",
                    [
                        'fasilitas' => FasilitasAkomodasi::all()
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string',
            'icon_fasilitas' => 'required|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $file_upload = $request->file("icon_fasilitas");
        $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
        $file_location = $file_upload->storeAs("public/fasilitas_akomodasi", $file_name);


        FasilitasAkomodasi::updateOrCreate(
                            ['nama_fasilitas_akomodasi' => $request->nama_fasilitas],
                            ['icon_fasilitas_akomodasi' => storage_url(substr($file_location, 7))]
                        );
        return ['status' => true, 'msg' => "Fasilitas berhasil ditambahkan"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FasilitasAkomodasi  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function show(FasilitasAkomodasi $fasilita)
    {
        //
        return $fasilita;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FasilitasAkomodasi  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function edit(FasilitasAkomodasi $fasilita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FasilitasAkomodasi  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FasilitasAkomodasi $fasilita)
    {
        //
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string',
            'icon_fasilitas' => 'nullable|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $update = ['nama_fasilitas_akomodasi' => $request->nama_fasilitas];
        if($request->hasFile('icon_fasilitas')) {

            $file_upload = $request->file("icon_fasilitas");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/fasilitas_akomodasi", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $fasilita->icon_fasilitas_akomodasi);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['icon_fasilitas_akomodasi'] = storage_url(substr($file_location, 7));
        }

        $fasilita->update($update);
        return ['status' => true, 'msg' => "Fasilitas berhasil diperbaharui"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FasilitasAkomodasi  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function destroy(FasilitasAkomodasi $fasilita)
    {
        //
        $fasilita->delete();
        return ['status' => true, 'msg' => "Fasilitas berhasil dihapus"];
    }

    public function select2(Request $request)
    {
        $q = $request->search ?? "";
        $fasilitas = FasilitasAkomodasi::where("nama_fasilitas_akomodasi", "like", "%".$q."%")->limit(10)->get()->map(function($data) {
            return ['id' => $data->id, "text" => $data->nama_fasilitas_akomodasi];
        });
        return ['result' => $fasilitas, "pagination" => ["more" => true]];
    }
}
