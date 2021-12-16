<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use Illuminate\Http\Request;
use App\Models\FasilitasUmum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FasilitasUmumController extends Controller
{
    //
    public function getFasilitasUmum()
    {
        if(request()->has("lat") || request()->has("long")) {
            try {
                $data = FasilitasUmum::with(["fotovideo"])->select("fasilitas_umum.*")
                ->orderByRaw("(
                    6371 * acos (
                    cos ( radians(".request()->lat.") )
                    * cos( radians( fasilitas_umum.lat ) )
                    * cos( radians( fasilitas_umum.long ) - radians(".request()->long.") )
                    + sin ( radians(".request()->lat.") )
                    * sin( radians( fasilitas_umum.lat ) )
                    )
                )")->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('fasilitas_umum_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } else {
            try {
                $data = FasilitasUmum::with(["fotovideo"])
                ->select("fasilitas_umum.*")->paginate(8);
                if ($data->count() > 0) {
                    $data->makeHidden('fasilitas_umum_id');
                    return response()->json(ApiResponse::Ok($data, 200, "Ok"));
                } else {
                    return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        }
    }

    public function getFasilitasUmumSortByJarak(Request $request)
    {
        if(!$request->has("lat") || !$request->has("long")) {
            return response()->json(ApiResponse::NotFound("Parameter required"));
        }

        try {
            $data = FasilitasUmum::with(["fotovideo"])->select("fasilitas_umum.*")
            ->orderByRaw("(
                6371 * acos (
                  cos ( radians(".$request->lat.") )
                  * cos( radians( fasilitas_umum.lat ) )
                  * cos( radians( fasilitas_umum.long ) - radians(".$request->long.") )
                  + sin ( radians(".$request->lat.") )
                  * sin( radians( fasilitas_umum.lat ) )
                )
              )")->limit(5)->get();

            if ($data->count() > 0) {
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getDetailFasilitasUmum($slugfasilitas_umum = null)
    {
        try {
            $data = FasilitasUmum::with(["fotovideo"])->where("slug_fasilitas_umum", $slugfasilitas_umum)->first();

            if ($data != null) {
                $data->makeHidden('fasilitas_umum_id');
                return response()->json(ApiResponse::Ok($data, 200, "Ok"));
            } else {
                return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
            }

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }
}
