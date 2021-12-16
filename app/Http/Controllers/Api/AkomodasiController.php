<?php

namespace App\Http\Controllers\Api;

use App\Models\Akomodasi;
use App\Helper\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ReviewAkomodasi;
use App\Models\KategoriAkomodasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AkomodasiController extends Controller
{
    public function getKategori()
    {
        try {
            $data = KategoriAkomodasi::all();
            return response()->json(ApiResponse::Ok($data, 200, "Oke"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getBykategori($slugkategori)
    {
        if(request()->has("lat") || request()->has("long")) {
            try {
                $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_akomodasi", "kategori_akomodasi.id", '=', "akomodasi.kategori_akomodasi_id")->where("slug_kategori_akomodasi", $slugkategori)->select("akomodasi.*", "kategori_akomodasi.slug_kategori_akomodasi")
                        ->orderByRaw("(
                            6371 * acos (
                            cos ( radians(".request()->lat.") )
                            * cos( radians( akomodasi.lat ) )
                            * cos( radians( akomodasi.long ) - radians(".request()->long.") )
                            + sin ( radians(".request()->lat.") )
                            * sin( radians( akomodasi.lat ) )
                            )
                        )")
                        ->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_akomodasi_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {
                $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_akomodasi", "kategori_akomodasi.id", '=', "akomodasi.kategori_akomodasi_id")->where("slug_kategori_akomodasi", $slugkategori)->select("akomodasi.*", "kategori_akomodasi.slug_kategori_akomodasi")->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_akomodasi_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }

    public function getAkomodasi()
    {

        if(request()->has("lat") || request()->has("long")) {
            try {
                $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])
                ->join("kategori_akomodasi", "kategori_akomodasi.id", '=', "akomodasi.kategori_akomodasi_id")
                ->select("akomodasi.*",
                        "kategori_akomodasi.slug_kategori_akomodasi"
                        )
                        ->orderByRaw("(
                            6371 * acos (
                              cos ( radians(".request()->lat.") )
                              * cos( radians( akomodasi.lat ) )
                              * cos( radians( akomodasi.long ) - radians(".request()->long.") )
                              + sin ( radians(".request()->lat.") )
                              * sin( radians( akomodasi.lat ) )
                            )
                          )")
                          ->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_akomodasi_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {
                $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])
                ->join("kategori_akomodasi", "kategori_akomodasi.id", '=', "akomodasi.kategori_akomodasi_id")
                ->select("akomodasi.*",
                        "kategori_akomodasi.slug_kategori_akomodasi"
                        )->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_akomodasi_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }
    public function getDetailAkomodasi($slugakomodasi = null)
    {
        try {
            $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])->where("slug_akomodasi", $slugakomodasi)->first();

            if ($data != null) {
                $data->makeHidden('kategori_akomodasi_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getReview($slugakomodasi = null)
    {
        try {
            $data = ReviewAkomodasi::join("akomodasi", "akomodasi.id", "=", "review_akomodasi.akomodasi_id")
            ->join("users", "users.id", "=", "review_akomodasi.user_id")
            ->where("slug_akomodasi", $slugakomodasi)
            ->select("review_akomodasi.*", "users.name")->get();

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getAkomodasiSortByJarak(Request $request)
    {
        if(!$request->has("lat") || !$request->has("long")) {
            return response()->json(ApiResponse::NotFound("Parameter required"));
        }

        try {
            $data = Akomodasi::with(["kategori", "fasilitas", "fotovideo"])
                            ->join("kategori_akomodasi", "kategori_akomodasi.id", '=', "akomodasi.kategori_akomodasi_id")
                            ->select("akomodasi.*",
                                    "kategori_akomodasi.slug_kategori_akomodasi"
                                    // DB::raw("IFNULL(distance, 0) as distance")
                            )
                            ->orderByRaw("(
                                6371 * acos (
                                  cos ( radians(".$request->lat.") )
                                  * cos( radians( akomodasi.lat ) )
                                  * cos( radians( akomodasi.long ) - radians(".$request->long.") )
                                  + sin ( radians(".$request->lat.") )
                                  * sin( radians( akomodasi.lat ) )
                                )
                              )")
                            ->limit(5)->get();

            if ($data->count() > 0) {
                $data->makeHidden('kategori_akomodasi_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function reviewAkomdasi(Request $request)
    {
        $user = Auth::user();
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:akomodasi,id',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string'
        ]);

        if($validator->fails()) {
            return response()->json(ApiResponse::Error(null, 200, $validator->errors()->first()));
        }

        ReviewAkomodasi::updateOrCreate([
            'akomodasi_id' => $request->id,
            'user_id' => $user->id
        ],[
            'tingkat_kepuasan' => $request->rating ?? 0,
            'komentar' => $request->comment ?? ""
        ]);

        return response()->json(ApiResponse::Ok(null, 200, "Rating telah diterapkan"));
    }

    public function getDataChart($slug, Request $request)
    {
        $objek = DB::table('akomodasi')->where('slug_akomodasi', $slug)->first();

        if($objek != null) {
            $tahun = $request->tahun ?? date("Y");
            // $visitor = DB::table('destinasi_wisata_visitors')->where('destinasi_wisata_id', $objek->id)->where('periode', 'like', $tahun."%")->get();

            // $legend = [];
            $data = [];

            for ($i=0; $i < 12; $i++) {
                $w = $i+1;
                $value = DB::table('akomodasi_visitors')->where('akomodasi_id', $objek->id)->where('periode', 'like', (($w<10)? $tahun.'-0'.$w.'-%' : $tahun.'-'.$w.'-%'))->first();

                if($value != null) {
                    $data[$i] = [
                        'legend' => $value->periode,
                        'data' => $value->visitor,
                    ];
                } else {
                    $data[$i] = [
                        'legend' => $tahun.(($w<10)? '-0'.$w.'-01' : '-'.$w.'-01'),
                        'data' => 0,
                    ];
                }
            }
            // foreach ($visitor as $key => $value) {
            //     // $legend[$key] = $value->periode;
            //     // $data[$key] = $value->visitor;
            //     $data[$key] = [
            //         'legend' => $value->periode,
            //         'data' => $value->visitor,
            //     ];
            // }

            // return ['status' => true, 'legend' => $legend, 'data' => $data];
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false, 'msg' => "Akomodasi tidak ditemukan"];
        }
    }
    /*
    public function getDataChart($slug, Request $request)
    {
        $objek = DB::table('akomodasi')->where('slug_akomodasi', $slug)->first();

        if($objek != null) {
            $tahun = $request->tahun ?? date("Y");
            $visitor = DB::table('akomodasi_visitors')->where('akomodasi_id', $objek->id)->where('periode', 'like', $tahun."%")->get();

            $legend = [];
            $data = [];
            foreach ($visitor as $key => $value) {
                $legend[$key] = $value->periode;
                $data[$key] = $value->visitor;
            }

            return ['status' => true, 'legend' => $legend, 'data' => $data];
        } else {
            return ['status' => false, 'msg' => "Akomodasi tidak ditemukan"];
        }
    }
    */
}
