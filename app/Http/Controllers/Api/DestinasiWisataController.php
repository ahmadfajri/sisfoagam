<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use Illuminate\Http\Request;
use App\Models\KategoriWisata;
use App\Models\DestinasiWisata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\DestinasiWisataReviewWisata;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestinasiWisataController extends Controller
{
    public function getKategori()
    {
        try {
            $data = KategoriWisata::all();
            return response()->json(ApiResponse::Ok($data, 200, "Oke"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getBykategori($slugkategori)
    {
        if(request()->has("lat") || request()->has("long")) {
            try {

                $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")->where("slug_kategori_wisata", $slugkategori)->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")
                        ->orderByRaw("(
                            6371 * acos (
                            cos ( radians(".request()->lat.") )
                            * cos( radians( destinasi_wisata.lat ) )
                            * cos( radians( destinasi_wisata.long ) - radians(".request()->long.") )
                            + sin ( radians(".request()->lat.") )
                            * sin( radians( destinasi_wisata.lat ) )
                            )
                        )")
                        ->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_wisata_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {

                $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")->where("slug_kategori_wisata", $slugkategori)->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_wisata_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }

    public function getDestinasiWisata()
    {
        if(request()->has("lat") || request()->has("long")) {
            try {

                $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")
                        ->orderByRaw("(
                            6371 * acos (
                            cos ( radians(".request()->lat.") )
                            * cos( radians( destinasi_wisata.lat ) )
                            * cos( radians( destinasi_wisata.long ) - radians(".request()->long.") )
                            + sin ( radians(".request()->lat.") )
                            * sin( radians( destinasi_wisata.lat ) )
                            )
                        )")->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_wisata_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {

                $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_wisata_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }
    public function getDetailDestinasiWisata($slugDestinasiWisata = null)
    {
        try {
            $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->where("slug_destinasi", $slugDestinasiWisata)->first();

            if ($data != null) {
                $data->makeHidden('kategori_wisata_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getReview($slugDestinasiWisata = null)
    {
        try {
            $data = DestinasiWisataReviewWisata::join("destinasi_wisata", "destinasi_wisata.id", "=", "destinasi_wisata_review_wisata.destinasi_wisata_id")
            ->join("users", "users.id", "=", "destinasi_wisata_review_wisata.user_id")
            ->where("slug_destinasi", $slugDestinasiWisata)
            ->select("destinasi_wisata_review_wisata.*", "users.name")->get();

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getDestinasiWisataSortByJarak(Request $request)
    {
        if(!$request->has("lat") || !$request->has("long")) {
            return response()->json(ApiResponse::NotFound("Parameter required"));
        }

        try {
            $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")
            ->orderByRaw("(
                6371 * acos (
                  cos ( radians(".$request->lat.") )
                  * cos( radians( destinasi_wisata.lat ) )
                  * cos( radians( destinasi_wisata.long ) - radians(".$request->long.") )
                  + sin ( radians(".$request->lat.") )
                  * sin( radians( destinasi_wisata.lat ) )
                )
              )")->limit(5)->get();

            if ($data->count() > 0) {
                $data->makeHidden('kategori_wisata_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function searchDestinasiWisata(Request $request)
    {
        $q = $request->q ?? '';
        $limit = (int) ($request->limit ?? 5);

        try {

            $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])
                                    ->join("kategori_wisata", "kategori_wisata.id", '=', "destinasi_wisata.kategori_wisata_id")
                                    ->select("destinasi_wisata.*", "kategori_wisata.slug_kategori_wisata")
                                    ->where("destinasi_wisata.nama_wisata", "like", "%".$q."%")
                                    ->limit($limit)
                                    ->get();

            if ($data->count() > 0) {
                $data->makeHidden('kategori_wisata_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }

    }

    public function reviewDestinasiWisata(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:destinasi_wisata,id',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string'
        ]);

        if($validator->fails()) {
            return response()->json(ApiResponse::Error(null, 200, $validator->errors()->first()));
        }

        DestinasiWisataReviewWisata::updateOrCreate([
            'destinasi_wisata_id' => $request->id,
            'user_id' => $user->id
        ],[
            'tingkat_kepuasan' => $request->rating ?? 0,
            'komentar' => $request->comment ?? ""
        ]);

        return response()->json(ApiResponse::Ok(null, 200, "Rating telah diterapkan"));
    }

    public function getDataChart($slug, Request $request)
    {
        $objek = DB::table('destinasi_wisata')->where('slug_destinasi', $slug)->first();

        if($objek != null) {
            $tahun = $request->tahun ?? date("Y");
            // $visitor = DB::table('destinasi_wisata_visitors')->where('destinasi_wisata_id', $objek->id)->where('periode', 'like', $tahun."%")->get();

            // $legend = [];
            $data = [];

            for ($i=0; $i < 12; $i++) {
                $w = $i+1;
                $value = DB::table('destinasi_wisata_visitors')->where('destinasi_wisata_id', $objek->id)->where('periode', 'like', (($w<10)? $tahun.'-0'.$w.'-%' : $tahun.'-'.$w.'-%'))->first();

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
}
