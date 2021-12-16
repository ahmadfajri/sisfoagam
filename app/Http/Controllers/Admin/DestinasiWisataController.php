<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Akomodasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DestinasiWisata;
use App\Models\GaleriParawisata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\DestinasiWisataFotoVidioWisata;
use App\Models\DestinasiWisataJumlahKunjungan;
use App\Models\DestinasiWisataVisitor;

class DestinasiWisataController extends Controller
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
            'destinasi_wisata' => DestinasiWisata::with(['kategori' => function ($kategori) {
                return $kategori->select("id", "nama_kategori_wisata");
            }])->get()
        ];

        return view('admin.destinasi_wisata.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'kategori' => DB::table('kategori_wisata')->get()
        ];

        return view('admin.destinasi_wisata.create', $data);
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
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'kategori' => 'required|exists:kategori_wisata,id',
            'destinasi_wisata' => 'required|string|unique:destinasi_wisata,nama_wisata',
            'harga_tiket_dewasa' => 'required|string',
            'harga_tiket_anak' => 'required|string',
            'biaya_parkir_r6' => 'required|string',
            'biaya_parkir_r4' => 'required|string',
            'biaya_parkir_r2' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'thumbnail' => 'required|image',
        ]);

        if ($validator->fails()) {
            return back()->with("error", $validator->errors()->first())->withInput();
        }

        $harga_tiket_dewasa  = preg_replace("/[^0-9]/", '', explode(",", $request->harga_tiket_dewasa)[0]);
        $harga_tiket_anak  = preg_replace("/[^0-9]/", '', explode(",", $request->harga_tiket_anak)[0]);
        $biaya_parkir_r2  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r2)[0]);
        $biaya_parkir_r4  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r4)[0]);
        $biaya_parkir_r6  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r6)[0]);


        if ($request->has("thumbnail")) {
            $file_upload = $request->file("thumbnail");
            $file_name = rand(100, 333) . "-" . time() . "." . $file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/destinasi_wisata", $file_name);
        }

        $destinasi_wisata = DestinasiWisata::create([
            'kategori_wisata_id' => $request->kategori,
            'nama_wisata' => $request->destinasi_wisata,
            'harga_tiket_dewasa' => $harga_tiket_dewasa,
            'harga_tiket_anak' => $harga_tiket_anak,
            'biaya_parkir_roda_2' => $biaya_parkir_r2,
            'biaya_parkir_roda_4' => $biaya_parkir_r4,
            'biaya_parkir_roda_6' => $biaya_parkir_r6,
            'lat' => $request->lat,
            'long' => $request->lng,
            'slug_destinasi' => rand(10000, 99999) . '-' . Str::slug($request->destinasi_wisata),
            'keterangan' => $request->keterangan ?? "",
            'thumbnail_destinasi_wisata' => storage_url(substr($file_location, 7))
        ]);

        if (count($request->fasilitas)) {
            DB::table('destinasi_wisata_fasilitas_wisata')->where('destinasi_wisata_id', $destinasi_wisata->id)->delete();

            foreach ($request->fasilitas as $fasilitas) {
                $data_fasilitas[] = ['destinasi_wisata_id' => $request->id ?? $destinasi_wisata->id, 'fasilitas_wisata_id' => $fasilitas];
            }

            DB::table('destinasi_wisata_fasilitas_wisata')->insert($data_fasilitas);
        }

        if ($request->hasfile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $key => $photo) {
                $name = $destinasi_wisata->id . "-" . $key . "-" . time() . '.' . $photo->extension();
                // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                $location = $photo->storeAs("public/destinasi_wisata_foto_vidio_wisata", $name);
                $mime = $photo->getMimeType();
                $kategori = "foto";

                if (isset($kategori)) {
                    $photos[] = [
                        'destinasi_wisata_id' => $destinasi_wisata->id,
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];
                    $ins_to_galery = [
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];
                }
            }
            DB::table('destinasi_wisata_foto_vidio_wisata')->insert($photos);
            GaleriParawisata::insert($ins_to_galery);
        }

        if ($request->filled("gallery_video")) {
            $videos = [];

            foreach ($request->gallery_video as $key => $value) {
                $videos[] = [
                    'destinasi_wisata_id' => $destinasi_wisata->id,
                    'kategori' => "video",
                    'file' => $value,
                ];
            }
            DB::table('destinasi_wisata_foto_vidio_wisata')->insert($videos);
        }

        return redirect()->route('admin.destinasi-wisata.index')->with("success", "Destinasi berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DestinasiWisata  $destinasi_wisatum
     * @return \Illuminate\Http\Response
     */
    public function show(DestinasiWisata $destinasi_wisatum)
    {
        //
        return $destinasi_wisatum;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DestinasiWisata  $destinasi_wisatum
     * @return \Illuminate\Http\Response
     */
    public function edit(DestinasiWisata $destinasi_wisatum)
    {
        //
        $data = [
            'kategori' => DB::table('kategori_wisata')->get(),
            'destinasi_wisata' => $destinasi_wisatum
        ];

        return view('admin.destinasi_wisata.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DestinasiWisata  $destinasi_wisatum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DestinasiWisata $destinasi_wisatum)
    {
        //
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|exists:kategori_wisata,id',
            'destinasi_wisata' => 'required|string|unique:destinasi_wisata,nama_wisata,' . $destinasi_wisatum->id,
            'harga_tiket_dewasa' => 'required|string',
            'harga_tiket_anak' => 'required|string',
            'biaya_parkir_r6' => 'required|string',
            'biaya_parkir_r4' => 'required|string',
            'biaya_parkir_r2' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'thumbnail' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return back()->with("error", $validator->errors()->first())->withInput();
        }

        $harga_tiket_dewasa  = preg_replace("/[^0-9]/", '', explode(",", $request->harga_tiket_dewasa)[0]);
        $harga_tiket_anak  = preg_replace("/[^0-9]/", '', explode(",", $request->harga_tiket_anak)[0]);
        $biaya_parkir_r2  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r2)[0]);
        $biaya_parkir_r4  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r4)[0]);
        $biaya_parkir_r6  = preg_replace("/[^0-9]/", '', explode(",", $request->biaya_parkir_r6)[0]);

        $update = [
            'kategori_wisata_id' => $request->kategori,
            'nama_wisata' => $request->destinasi_wisata,
            'harga_tiket_dewasa' => $harga_tiket_dewasa,
            'harga_tiket_anak' => $harga_tiket_anak,
            'biaya_parkir_roda_2' => $biaya_parkir_r2,
            'biaya_parkir_roda_4' => $biaya_parkir_r4,
            'biaya_parkir_roda_6' => $biaya_parkir_r6,
            'lat' => $request->lat,
            'long' => $request->lng,
            'slug_destinasi' => rand(10000, 99999) . '-' . Str::slug($request->destinasi_wisata),
            'keterangan' => $request->keterangan ?? "",
        ];

        if ($request->has("thumbnail")) {
            $file_upload = $request->file("thumbnail");
            $file_name = rand(100, 333) . "-" . time() . "." . $file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/destinasi_wisata", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $destinasi_wisatum->thumbnail_destinasi_wisata);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['thumbnail_destinasi_wisata'] =  storage_url(substr($file_location, 7));
        }

        $destinasi_wisatum->update($update);

        if (count($request->fasilitas)) {
            DB::table('destinasi_wisata_fasilitas_wisata')->where('destinasi_wisata_id', $destinasi_wisatum->id)->delete();

            foreach ($request->fasilitas as $fasilitas) {
                $data_fasilitas[] = ['destinasi_wisata_id' => $request->id ?? $destinasi_wisatum->id, 'fasilitas_wisata_id' => $fasilitas];
            }

            DB::table('destinasi_wisata_fasilitas_wisata')->insert($data_fasilitas);
        }

        $rmv_from_galery = [];
        if ($request->filled('old')) {
            $not_inc = DB::table('destinasi_wisata_foto_vidio_wisata')->where('kategori', 'foto')->where("destinasi_wisata_id", $destinasi_wisatum->id)->whereNotIn("id", $request->old)->get();
            foreach ($not_inc as $key => $value) {
                list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $value->file);
                Storage::disk('public')->delete(implode('/', [$dir, $file]));
                $rmv_from_galery[] = $value->file;
            }
            DB::table('destinasi_wisata_foto_vidio_wisata')->where("destinasi_wisata_id", $destinasi_wisatum->id)->whereNotIn("id", $request->old)->delete();
        }

        $ins_to_galery = [];

        if ($request->hasfile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $key => $photo) {
                $name = $destinasi_wisatum->id . "-" . $key . "-" . time() . '.' . $photo->extension();
                // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                $file_location = $photo->storeAs("public/destinasi_wisata_foto_vidio_wisata", $name);
                $mime = $photo->getMimeType();
                $kategori = "foto";

                if (isset($kategori)) {
                    $photos[] = [
                        'destinasi_wisata_id' => $destinasi_wisatum->id,
                        'kategori' => $kategori,
                        'file' => storage_url(substr($file_location, 7)),
                    ];
                    $ins_to_galery[] = [
                        'kategori' => $kategori,
                        'file' => storage_url(substr($file_location, 7))
                    ];
                }
            }
            DB::table('destinasi_wisata_foto_vidio_wisata')->insert($photos);
        }

        if ($request->filled("gallery_video")) {
            // $not_inc = DB::table('destinasi_wisata_foto_vidio_wisata')->where("destinasi_wisata_id", $destinasi_wisatum->id)->where('kategori', 'video')->get();

            // foreach ($not_inc as $key => $value) {
            //     $rmv_from_galery[] = $value->file;
            // }

            $video_now = DB::table('destinasi_wisata_foto_vidio_wisata')->where("destinasi_wisata_id", $destinasi_wisatum->id)->where('kategori', 'video')->get();
            foreach ($video_now as $key => $value) {
                if(!in_array($value->file, $request->gallery_video)) {
                    $rmv_from_galery[] = $value->file;
                }
            }

            DB::table('destinasi_wisata_foto_vidio_wisata')->where("destinasi_wisata_id", $destinasi_wisatum->id)->where('kategori', 'video')->delete();
            $videos = [];

            foreach ($request->gallery_video as $key => $value) {
                $videos[] = [
                    'destinasi_wisata_id' => $destinasi_wisatum->id,
                    'kategori' => "video",
                    'file' => $value,
                ];
                $ins_to_galery[] = [
                    'kategori' => "video",
                    'file' => $value,
                ];
            }
            DB::table('destinasi_wisata_foto_vidio_wisata')->insert($videos);
        }

        // return $rmv_from_galery;

        GaleriParawisata::insert($ins_to_galery);

        GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();

        return redirect()->route('admin.destinasi-wisata.index')->with("success", "Destinasi berhasil ditambahkan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DestinasiWisata  $destinasi_wisatum
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestinasiWisata $destinasi_wisatum)
    {
        //

        list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $destinasi_wisatum->thumbnail_destinasi_wisata);
        Storage::disk('public')->delete(implode('/', [$dir, $file]));

        $rmv_from_galery = [];
        foreach ($destinasi_wisatum->fotovideo as $k => $f) {
            $rmv_from_galery[] = $f->file;
        }
        GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();

        $destinasi_wisatum->delete();
        return ['pesan' => 'berhasil'];
    }

    public function fasilitas_select2($id)
    {
        return DB::table('destinasi_wisata_fasilitas_wisata')
            ->select("fasilitas_wisata.id", "fasilitas_wisata.nama_fasilitas_wisata as text")
            ->join("fasilitas_wisata", "fasilitas_wisata.id", "=", "destinasi_wisata_fasilitas_wisata.fasilitas_wisata_id")
            ->where('destinasi_wisata_fasilitas_wisata.destinasi_wisata_id', $id)->get();
    }

    public function media($id)
    {
        return DestinasiWisataFotoVidioWisata::where('destinasi_wisata_id', $id)->get();
    }


    public function detail($id)
    {

        $data['kategori'] = DB::table('kategori_wisata')->get();
        $data['destinasi_wisata'] = DB::table('destinasi_wisata')
            ->join('kategori_wisata', 'destinasi_wisata.kategori_wisata_id', 'kategori_wisata.id')
            ->select('destinasi_wisata.id as id_destinasi_wisata', 'destinasi_wisata.*', 'kategori_wisata.*')
            ->where('destinasi_wisata.id', $id)
            ->orderBy("destinasi_wisata.nama_wisata", "asc")
            ->get();

        $data['destinasi_w'] = DB::table('destinasi_wisata_review_wisata')
            ->select("destinasi_wisata_review_wisata.*", "users.name")
            ->join('users', 'destinasi_wisata_review_wisata.user_id', 'users.id')
            ->where('destinasi_wisata_review_wisata.destinasi_wisata_id', $id)
            ->orderBy('destinasi_wisata_review_wisata.user_id', "asc")
            ->SimplePaginate(5);

        return view('admin.destinasi_wisata.detail', $data);
    }

    public function destroy1($id)
    {
        DB::table('destinasi_wisata_review_wisata')->where('id', $id)->delete();
        return Redirect()->back();
    }


    public function hapus_detail($id_rev)
    {
        DB::table('review_akomodasi')->where('id', $id_rev)->delete();
        // Alert::success('Congrats', 'Data Berhasil Dihapus');

        $data['kategori'] = DB::table('kategori_akomodasi')->get();
        // $data['akomodasi'] = DB::table('akomodasi')
        //                     ->join('kategori_akomodasi','akomodasi.kategori_akomodasi_id','kategori_akomodasi.id')
        //                     ->select('akomodasi.id as id_akomodasi','akomodasi.*','kategori_akomodasi.*')
        //                     ->orderBy("akomodasi.nama_akomodasi", "asc")
        //                     ->get();
        $data['akomodasi'] = Akomodasi::orderBy("akomodasi.nama_akomodasi", "asc")->get();
        return back()->with("success", "Data Berhasil dihapus");
    }

    public function ubahJumlahKunjungan(Request $request, DestinasiWisata $destinasi_wisatum)
    {
        DestinasiWisataJumlahKunjungan::updateOrCreate([
            'destinasi_wisata_id' => $destinasi_wisatum->id
        ], [
            'jumlah_kunjungan' => $request->jumlah
        ]);

        return ['pesan' => 'berhasil'];
    }
    public function report(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $visitors = DestinasiWisataVisitor::where('periode', 'like', $tahun.'%')->whereRaw("(SELECT COUNT(id) FROM destinasi_wisata WHERE id=destinasi_wisata_visitors.destinasi_wisata_id) > 0")->orderBy('periode', 'asc')->get()->groupBy('periode');
        // return $visitors;

        view()->share('visitors', $visitors);
        $pdf_doc = PDF::loadView('admin.destinasi_wisata.report', $visitors);

        return $pdf_doc->download('Report_Destinasi_Wisata_Th_'.$tahun.'.pdf');
        // view('admin.destinasi_wisata.report', compact('visitors'));
    }
}
