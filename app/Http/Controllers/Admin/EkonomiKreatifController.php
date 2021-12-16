<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EkonomiKreatif;
use App\Models\GaleriParawisata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KategoriEkonomiKreatif;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\DestinasiWisataFotoVidioWisata;

class EkonomiKreatifController extends Controller
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
            'ekonomi_kreatif' => EkonomiKreatif::with(['kategori' => function ($kategori) {
                return $kategori->select("id", "nama_kategori_kreatif");
            }])->get()
        ];

        return view('admin.ekonomi_kreatif.index', $data);
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
            'kategori' => KategoriEkonomiKreatif::all()
        ];
        return view('admin.ekonomi_kreatif.create', $data);
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
            'kategori' => 'required|exists:kategori_ekonomi_kreatif,id',
            'ekonomi_kreatif' => 'required|string|unique:ekonomi_kreatif,nama_ekonomi_kreatif',
            'harga' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'keterangan' => 'required|string',
            'thumbnail' => 'required|image',
        ]);

        if ($validator->fails()) {
            return back()->with("error", $validator->errors()->first())->withInput();
        }

        $harga  = preg_replace("/[^0-9]/", '', explode(",", $request->harga)[0]);


        if ($request->has("thumbnail")) {
            $file_upload = $request->file("thumbnail");
            $file_name = rand(100, 333) . "-" . time() . "." . $file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/ekonomi_kreatif", $file_name);
        }

        $ekonomi_kreatif = EkonomiKreatif::create([
            'kategori_ekonomi_kreatif_id' => $request->kategori,
            'nama_ekonomi_kreatif' => $request->ekonomi_kreatif,
            'harga' => $harga,
            'lat' => $request->lat,
            'long' => $request->lng,
            'keterangan' => $request->keterangan,
            'slug_ekonomi_kreatif' => rand(10000, 99999) . '-' . Str::slug($request->ekonomi_kreatif),
            'thumbnail_ekonomi_kreatif' => storage_url(substr($file_location, 7))
        ]);

        $ins_to_galery = [];
        if ($request->hasfile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $key => $photo) {
                $name = $ekonomi_kreatif->id . "-" . $key . "-" . time() . '.' . $photo->extension();
                // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                $location = $photo->storeAs("public/foto_video_ekonomi_kreatif", $name);
                $mime = $photo->getMimeType();
                $kategori = "foto";

                if (isset($kategori)) {
                    $photos[] = [
                        'ekonomi_kreatif_id' => $ekonomi_kreatif->id,
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];

                    $ins_to_galery[] = [
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];
                }
            }
            DB::table('foto_video_ekonomi_kreatif')->insert($photos);
        }

        if ($request->filled("gallery_video")) {
            $videos = [];

            foreach ($request->gallery_video as $key => $value) {
                $videos[] = [
                    'ekonomi_kreatif_id' => $ekonomi_kreatif->id,
                    'kategori' => "video",
                    'file' => $value,
                ];
                $ins_to_galery[] = [
                    'kategori' => "video",
                    'file' => $value,
                ];
            }
            DB::table('foto_video_ekonomi_kreatif')->insert($videos);
        }
        GaleriParawisata::insert($ins_to_galery);

        return redirect()->route('admin.ekonomi-kreatif.index')->with("success", "Ekonomi Kreatif berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EkonomiKreatif  $ekonomi_kreatif
     * @return \Illuminate\Http\Response
     */
    public function show(EkonomiKreatif $ekonomi_kreatif)
    {
        //
        return $ekonomi_kreatif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EkonomiKreatif  $ekonomi_kreatif
     * @return \Illuminate\Http\Response
     */
    public function edit(EkonomiKreatif $ekonomi_kreatif)
    {
        //
        $data = [
            'kategori' =>  KategoriEkonomiKreatif::all(),
            'ekonomi_kreatif' => $ekonomi_kreatif
        ];

        return view('admin.ekonomi_kreatif.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EkonomiKreatif  $ekonomi_kreatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EkonomiKreatif $ekonomi_kreatif)
    {
        //
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|exists:kategori_ekonomi_kreatif,id',
            'ekonomi_kreatif' => 'required|string|unique:ekonomi_kreatif,nama_ekonomi_kreatif,' . $ekonomi_kreatif->id,
            'harga' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'keterangan' => 'required|string',
            'thumbnail' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return back()->with("error", $validator->errors()->first())->withInput();
        }

        $harga  = preg_replace("/[^0-9]/", '', explode(",", $request->harga)[0]);

        $update = [
            'kategori_ekonomi_kreatif_id' => $request->kategori,
            'nama_ekonomi_kreatif' => $request->ekonomi_kreatif,
            'harga' => $harga,
            'lat' => $request->lat,
            'long' => $request->lng,
            'keterangan' => $request->keterangan,
            'slug_ekonomi_kreatif' => rand(10000, 99999) . '-' . Str::slug($request->ekonomi_kreatif)
        ];

        if ($request->hasFile("thumbnail")) {
            $file_upload = $request->file("thumbnail");
            $file_name = rand(100, 333) . "-" . time() . "." . $file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/ekonomi_kreatif", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $ekonomi_kreatif->thumbnail_ekonomi_kreatif);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['thumbnail_ekonomi_kreatif'] = storage_url(substr($file_location, 7));
        }

        $ekonomi_kreatif->update($update);

        $rmv_from_galery = [];
        if ($request->filled('old')) {
            $not_inc = DB::table('foto_video_ekonomi_kreatif')->where("kategori", "foto")->where("ekonomi_kreatif_id", $ekonomi_kreatif->id)->whereNotIn("id", $request->old)->get();
            foreach ($not_inc as $key => $value) {
                list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $value->file);
                Storage::disk('public')->delete(implode('/', [$dir, $file]));
                $rmv_from_galery[] = $value->file;
            }

            DB::table('foto_video_ekonomi_kreatif')->where("ekonomi_kreatif_id", $ekonomi_kreatif->id)->whereNotIn("id", $request->old)->delete();
        }

        if ($request->hasfile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $key => $photo) {
                $name = $ekonomi_kreatif->id . "-" . $key . "-" . time() . '.' . $photo->extension();
                // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                $location = $photo->storeAs("public/foto_video_ekonomi_kreatif", $name);
                $mime = $photo->getMimeType();
                $kategori = "foto";

                if (isset($kategori)) {
                    $photos[] = [
                        'ekonomi_kreatif_id' => $ekonomi_kreatif->id,
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];

                    $ins_to_galery = [
                        'kategori' => $kategori,
                        'file' => storage_url(substr($location, 7))
                    ];
                }
            }
            DB::table('foto_video_ekonomi_kreatif')->insert($photos);
            GaleriParawisata::insert($ins_to_galery);
        }

        if ($request->filled("gallery_video")) {
            $not_inc = DB::table('foto_video_ekonomi_kreatif')->where("ekonomi_kreatif_id", $ekonomi_kreatif->id)->where('kategori', 'video')->get();
            foreach ($not_inc as $key => $value) {
                $rmv_from_galery[] = $value->file;
            }
            DB::table('foto_video_ekonomi_kreatif')->where("ekonomi_kreatif_id", $ekonomi_kreatif->id)->where('kategori', 'video')->delete();

            $videos = [];

            foreach ($request->gallery_video as $key => $value) {
                $videos[] = [
                    'ekonomi_kreatif_id' => $ekonomi_kreatif->id,
                    'kategori' => "video",
                    'file' => $value,
                ];
            }
            DB::table('foto_video_ekonomi_kreatif')->insert($videos);
        }
        GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();

        return redirect()->route('admin.ekonomi-kreatif.index')->with("success", "Ekonomi Kreatif berhasil ditambahkan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EkonomiKreatif  $ekonomi_kreatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(EkonomiKreatif $ekonomi_kreatif)
    {
        //
        list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $ekonomi_kreatif->thumbnail_ekonomi_kreatif);
        Storage::disk('public')->delete(implode('/', [$dir, $file]));

        $rmv_from_galery = [];
        foreach ($ekonomi_kreatif->fotovideo as $k => $f) {
            $rmv_from_galery[] = $f->file;
        }
        GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();

        $ekonomi_kreatif->delete();
        return ['pesan' => 'berhasil'];
    }

    public function destroy1($id)
    {
        DB::table('review_ekonomi_kreatif')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function detail($id)
    {
        $data['kategori'] = DB::table('kategori_ekonomi_kreatif')->get();
        $data['ekonomi_kreatif'] = DB::table('ekonomi_kreatif')
            ->join('kategori_ekonomi_kreatif', 'ekonomi_kreatif.kategori_ekonomi_kreatif_id', 'kategori_ekonomi_kreatif.id')
            ->select('ekonomi_kreatif.id as id_ekonomi_kreatif', 'ekonomi_kreatif.*', 'kategori_ekonomi_kreatif.*')
            ->where('ekonomi_kreatif.id', $id)
            ->orderBy("ekonomi_kreatif.nama_ekonomi_kreatif", "asc")
            ->get();

        $data['ekonomi_k'] = DB::table('review_ekonomi_kreatif')
            ->select("review_ekonomi_kreatif.*", "users.name")
            ->join('users', 'review_ekonomi_kreatif.user_id', 'users.id')
            ->where('review_ekonomi_kreatif.ekonomi_kreatif_id', $id)
            ->orderBy('review_ekonomi_kreatif.user_id', "asc")
            ->SimplePaginate(5);

        return view('admin.ekonomi_kreatif.detail', $data);
    }
}
