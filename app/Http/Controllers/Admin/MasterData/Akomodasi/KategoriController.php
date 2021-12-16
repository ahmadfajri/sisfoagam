<?php

namespace App\Http\Controllers\Admin\MasterData\Akomodasi;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriAkomodasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.master_data.akomodasi.kategori.index",
        [
            'kategori' => KategoriAkomodasi::all()
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
            'nama_kategori' => 'required|string',
            'icon_kategori' => 'nullable|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $file_upload = $request->file("icon_kategori");
        $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
        $file_location = $file_upload->storeAs("public/kategori_akomodasi", $file_name);

        $slug = Str::slug($request->nama_kategori);
        KategoriAkomodasi::updateOrCreate(
                            ['nama_kategori_akomodasi' => $request->nama_kategori],
                            [
                                'icon_kategori_akomodasi' => storage_url(substr($file_location, 7)),
                                'slug_kategori_akomodasi' => $slug,
                            ]
                        );
        return ['status' => true, 'msg' => "kategori berhasil ditambahkan"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriAkomodasi  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriAkomodasi $kategori)
    {
        //
        return $kategori;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriAkomodasi  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriAkomodasi $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriAkomodasi  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KategoriAkomodasi $kategori)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string',
            'icon_kategori' => 'nullable|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $slug = Str::slug($request->nama_kategori);
        $update =   [
                        'nama_kategori_akomodasi' => $request->nama_kategori,
                        'slug_kategori_akomodasi' => $slug
                    ];
        if($request->hasFile('icon_kategori')) {

            $file_upload = $request->file("icon_kategori");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/kategori_akomodasi", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $kategori->icon_kategori_akomodasi);
             Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['icon_kategori_akomodasi'] = storage_url(substr($file_location, 7));
        }

        $kategori->update($update);

        return ['status' => true, 'msg' => "kategori berhasil diperbaharui"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriAkomodasi  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriAkomodasi $kategori)
    {
        //
        $kategori->delete();
        return ['status' => true, 'msg' => "Kategori berhasil dihapus"];
    }

    public function select2(Request $request)
    {
        $q = $request->search ?? "";
        $kategori = KategoriAkomodasi::where("nama_kategori_akomodasi", "like", "%".$q."%")->limit(10)->get()->map(function($data) {
            return ['id' => $data->id, "text" => $data->nama_kategori_akomodasi];
        });
        return ['result' => $kategori, "pagination" => ["more" => true]];
    }
}
