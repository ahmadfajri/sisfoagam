<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->as("admin.")->group(function () {
    Route::get("login", [Admin\Auth\LoginController::class, 'index'])->name("login");
    Route::post("login", [Admin\Auth\LoginController::class, 'store']);

    Route::get("daftar", [Admin\Auth\LoginController::class, 'daftar'])->name("daftar");
    Route::post("daftarkan", [Admin\Auth\LoginController::class, 'register'])->name("daftarkan");



    Route::middleware(['auth'])->group(function () {
        Route::get("logout", [Admin\Auth\LoginController::class, 'logout'])->name("logout");

        Route::get('/', function() {
            return redirect()->route("admin.home");
        });

        Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
        Route::get('data/chart', [Admin\HomeController::class, 'chart'])->name('chart');

        Route::prefix('master-data')->as('master-data.')->group(function () {

            Route::prefix("akomodasi")->as("akomodasi.")->group(function () {
                Route::resource('kategori', Admin\MasterData\Akomodasi\KategoriController::class);
                Route::resource('fasilitas', Admin\MasterData\Akomodasi\FasilitasController::class);

            });

            Route::prefix("destinasi-wisata")->as("destinasi-wisata.")->group(function () {
                Route::resource('kategori', Admin\MasterData\DestinasiWisata\KategoriController::class);
                Route::resource('fasilitas', Admin\MasterData\DestinasiWisata\FasilitasController::class);
            });

            Route::prefix("ekonomi-kreatif")->as("ekonomi-kreatif.")->group(function () {
                Route::resource('kategori', Admin\MasterData\EkonomiKreatif\KategoriController::class);
            });

            Route::prefix("video")->as("video.")->group(function () {
                Route::get('/', [Api\VidioHomeController::class, 'index'])->name('index');
                Route::post('/', [Api\VidioHomeController::class, 'change']);
            });

            Route::resource('panduan', Admin\PanduanController::class);


            Route::prefix("banner")->as("banner.")->middleware(['banner.verif'])->group(function () {
                Route::get('{kategori}', [Admin\MasterData\BannerController::class, 'index'])->name('index');
                Route::post('{kategori}', [Admin\MasterData\BannerController::class, 'change'])->name('store');
            });
        });

        Route::get('panduan-aplikasi/{slug?}', [Admin\PanduanController::class, "show"])->name('panduan.show');

        // Foto Slider
        Route::prefix("foto-slider")->as("foto-slider.")->group(function(){
            Route::get('foto_slider',[Admin\MasterData\FotoSlider\FotoSliderController::class, 'index'])->name('index');
            Route::post('foto_slider',[Admin\MasterData\FotoSlider\FotoSliderController::class, 'store'])->name('store');
            Route::delete('foto_slider/delete/{id}',[Admin\MasterData\FotoSlider\FotoSliderController::class, 'destroy'])->name('destroy');
            Route::post('foto_slider/edit/{id}', [Admin\MasterData\FotoSlider\FotoSliderController::class, 'edit'])->name('edit');

        });

        Route::prefix('akomodasi')->as('akomodasi.')->group(function (){
            Route::get('home', [Admin\AkomodasiController::class, 'index'])->name('home');
            Route::get('add', [Admin\AkomodasiController::class, 'add'])->name('add');
            Route::get('edit/{id}', [Admin\AkomodasiController::class, 'edit_page'])->name('edit-page');
            Route::post('tambah', [Admin\AkomodasiController::class, 'create'])->name('tambah');
            Route::post('edit', [Admin\AkomodasiController::class, 'edit'])->name('edit');
            Route::post('delete', [Admin\AkomodasiController::class, 'delete'])->name('delete');
            Route::post('fasilitas', [Admin\AkomodasiController::class, 'fasilitas'])->name('fasilitas');
            Route::get('{id}/fasilitas', [Admin\AkomodasiController::class, 'fasilitas_select2'])->name('fasilitas_select2');
            Route::get('{id}/media', [Admin\AkomodasiController::class, 'media'])->name('media');
            Route::get('{id}/detail', [Admin\AkomodasiController::class, 'detail'])->name('detail');
            Route::delete('{id}/hapus',[Admin\AkomodasiController::class, 'destroy'])->name('hapus.data_review_akomodasi');

            Route::prefix('{akomodasi_id}/visitor')->group(function () {
                Route::get('/', [Admin\AkomodasiVisitorController::class, 'index']);
                Route::post('/', [Admin\AkomodasiVisitorController::class, 'store']);
                Route::get('form', [Admin\AkomodasiVisitorController::class, 'create']);
                Route::get('{visitor}/form', [Admin\AkomodasiVisitorController::class, 'edit']);
                Route::post('{visitor}/update', [Admin\AkomodasiVisitorController::class, 'update']);
                Route::delete('{visitor}/delete', [Admin\AkomodasiVisitorController::class, 'destroy']);
            });
        });

        // Route::prefix('destinasi-wisata')->as('destinasi-wisata.')->group(function (){
        //     Route::get('home', [Admin\DestinasiWisataController::class, 'index'])->name('home');
        //     Route::post('tambah', [Admin\DestinasiWisataController::class, 'create'])->name('tambah');
        //     Route::post('edit', [Admin\DestinasiWisataController::class, 'edit'])->name('edit');
        //     Route::post('delete', [Admin\DestinasiWisataController::class, 'delete'])->name('delete');
        //     Route::post('fasilitas', [Admin\DestinasiWisataController::class, 'fasilitas'])->name('fasilitas');
        // });


        // EKONOMI KREATIF
        Route::get('ekonomi-kreatif/{id}/fasilitas', [Admin\EkonomiKreatifController::class, 'fasilitas_select2'])->name('ekonomi-kreatif.fasilitas_select2');
        Route::get('ekonomi-kreatif/{id}/media', [Admin\EkonomiKreatifController::class, 'media'])->name('ekonomi-kreatif.media');
        Route::resource('ekonomi-kreatif', Admin\EkonomiKreatifController::class);

        Route::prefix('ekonomi-kreatif')->as('ekonomi-kreatif.')->group(function(){

        Route::get('{id}/detail', [Admin\EkonomiKreatifController::class, 'detail'])->name('detail');
        Route::delete('{id}/hapus',[Admin\EkonomiKreatifController::class, 'destroy1'])->name('hapus.data_review_ekonomi');
        });

        // DESTINASI WISATA
        Route::prefix('destinasi_wisata/{destinasi_wisata}/visitor')->group(function () {
            Route::get('/', [Admin\DestinasiWisataVisitorController::class, 'index']);
            Route::post('/', [Admin\DestinasiWisataVisitorController::class, 'store']);
            Route::get('form', [Admin\DestinasiWisataVisitorController::class, 'create']);
            Route::get('{visitor}/form', [Admin\DestinasiWisataVisitorController::class, 'edit']);
            Route::post('{visitor}/update', [Admin\DestinasiWisataVisitorController::class, 'update']);
            Route::delete('{visitor}/delete', [Admin\DestinasiWisataVisitorController::class, 'destroy']);
        });

        Route::get('destinasi-wisata/{id}/detail', [Admin\DestinasiWisataController::class, 'detail'])->name('destinasi-wisata.detail');
        Route::get('destinasi-wisata/{id}/fasilitas', [Admin\DestinasiWisataController::class, 'fasilitas_select2'])->name('destinasi-wisata.fasilitas_select2');
        Route::get('destinasi-wisata/{id}/media', [Admin\DestinasiWisataController::class, 'media'])->name('destinasi-wisata.media');
        Route::post('destinasi-wisata/{destinasi_wisatum}/jumlah-kunjungan', [Admin\DestinasiWisataController::class, 'ubahJumlahKunjungan'])->name('destinasi-wisata.ubahJumlahKunjungan');
        Route::resource('destinasi-wisata', Admin\DestinasiWisataController::class);
        Route::delete('{id}/hapus',[Admin\DestinasiWisataController::class, 'destroy1'])->name('hapus.data_review_destinasi');

        // BERITA PARAWISATA
        Route::resource('berita-parawisata', Admin\BeritaParawisataController::class);
        Route::prefix('berita-pariwisata')->as('berita-pariwisata.')->group(function(){
            Route::get('{id}/detail', [Admin\BeritaParawisataController::class, 'detail'])->name('detail');
        });


        // GALERY PARAWISATA
        Route::resource('galeri-parawisata', Admin\GaleriParawisataController::class);

        // EVENT PARAWISATA
        Route::resource('event-parawisata', Admin\EventParawisataController::class);

        // FASILITAS UMUM
        Route::resource('fasilitas-umum', Admin\FasilitasUmumController::class);

        // USER ADMIN
        Route::resource('user/admin', Admin\UserAdminController::class);
    });

    Route::prefix('select2')->as('select2.')->group(function () {
        Route::any('fasilitas-akomodasi', [Admin\FasilitasAkomodasiController::class, 'select2Fasilitas'])->name('fasilitas-akomodasi');
        Route::any('fasilitas-wisata', [Admin\MasterData\DestinasiWisata\FasilitasController::class, 'select2'])->name('fasilitas-wisata');

        Route::any('kategori-akomodasi', [Admin\MasterData\Akomodasi\KategoriController::class, 'select2'])->name('kategori-akomodasi');
        Route::any('kategori-wisata', [Admin\MasterData\DestinasiWisata\KategoriController::class, 'select2'])->name('kategori-wisata');
        Route::any('kategori-ekonomi', [Admin\MasterData\EkonomiKreatif\KategoriController::class, 'select2'])->name('kategori-ekonomi');
    });
});
