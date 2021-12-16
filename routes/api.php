<?php

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GaleryController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\AkomodasiController;
use App\Http\Controllers\Api\VidioHomeController;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Http\Controllers\Api\FasilitasUmumController;
use App\Http\Controllers\Api\EkonomiKreatifController;
use App\Http\Controllers\Api\DestinasiWisataController;
use App\Http\Controllers\Api\EventParawisataController;
use App\Http\Controllers\Api\BeritaParawisataController;
use App\Http\Controllers\Admin\MasterData\BannerController;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS, HEAD, PATCH');
// header('Access-Control-Allow-Headers: Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Set-Cookie');
// header('Access-Control-Allow-Credentials: true');
Route::middleware(['cors'])->group(function () {
    // AKOMODASI
    Route::get('/akomodasi', [AkomodasiController::class, 'getAkomodasi']);
    Route::get('/akomodasi/jarak', [AkomodasiController::class, 'getAkomodasiSortByJarak']);
    Route::get('/akomodasi/kategori', [AkomodasiController::class, 'getKategori']);
    Route::get('/akomodasi/kategori/{slugkategoriakomodasi}', [AkomodasiController::class, 'getByKategori']);

    Route::post("/akomodasi/rating", [AkomodasiController::class, 'reviewAkomdasi'])->middleware('verify.api');

    Route::get('/akomodasi/{slugakomodasi}', [AkomodasiController::class, 'getDetailAkomodasi']);
    Route::get('/akomodasi/{slugakomodasi}/review', [AkomodasiController::class, 'getReview']);

    Route::get('/akomodasi/{slugakomodasi}/galery', [AkomodasiController::class, 'galeriAkomodasi']);
    Route::any('/akomodasi/{slugakomodasi}/chart', [AkomodasiController::class, 'getDataChart']);

    // DESTINASI
    Route::get('/destinasi', [DestinasiWisataController::class, 'getDestinasiWisata']);
    Route::get('/destinasi/search', [DestinasiWisataController::class, 'searchDestinasiWisata']);
    Route::get('/destinasi/jarak', [DestinasiWisataController::class, 'getDestinasiWisataSortByJarak']);
    Route::get('/destinasi/kategori', [DestinasiWisataController::class, 'getKategori']);
    Route::get('/destinasi/kategori/{slugkategori}', [DestinasiWisataController::class, 'getByKategori']);

    Route::post("/destinasi/rating", [DestinasiWisataController::class, 'reviewDestinasiWisata'])->middleware('verify.api');

    Route::get('/destinasi/{slugkategori}', [DestinasiWisataController::class, 'getDetailDestinasiWisata']);
    Route::get('/destinasi/{slugDestinasiWisata}/review', [DestinasiWisataController::class, 'getReview']);
    Route::any('/destinasi/{slugDestinasiWisata}/chart', [DestinasiWisataController::class, 'getDataChart']);

    // EVENT PARAWISATA
    Route::get('/event-parawisata', [EventParawisataController::class, 'eventAllParawisata']);
    Route::get('/event-parawisata/coming', [EventParawisataController::class, 'eventParawisataComing']);
    Route::get('/event-parawisata/{slug_event_parawisata}', [EventParawisataController::class, 'getDetailParawisata']);


    // EKONOMI KREATIF
    Route::get('/ekonomi-kreatif', [EkonomiKreatifController::class, 'getEkonomiKreatif']);
    Route::get('/ekonomi-kreatif/jarak', [EkonomiKreatifController::class, 'getEkonomiKreatifSortByJarak']);
    Route::get('/ekonomi-kreatif/kategori', [EkonomiKreatifController::class, 'getKategori']);
    Route::get('/ekonomi-kreatif/kategori/{slugkategoriekonomikreatif}', [EkonomiKreatifController::class, 'getByKategori']);

    Route::post("/ekonomi-kreatif/rating", [EkonomiKreatifController::class, 'reviewEkonomiKreatif'])->middleware('verify.api');

    Route::get('/ekonomi-kreatif/{slugekonomikreatif}', [EkonomiKreatifController::class, 'getDetailEkonomiKreatif']);
    Route::get('/ekonomi-kreatif/{slugekonomikreatif}/review', [EkonomiKreatifController::class, 'getReview']);


    // BERITA PARAWISATA
    Route::get('/berita-parawisata', [BeritaParawisataController::class, 'beritaAllParawisata']);
    Route::get('/berita-parawisata/newest', [BeritaParawisataController::class, 'newestBeritaParawisata']);
    Route::get('/berita-parawisata/{slug_event_parawisata}', [BeritaParawisataController::class, 'getDetailBeritaParawisata']);

    // FASILITAS UMUM
    Route::get('/fasilitas-umum', [FasilitasUmumController::class, 'getFasilitasUmum']);
    Route::get('/fasilitas-umum/jarak', [FasilitasUmumController::class, 'getFasilitasUmumSortByJarak']);
    Route::get('/fasilitas-umum/{slugfasilitas_umum}', [FasilitasUmumController::class, 'getDetailFasilitasUmum']);
    Route::get('/fasilitas-umum/{slugfasilitas_umum}/galery', [FasilitasUmumController::class, 'galeriFasilitasUmum']);

    // SEARCH
    Route::any('/search', [SearchController::class, 'home']);

    // GALERY
    Route::any('/galery/{kategori}/{slug}', [GaleryController::class, 'index']);
    Route::any('/galery/parawisata', [GaleryController::class, 'gallery_parawisata']);

    // AUTH
    Route::prefix('auth')->group(function () {
        // Login
        Route::post('login', [Auth\LoginController::class, "login"]);
        Route::post('register', [Auth\RegisterController::class, "register"]);

    });

    Route::middleware(['verify.api'])->group(function () {
        Route::post('users/show', [UserController::class, 'show']);
        Route::post('users/update', [UserController::class, 'update']);
        Route::post('users/update-password', [UserController::class, 'updatePassword']);
    });

    // VISITOR COUNT
    Route::any("visitor-count", [VisitorController::class, 'count']);

    // SLIDER
    Route::get("slider", [GaleryController::class, 'slider']);
    Route::get("vidio", [VidioHomeController::class, 'toClient']);
    Route::any("change-vidio", [VidioHomeController::class, 'change']);


    Route::get('banner/{kategori}', [BannerController::class, 'toClient']);
    Route::get('banner', [BannerController::class, 'toClient2']);


    Route::get('test', function() {
        return Http::get("http://admin.agampesonaberagam.com/api/akomodasi")->json();
    });
});
