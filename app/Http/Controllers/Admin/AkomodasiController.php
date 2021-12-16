<?php

namespace App\Http\Controllers\Admin;
use PDF;
use App\Models\Akomodasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AkomodasiVisitor;
use App\Models\GaleriParawisata;
use App\Models\FotoVideoAkomodasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AkomodasiController extends Controller
{
    public function index()
    {
        $data['kategori'] = DB::table('kategori_akomodasi')->get();
        // $data['akomodasi'] = DB::table('akomodasi')
        //                     ->join('kategori_akomodasi','akomodasi.kategori_akomodasi_id','kategori_akomodasi.id')
        //                     ->select('akomodasi.id as id_akomodasi','akomodasi.*','kategori_akomodasi.*')
        //                     ->orderBy("akomodasi.nama_akomodasi", "asc")
        //                     ->get();
        $data['akomodasi'] = Akomodasi::orderBy("akomodasi.nama_akomodasi", "asc")->get();
        return view('admin.akomodasi.index',$data);
    }

    public function add()
    {
        $data['kategori'] = DB::table('kategori_akomodasi')->get();
        $data['fasilitas'] = DB::table('fasilitas_akomodasi')->get();
        return view("admin.akomodasi.create",$data);
    }

    public function create(Request $r)
    {
        // return $r->all();
        $validator = Validator::make($r->all(), [
            'kategori' => 'required|exists:kategori_akomodasi,id',
            'akomodasi' => 'required|string',
            'kelas' => 'nullable|string',
            'harga' => 'required|string',
            'keterangan' => 'nullable|string',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'thumbnail' => 'required_if:id,NULL|image',
            'photos.*' => 'image'
        ]);

        if($validator->fails()) {
            return response()->json(['pesan' => $validator->errors()->first()]);
        }
        list($harga) = explode(",", $r->harga);
        $harga = preg_replace("/[^0-9]/", '', $harga);

        // return $r;
        if($r->id == NULL)
        {
            if($r->has("thumbnail")) {
                $file_upload = $r->file("thumbnail");
                $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
                $file_location = $file_upload->storeAs("public/akomodasi", $file_name);
            }

            $simpan = DB::table('akomodasi')->insertGetId([
                'kategori_akomodasi_id' => $r->kategori,
                'nama_akomodasi' => $r->akomodasi,
                'kelas' => $r->kelas ?? null,
                'harga' => $harga,
                'keterangan' => $r->keterangan,
                'lat' => $r->lat,
                'long' => $r->lng,
                'slug_akomodasi' => rand(10000,99999).'-'.Str::slug($r->akomodasi),
                'thumbnail_akomodasi' => storage_url(substr($file_location, 7)),
            ]);
            $ins_to_galery = [];
            if($r->hasfile('photos')) {
                $photos= [];
                foreach ($r->file('photos') as $key => $photo) {
                    $name = $simpan."-".$key."-".time().'.'.$photo->extension();
                    // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                    $file_location = $photo->storeAs("public/foto_video_akomodasi", $name);
                    $mime = $photo->getMimeType();

                    $photos[] = [
                        'akomodasi_id' => $simpan,
                        'kategori' => "foto",
                        'file' => storage_url(substr($file_location, 7)),
                    ];

                    $ins_to_galery[] = [
                        'kategori' => "foto",
                        'file' => storage_url(substr($file_location, 7))
                    ];

                }
                DB::table('foto_video_akomodasi')->insert($photos);
            }


            if($r->filled("gallery_video")) {
                $videos = [];

                foreach ($r->gallery_video as $key => $value) {
                    $videos[] = [
                        'akomodasi_id' => $simpan,
                        'kategori' => "video",
                        'file' => $value,
                    ];
                }
                DB::table('foto_video_akomodasi')->insert($videos);
            }

            GaleriParawisata::insert($ins_to_galery);

        }else{
            $datacek = DB::table('akomodasi')->where('id', $r->id)->first();

            if($datacek != NULL) {
                if($r->has('thumbnail')) {
                    $file_upload = $r->file("thumbnail");
                    $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
                    $file_location = $file_upload->storeAs("public/thumbnail", $file_name);

                    list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $datacek->thumbnail_akomodasi);
                    Storage::disk('public')->delete(implode('/', [$dir, $file]));

                    $update = array(
                        'kategori_akomodasi_id' => $r->kategori,
                        'nama_akomodasi' => $r->akomodasi,
                        'kelas' => $r->kelas,
                        'harga' => $harga,
                        'keterangan' => $r->keterangan,
                        'lat' => $r->lat,
                        'long' => $r->lng,
                        'slug_akomodasi' => str_replace('+', '-', urlencode($r->akomodasi)),
                        'thumbnail_akomodasi' => storage_url(substr($file_location, 7)),
                    );
                }else{
                    $update = array(
                        'kategori_akomodasi_id' => $r->kategori,
                        'nama_akomodasi' => $r->akomodasi,
                        'kelas' => $r->kelas,
                        'harga' => $harga,
                        'keterangan' => $r->keterangan,
                        'lat' => $r->lat,
                        'long' => $r->lng,
                        'slug_akomodasi' => rand(10000,99999).'-'.Str::slug($r->akomodasi),
                    );
                }
                $simpan = DB::table('akomodasi')->where('id', $r->id)->update($update);

                $rmv_from_galery = [];
                if($r->filled('old')) {
                    $not_inc = DB::table('foto_video_akomodasi')->where("akomodasi_id", $r->id)->where('kategori', 'foto')->whereNotIn("id", $r->old)->get();
                    foreach ($not_inc as $key => $value) {
                        list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $value->file);
                        Storage::disk('public')->delete(implode('/', [$dir, $file]));
                        $rmv_from_galery[] = $value->file;
                    }
                    DB::table('foto_video_akomodasi')->where("akomodasi_id", $r->id)->whereNotIn("id", $r->old)->delete();

                }

                $ins_to_galery= [];
                if($r->hasfile('photos')) {
                    $photos= [];
                    foreach ($r->file('photos') as $key => $photo) {
                        $name = $simpan."-".$key."-".time().'.'.$photo->extension();
                        // $photo->move(storage_path('app/public').'/akomodasi/', $name);
                        $file_location = $photo->storeAs("public/foto_video_akomodasi", $name);
                        $mime = $photo->getMimeType();

                        $photos[] = [
                            'akomodasi_id' => $r->id,
                            'kategori' => "foto",
                            'file' => storage_url(substr($file_location, 7)),
                        ];
                        $ins_to_galery[] = [
                            'kategori' => "foto",
                            'file' => storage_url(substr($file_location, 7))
                        ];
                    }
                    DB::table('foto_video_akomodasi')->insert($photos);
                }

                if($r->filled("gallery_video")) {
                    $video_now = DB::table('foto_video_akomodasi')->where("akomodasi_id", $r->id)->where('kategori', 'video')->get();
                    foreach ($video_now as $key => $value) {
                        if(!in_array($value->file, $r->gallery_video)) {
                            $rmv_from_galery[] = $value->file;
                        }
                    }

                    DB::table('foto_video_akomodasi')->where("akomodasi_id", $r->id)->where('kategori', 'video')->delete();
                    $videos = [];

                    foreach ($r->gallery_video as $key => $value) {
                        $videos[] = [
                            'akomodasi_id' => $datacek->id,
                            'kategori' => "video",
                            'file' => $value,
                        ];
                        $ins_to_galery[] = [
                            'kategori' => "video",
                            'file' => $value,
                        ];
                    }
                    DB::table('foto_video_akomodasi')->insert($videos);
                }

                GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();

                GaleriParawisata::insert($ins_to_galery);

            }
        }


        if($r->filled("fasilitas") AND count($r->fasilitas)) {
            DB::table('akomodasi_fasilitas_akomodasi')->where('akomodasi_id', $r->id ?? $simpan)->delete();

            foreach ($r->fasilitas as $fasilitas) {
                $data_fasilitas[] = ['akomodasi_id' => $r->id ?? $simpan, 'fasilitas_akomodasi_id' => $fasilitas];
            }

            DB::table('akomodasi_fasilitas_akomodasi')->insert($data_fasilitas);
        }

        if($simpan)
        {

            if($r->ajax()) {
                return response()->json(['pesan' => 'berhasil']);
            } else {
                return redirect()->route('admin.akomodasi.home')->with("success", "berhasil");
            }
        }else{

            if($r->ajax()) {
                return response()->json(['pesan' => 'error']);
            } else {
                return redirect()->route('admin.akomodasi.home')->with("error", "error");
            }

        }
    }

    public function edit(Request $r)
    {
        $data = DB::table('akomodasi')
        ->join('kategori_akomodasi','akomodasi.kategori_akomodasi_id','kategori_akomodasi.id')
        ->select('akomodasi.id as id_akomodasi','akomodasi.*','kategori_akomodasi.*')
        ->where('akomodasi.id',$r->id)
        ->first();
        return response()->json(['data' => $data]);
    }

    public function fasilitas_select2($id)
    {
        return DB::table('akomodasi_fasilitas_akomodasi')
                                        ->select("fasilitas_akomodasi.id", "fasilitas_akomodasi.nama_fasilitas_akomodasi as text")
                                        ->join("fasilitas_akomodasi", "fasilitas_akomodasi.id", "=", "akomodasi_fasilitas_akomodasi.fasilitas_akomodasi_id")
                                        ->where('akomodasi_id', $id)->get();
    }

    public function edit_page($id)
    {
        $data['data'] = Akomodasi::find($id);

        // return $data;
        $data['kategori'] = DB::table('kategori_akomodasi')->get();
        $data['fasilitas'] = DB::table('fasilitas_akomodasi')->get();

        return view('admin.akomodasi.edit', $data);
    }

    public function delete(Request $r)
    {
        $data = Akomodasi::find($r->id);

        list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $data->thumbnail_akomodasi);
        Storage::disk('public')->delete(implode('/', [$dir, $file]));

        $rmv_from_galery = [];
        foreach($data->fotovideo as $k => $f) {
            $rmv_from_galery[] = $f->file;
        }
        GaleriParawisata::whereIn("file", $rmv_from_galery)->delete();


        $hapus = Akomodasi::findOrFail($r->id)->delete();
        if($hapus == TRUE)
        {
            return response()->json(['pesan' => "berhasil", "msg" => "kategori telah dihapus"]);
        }else{
            return response()->json(['pesan' => "error", "msg" => "kategori gagal dihapus"]);
        }
    }

    public function fasilitas(Request $r)
    {
        $data['fasilitas'] = DB::table('akomodasi_fasilitas_akomodasi')
        ->join('akomodasi','akomodasi.id','akomodasi_fasilitas_akomodasi.akomodasi_id')
        ->join('fasilitas_akomodasi','fasilitas_akomodasi.id','akomodasi_fasilitas_akomodasi.fasilitas_akomodasi_id')
        ->select('fasilitas_akomodasi.*','akomodasi_fasilitas_akomodasi.id as id_fasilitas','akomodasi.*')
        ->where('akomodasi_fasilitas_akomodasi.akomodasi_id',$r->id)
        ->get();
        return view('admin.akomodasi.fasilitas',$data);
    }

    public function media($id)
    {
        return FotoVideoAkomodasi::where('akomodasi_id', $id)->get();
    }

    public function detail($id)
    {
        $data['kategori'] = DB::table('kategori_akomodasi')->get();
        $data['akomodasi'] = DB::table('akomodasi')
                            ->join('kategori_akomodasi','akomodasi.kategori_akomodasi_id','kategori_akomodasi.id')
                            ->select('akomodasi.id as id_akomodasi','akomodasi.*','kategori_akomodasi.*')
                            ->where('akomodasi.id',$id)
                            ->orderBy("akomodasi.nama_akomodasi", "asc")
                            ->get();

        $data['review_a'] = DB::table('review_akomodasi')
                            ->select("review_akomodasi.*", "users.name")
                            ->join('users','review_akomodasi.user_id','users.id')
                            ->where('review_akomodasi.akomodasi_id',$id)
                            ->orderBy('review_akomodasi.user_id',"asc")
                            ->SimplePaginate(5);

        // return $data;

        return view('admin.akomodasi.detail',$data);


    }

    public function destroy($id)
    {
        DB::table('review_akomodasi')->where('id',$id)->delete();
                return redirect()->back();
    }

    public function report(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $visitors = AkomodasiVisitor::where('periode', 'like', $tahun.'%')->whereRaw("(SELECT COUNT(id) FROM akomodasi WHERE id=akomodasi_visitors.akomodasi_id) > 0")->orderBy('periode', 'asc')->get()->groupBy('periode');
        // return $visitors;

        view()->share('visitors', $visitors);
        $pdf_doc = PDF::loadView('admin.akomodasi.report', $visitors);

        return $pdf_doc->download('Report_Akomodasi_Th_'.$tahun.'.pdf');
        // view('admin.akomodasi.report', compact('visitors'));
    }
}
