<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BannerBerandaController;
use App\Http\Controllers\DeskripsiHalamanDokumenController;
use App\Http\Controllers\DokumenPublikController;
use App\Http\Controllers\DynamicMenuController;
use App\Http\Controllers\FormKeberatanController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\FormPermohonanInformasiController;
use App\Http\Controllers\GambarSopController;
use App\Http\Controllers\JabatanOrganisasiController;
use App\Http\Controllers\MaklumatPelayananController;
use App\Http\Controllers\ProfilPpidController;
use App\Http\Controllers\UserDataServiceController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::prefix('/auth')->middleware('throttle:login')->group(function () {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});


Route::prefix('/ppid')->middleware(['auth:sanctum','throttle:logged-in'])->group(function () {
    
    // User Service Route
    Route::prefix('/user')->middleware('can:access-user')->group(function () {
        // Register
        Route::post('/register',[UserDataServiceController::class,'store']);
        
        // User Data
        Route::controller(UserDataServiceController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

     // Dynamic Menu
     Route::prefix('/menu-beranda')->controller(DynamicMenuController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Form Pengaduan
    Route::prefix('/pengaduan')->controller(FormPengaduanController::class)->group(function () {
        Route::get('/', 'index');
        Route::delete('/{id}', 'destroy');
    });

    // Form Keberatan
    Route::prefix('/keberatan')->controller(FormKeberatanController::class)->group(function () {
        Route::get('/', 'index');
        
        Route::delete('/{id}', 'destroy');
    });

    // Form Permohonan Informasi
    Route::prefix('/permohonan-informasi')->controller(FormPermohonanInformasiController::class)->group(function () {
        Route::get('/', 'index');
        Route::delete('/{id}', 'destroy');
    });

    // Dokumen publik
    Route::prefix('/dokumen-publik')->controller(DokumenPublikController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Maklumat Pelayanan
    Route::prefix('/maklumat-pelayanan')->controller(MaklumatPelayananController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Banner Beranda
    Route::prefix('/banner-beranda')->controller(BannerBerandaController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Jabatan Organisasi
    Route::prefix('/jabatan-organisasi')->controller(JabatanOrganisasiController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Gambar SOP
    Route::prefix('/gambar-sop')->controller(GambarSopController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Deskripsi halaman dokumen
    Route::prefix('/deskripsi-halaman-dokumen')->controller(DeskripsiHalamanDokumenController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Profil ppid
    Route::prefix('/profil-ppid')->controller(ProfilPpidController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

// API Publik
Route::middleware('throttle:global')->group(function () {
    // Form post
Route::prefix('/formulir')->group(function () {
    // Form Pengaduan
    Route::post('/pengaduan', [FormPengaduanController::class,'store']);

    // Form Keberatan
    Route::post('/keberatan', [FormKeberatanController::class,'store']);

    // Form Permohonan Informasi
    Route::post('/permohonan-informasi', [FormPermohonanInformasiController::class,'store']);
});

// Dokumen berdasarkan tahun
Route::get('/dokumen/{kategori}/{tahun}',[DokumenPublikController::class,'getDataByTahun']);

// Deskripsi halaman dokumen by kategori
Route::get('/deskripsi-halaman-dokumen/{kategori}',[DeskripsiHalamanDokumenController::class,'getDataByKategori']);

// Profil ppid
Route::get(('/profil-ppid'),[ProfilPpidController::class,'index']);

});




