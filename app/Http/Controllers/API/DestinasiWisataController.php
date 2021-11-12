<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use Illuminate\Http\Request;
use App\Models\KategoriWisata;
use App\Http\Controllers\Controller;
use App\Models\DestinasiWisata;
use App\Models\DestinasiWisataReviewWisata;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestinasiWisataController extends Controller
{
    public function getKategori()
    {
        try {
            $data = KategoriWisata::all();
            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }

    public function getBykategori($slugkategori)
    {
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

    public function getDestinasiWisata()
    {
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
    public function getDetailDestinasiWisata($slugDestinasiWisata = null)
    {
        try {
            $data = DestinasiWisata::with(["kategori", "fasilitas", "fotovideo"])->where("slug_destinasi", $slugDestinasiWisata)->first();

            if ($data->count() > 0) {
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
            ->where("slug_destinasi", $slugDestinasiWisata)->select("destinasi_wisata_review_wisata.id", "destinasi_wisata_review_wisata.destinasi_wisata_id", "destinasi_wisata_review_wisata.tingkat_kepuasan", "destinasi_wisata_review_wisata.komentar", "destinasi_wisata_review_wisata.created_at", "users.name",)->get();

            return response()->json(ApiResponse::Ok($data, 200, "Ok"));
        } catch (ModelNotFoundException $e) {
            return response()->json(ApiResponse::NotFound("Data Tidak Ditemukan"));
        }
    }
}