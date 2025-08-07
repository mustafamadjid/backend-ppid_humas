<?php

use App\Http\Controllers\AktivitasTerbaruController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BannerBerandaController;
use App\Http\Controllers\DashboardServiceController;
use App\Http\Controllers\DeskripsiHalamanDokumenController;
use App\Http\Controllers\DokumenPublikController;
use App\Http\Controllers\DynamicMenuController;
use App\Http\Controllers\FormContactUsController;
use App\Http\Controllers\FormKeberatanController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\FormPermohonanInformasiController;
use App\Http\Controllers\GambarSopController;
use App\Http\Controllers\InfografisServiceController;
use App\Http\Controllers\JabatanOrganisasiController;
use App\Http\Controllers\KategoriDokumenController;
use App\Http\Controllers\MaklumatPelayananController;
use App\Http\Controllers\PegawaiServiceController;
use App\Http\Controllers\ProfilPpidController;
use App\Http\Controllers\SematanAplikasiController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\tahunDokumenTampilController;
use App\Http\Controllers\UserDataServiceController;
use App\Http\Controllers\VisitorController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// Authentication
Route::prefix('/auth')->middleware('throttle:login')->group(function () {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});


Route::prefix('/ppid')->middleware(['auth:sanctum','throttle:logged-in'])->group(function () {
    
    // User Service Route
    Route::prefix('/user')->middleware('can:access-user')->group(function () {
        // Register
        Route::post('/',[UserDataServiceController::class,'store']);
        
        // User Data
        Route::controller(UserDataServiceController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');

        });
    });
    // Ambil user login
    Route::get('/user-logged-in', [UserDataServiceController::class, 'userLoggedIn']);

     // Dynamic Menu
     Route::prefix('/menu-beranda')->controller(DynamicMenuController::class)->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    

    // Formulir
    Route::prefix('/formulir')->group(function () {
        // Form Keberatan
        Route::prefix('/pengajuan-keberatan')->controller(FormKeberatanController::class)->group(function () {
        Route::get('/', 'index');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

        // Form Permohonan Informasi
        Route::prefix('/permohonan-informasi')->controller(FormPermohonanInformasiController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

        // Form Pengaduan
        Route::prefix('/pengaduan')->controller(FormPengaduanController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

        // Form Contact Us
        Route::prefix('/contact-us')->controller(FormContactUsController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
    

    // Dokumen publik
    Route::prefix('/dokumen-publik')->controller(DokumenPublikController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Kategori Dokumen
    Route::prefix('/kategori-dokumen')->controller(KategoriDokumenController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

        // By jenis
        Route::get('/informasi-publik','getKategoriInformasiPublik');
        Route::get('/layanan-informasi','getKategoriLayananInformasi');
        Route::get('/pelayanan','getKategoriPelayanan');
        Route::get('/lainnya','getKategoriLainnya');
    });

    // Maklumat Pelayanan
    Route::prefix('/maklumat-pelayanan')->controller(MaklumatPelayananController::class)->group(function(){
        
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Banner Beranda
    Route::prefix('/banner-beranda')->controller(BannerBerandaController::class)->group(function(){
        
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Gambar SOP
    Route::prefix('/gambar-sop')->controller(GambarSopController::class)->group(function(){
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Deskripsi halaman dokumen
    Route::prefix('/deskripsi-halaman-dokumen')->controller(DeskripsiHalamanDokumenController::class)->group(function(){
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Profil ppid
    Route::prefix('/profil-ppid')->controller(ProfilPpidController::class)->group(function(){
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Sematan aplikasi
    Route::prefix('/sematan-aplikasi')->controller(SematanAplikasiController::class)->group(function(){
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

     // Jabatan Organisasi
     Route::prefix('/jabatan-organisasi')->controller(JabatanOrganisasiController::class)->group(function(){
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Pegawai
    Route::prefix('/pegawai')->controller(PegawaiServiceController::class)->group(function(){
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Infografis
    Route::prefix('/infografis')->controller(InfografisServiceController::class)->group(function(){
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Aktivitas Terbaru
    Route::get('/aktivitas-terbaru', [AktivitasTerbaruController::class,'index']);

    // Dashboard Admin
    Route::prefix('/dashboard')->controller(DashboardServiceController::class)->group(function(){
        Route::get('/total-dokumen', 'countDokumen');
        Route::get('/total-form-pengaduan', 'countFormPengaduan');
        Route::get('/total-form-pengajuan-keberatan', 'countFormPengajuanKeberatan');
        Route::get('/total-form-permohonan', 'countFormPermohonan');
        Route::get('/total-admin', 'countAdmin');
        Route::get('/total-status-pengaduan', 'countStatusFormPengaduan');
        Route::get('/total-status-contact-us', 'countStatusFormContactUs');
        Route::get('/total-status-permohonan-informasi', 'countStatusFormPermohonan');
        Route::get('/total-status-pengajuan-keberatan', 'countStatusFormPengajuanKeberatan');
    });
});


// API Publik
Route::middleware('throttle:global')->group(function () {
    // Form post
Route::prefix('/formulir')->group(function () {
    // Form Pengaduan
    Route::post('/pengaduan', [FormPengaduanController::class,'store']);

    // Form Keberatan
    Route::post('/pengajuan-keberatan', [FormKeberatanController::class,'store']);

    // Form Permohonan Informasi
    Route::post('/permohonan-informasi', [FormPermohonanInformasiController::class,'store']);

    // Form Contact Us
    Route::post('/contact-us', [FormContactUsController::class,'store']);
});

// Dokumen route
Route::prefix('/dokumen')->controller(DokumenPublikController::class)->group(function () {
    // Dokumen berdasarkan tahun
    Route::get('/dokumen-tahun/{kategori}/{tahun}','getDataByTahunKategori');

    // Ambil semua kategori yang ada di dokumen berdasarkan jenis
    Route::get('/kategori/{jenis_dokumen}','getAllKategoriByJenis');

    // Ambil hanya tahun dokumen
    Route::get('/tahun-dokumen','getAllTahun');

    // Download dokumen
    Route::get('/download/{filename}', 'downloadData');
    
});

// Ambil tahun untuk dokumen yang tampil ke pengjunjung
Route::prefix('/tahun-dokumen-pengunjung')->controller(tahunDokumenTampilController::class)->group(function () {
   Route::get('/','index');
   Route::post('/','store');
   Route::put('/{id}','update'); 
});


// Deskripsi halaman dokumen by kategori
Route::get('/deskripsi-halaman-dokumen/{kategori}',[DeskripsiHalamanDokumenController::class,'getDataByKategori']);

// Web visitor
Route::prefix('/visitor')->controller(VisitorController::class)->group(function(){
    Route::post('/', 'store');
    Route::get('/total-visitor', 'getTotalVisitor');
    Route::get('/total-visitor-today', 'getVisitorToday');
});

// Beranda

// Menu beranda
Route::get('/menu-beranda', [DynamicMenuController::class, 'index']);

// Maklumat Pelayanan
Route::get('/maklumat-pelayanan', [MaklumatPelayananController::class, 'index']);

// Banner Beranda
Route::get('/banner-beranda', [BannerBerandaController::class, 'index']);

// SOP
  Route::get('/sop', [GambarSopController::class, 'index']);


//  Profil PPID
 Route::get('/profil-ppid', [ProfilPpidController::class, 'index']);

//  Sematan Aplikasi
 Route::get('/sematan-aplikasi', [SematanAplikasiController::class, 'index']);

//  Infografis
 Route::get('/infografis', [InfografisServiceController::class, 'index']);

//  Jabatan Organisasi
Route::get('/jabatan-organisasi', [JabatanOrganisasiController::class, 'index']);

// Pegawai 
Route::get('/pegawai', [PegawaiServiceController::class, 'index']);

// Struktut organisasi
Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'getStruktur']);


// Reset Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (HttpRequest $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (HttpRequest $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only(['email', 'password', 'password_confirmation', 'token']),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PasswordReset
        ? view('auth.reset-success')
        : back()->withErrors(['email' => [__($status)]]);
    })->middleware('guest')->name('password.update');

});


// Buat seeder super admin
Route::get('/seeder-admin',function(){
    $res = Artisan::call('db:seed --class=SuperAdminSeeder');
     echo $res;
});


