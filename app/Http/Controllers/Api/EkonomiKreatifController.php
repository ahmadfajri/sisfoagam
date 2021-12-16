<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use Illuminate\Http\Request;
use App\Models\EkonomiKreatif;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ReviewEkonomiKreatif;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriEkonomiKreatif;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EkonomiKreatifController extends Controller
{
    public function getKategori()
    {
        try {
            $data = KategoriEkonomiKreatif::all();
            return response()->json(ApiResponse::Ok($data, 200, "Oke"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getBykategori($slugkategoriekonomikreatif)
    {
        if(request()->has("lat") || request()->has("long")) {
            try {
                $data = EkonomiKreatif::with(["kategori", "fotovideo"])->join("kategori_ekonomi_kreatif", "kategori_ekonomi_kreatif.id", '=', "ekonomi_kreatif.kategori_ekonomi_kreatif_id")->where("slug_kategori_kreatif", $slugkategoriekonomikreatif)->select("ekonomi_kreatif.*", "kategori_ekonomi_kreatif.slug_kategori_kreatif")
                ->orderByRaw("(
                    6371 * acos (
                    cos ( radians(".request()->lat.") )
                    * cos( radians( ekonomi_kreatif.lat ) )
                    * cos( radians( ekonomi_kreatif.long ) - radians(".request()->long.") )
                    + sin ( radians(".request()->lat.") )
                    * sin( radians( ekonomi_kreatif.lat ) )
                    )
                )")
                ->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_ekonomi_kreatif_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {
                $data = EkonomiKreatif::with(["kategori", "fotovideo"])->join("kategori_ekonomi_kreatif", "kategori_ekonomi_kreatif.id", '=', "ekonomi_kreatif.kategori_ekonomi_kreatif_id")->where("slug_kategori_kreatif", $slugkategoriekonomikreatif)->select("ekonomi_kreatif.*", "kategori_ekonomi_kreatif.slug_kategori_kreatif")->paginate(8);

                if ($data->count() > 0) {
                    $data->makeHidden('kategori_ekonomi_kreatif_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }

    public function getEkonomiKreatif()
    {
        if(request()->has("lat") || request()->has("long")) {
            try {
                $data = EkonomiKreatif::with(["kategori", "fotovideo"])
                ->join("kategori_ekonomi_kreatif", "kategori_ekonomi_kreatif.id", '=', "ekonomi_kreatif.kategori_ekonomi_kreatif_id")
                ->select("ekonomi_kreatif.*",
                        "kategori_ekonomi_kreatif.slug_kategori_kreatif"
                        )->orderByRaw("(
                            6371 * acos (
                            cos ( radians(".request()->lat.") )
                            * cos( radians( ekonomi_kreatif.lat ) )
                            * cos( radians( ekonomi_kreatif.long ) - radians(".request()->long.") )
                            + sin ( radians(".request()->lat.") )
                            * sin( radians( ekonomi_kreatif.lat ) )
                            )
                        )")->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_ekonomi_kreatif_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {
                $data = EkonomiKreatif::with(["kategori", "fotovideo"])
                ->join("kategori_ekonomi_kreatif", "kategori_ekonomi_kreatif.id", '=', "ekonomi_kreatif.kategori_ekonomi_kreatif_id")
                ->select("ekonomi_kreatif.*",
                        "kategori_ekonomi_kreatif.slug_kategori_kreatif"
                        )->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('kategori_ekonomi_kreatif_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }
    public function getDetailEkonomiKreatif($slugekonomi_kreatif = null)
    {
        try {
            $data = EkonomiKreatif::with(["kategori", "fotovideo"])->where("slug_ekonomi_kreatif", $slugekonomi_kreatif)->first();

            if ($data != null) {
                $data->makeHidden('kategori_ekonomi_kreatif_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getReview($slugekonomi_kreatif = null)
    {
        try {
            $data = ReviewEkonomiKreatif::join("ekonomi_kreatif", "ekonomi_kreatif.id", "=", "review_ekonomi_kreatif.ekonomi_kreatif_id")
            ->join("users", "users.id", "=", "review_ekonomi_kreatif.user_id")
            ->where("slug_ekonomi_kreatif", $slugekonomi_kreatif)
            ->select("review_ekonomi_kreatif.*", "users.name")->get();

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getEkonomiKreatifSortByJarak(Request $request)
    {
        if(!$request->has("lat") || !$request->has("long")) {
            return response()->json(ApiResponse::NotFound("Parameter required"));
        }

        try {
            $data = EkonomiKreatif::with(["kategori", "fotovideo"])
                            ->join("kategori_ekonomi_kreatif", "kategori_ekonomi_kreatif.id", '=', "ekonomi_kreatif.kategori_ekonomi_kreatif_id")
                            ->select("ekonomi_kreatif.*",
                                    "kategori_ekonomi_kreatif.slug_kategori_kreatif"
                                    // DB::raw("IFNULL(distance, 0) as distance")
                            )
                            ->orderByRaw("(
                                6371 * acos (
                                  cos ( radians(".$request->lat.") )
                                  * cos( radians( ekonomi_kreatif.lat ) )
                                  * cos( radians( ekonomi_kreatif.long ) - radians(".$request->long.") )
                                  + sin ( radians(".$request->lat.") )
                                  * sin( radians( ekonomi_kreatif.lat ) )
                                )
                              )")
                            ->limit(5)->get();

            if ($data->count() > 0) {
                $data->makeHidden('kategori_ekonomi_kreatif_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function reviewEkonomiKreatif(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:ekonomi_kreatif,id',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string'
        ]);

        if($validator->fails()) {
            return response()->json(ApiResponse::Error(null, 200, $validator->errors()->first()));
        }

        ReviewEkonomiKreatif::updateOrCreate([
            'ekonomi_kreatif_id' => $request->id,
            'user_id' => $user->id
        ],[
            'tingkat_kepuasan' => $request->rating ?? 0,
            'komentar' => $request->comment ?? ""
        ]);

        return response()->json(ApiResponse::Ok(null, 200, "Rating telah diterapkan"));
    }
}
