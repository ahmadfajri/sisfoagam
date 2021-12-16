<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BeritaParawisata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaParawisataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $berita = BeritaParawisata::orderBy('created_at', 'desc')->limit(50)->get();
        return view('admin.berita_parawisata.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.berita_parawisata.create');
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
            'judul' => "required|string",
            "narasi" => "required|string",
            "posting_by" => 'required|string',
            'thumbnail' => 'required|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, "msg" => $validator->errors()->first()];
        }

        $file_upload = $request->file("thumbnail");
        $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
        $file_location = $file_upload->storeAs("public/berita_parawisata", $file_name);

        BeritaParawisata::create([
            'judul' => $request->judul,
            'narasi' => $request->narasi,
            'posting_by' => $request->posting_by,
            'foto' => storage_url(substr($file_location, 7)),
            'slug_berita_parawisata' => rand(10000,99999).'-'.Str::slug($request->judul),
        ]);


        return redirect()->route('admin.berita-parawisata.index')->with("success", "Berita Parawisata berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BeritaParawisata  $berita_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function show(BeritaParawisata $berita_parawisatum)
    {
        //
        return $berita_parawisatum;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BeritaParawisata  $berita_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function edit(BeritaParawisata $berita_parawisatum)
    {
        //
        return view('admin.berita_parawisata.edit', compact("berita_parawisatum"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BeritaParawisata  $berita_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BeritaParawisata $berita_parawisatum)
    {
        //
        $validator = Validator::make($request->all(), [
            'judul' => "required|string",
            "narasi" => "required|string",
            "posting_by" => 'required|string',
            'thumbnail' => 'nullable|image'
        ]);

        if($validator->fails()) {
            return ['status' => false, "msg" => $validator->errors()->first()];
        }

        $update = [
            'judul' => $request->judul,
            'narasi' => $request->narasi,
            'posting_by' => $request->posting_by,
            'slug_berita_parawisata' => rand(10000,99999).'-'.Str::slug($request->judul),
        ];

        if($request->has('thumbnail')) {
            $file_upload = $request->file("thumbnail");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/berita_parawisata", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $berita_parawisatum->foto);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['foto'] = storage_url(substr($file_location, 7));
        }

        $berita_parawisatum->update($update);


        return redirect()->route('admin.berita-parawisata.index')->with("success", "Berita Parawisata berhasil ditambahkan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BeritaParawisata  $berita_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function destroy(BeritaParawisata $berita_parawisatum)
    {
        //
        $berita_parawisatum->delete();
        return ['pesan' => 'berhasil'];
    }

    public function detail($id)
    {

        $data['berita_parawisata'] = DB::table('berita_parawisata')->where('id', $id)->first();

        return view('admin.berita_parawisata.detail',$data);

    }
}
