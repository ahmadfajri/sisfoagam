<?php

namespace App\Http\Controllers\Admin\MasterData\DestinasiWisata;

use Illuminate\Http\Request;
use App\Models\FasilitasWisata;
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
        $data = [
            'fasilitas' => FasilitasWisata::all()
        ];

        // return $data;
        return view("admin.master_data.destinasi_wisata.fasilitas.index", $data);
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
        $file_location = $file_upload->storeAs("public/fasilitas_wisata", $file_name);


        FasilitasWisata::updateOrCreate(
                            ['nama_fasilitas_wisata' => $request->nama_fasilitas],
                            ['icon_fasilitas_wisata' => storage_url(substr($file_location, 7))]
                        );
        return ['status' => true, 'msg' => "Fasilitas berhasil ditambahkan"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FasilitasWisata  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function show(FasilitasWisata $fasilita)
    {
        //
        return $fasilita;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FasilitasWisata  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function edit(FasilitasWisata $fasilita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FasilitasWisata  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FasilitasWisata $fasilita)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string',
            'icon_fasilitas' => 'nullable|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $update = ['nama_fasilitas_wisata' => $request->nama_fasilitas];
        if($request->hasFile('icon_fasilitas')) {

            $file_upload = $request->file("icon_fasilitas");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/fasilitas_wisata", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $fasilita->icon_fasilitas_wisata);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['icon_fasilitas_wisata'] = storage_url(substr($file_location, 7));
        }

        $fasilita->update($update);
        return ['status' => true, 'msg' => "Fasilitas berhasil diperbaharui"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FasilitasWisata  $fasilita
     * @return \Illuminate\Http\Response
     */
    public function destroy(FasilitasWisata $fasilita)
    {
        //
        $fasilita->delete();
        return ['status' => true, 'msg' => "Fasilitas berhasil dihapus"];
    }

    public function select2(Request $request)
    {
        $q = $request->search ?? "";
        $fasilitas = FasilitasWisata::where("nama_fasilitas_wisata", "like", "%".$q."%")->limit(10)->get()->map(function($data) {
            return ['id' => $data->id, "text" => $data->nama_fasilitas_wisata];
        });
        return ['result' => $fasilitas, "pagination" => ["more" => true]];
    }
}
