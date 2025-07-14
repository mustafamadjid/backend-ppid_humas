<?php

namespace App\Providers;

use App\Http\Controllers\AktivitasTerbaruController;
use App\Http\Controllers\BannerBerandaController;
use App\Http\Controllers\DynamicMenuController;
use App\Http\Controllers\GambarSopController;
use App\Http\Controllers\InfografisServiceController;
use App\Http\Controllers\JabatanOrganisasiController;
use App\Http\Controllers\MaklumatPelayananController;
use App\Http\Controllers\PegawaiServiceController;
use App\Http\Controllers\ProfilPpidController;
use App\Http\Controllers\SematanAplikasiController;
use App\Http\Controllers\UserDataServiceController;
use App\Services\DataServiceInterface;
use App\Services\Implementation\AktivitasTerbaruImpl;
use App\Services\Implementation\BannerBerandaImpl;
use App\Services\Implementation\DynamicMenuImpl;
use App\Services\Implementation\GambarSopServiceImpl;
use App\Services\Implementation\InfografisServiceImpl;
use App\Services\Implementation\JabatanOrganisasiServiceImpl;
use App\Services\Implementation\MaklumatPelayananServiceImpl;
use App\Services\Implementation\PegawaiServiceImpl;
use App\Services\Implementation\ProfilPpidServiceImpl;
use App\Services\Implementation\SematanAplikasiImpl;
use App\Services\Implementation\UserDataServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides() {
        return [
            DataServiceInterface::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        // Binding Banner Beranda
        $this->app->when(BannerBerandaController::class)
        ->needs(DataServiceInterface::class)
        -> give(BannerBerandaImpl::class);

        // Binding Dynamic menu
        $this->app->when(DynamicMenuController::class)
        ->needs(DataServiceInterface::class)
        ->give(DynamicMenuImpl::class);

        // Binding Maklumat Pelayanan
        $this->app->when(MaklumatPelayananController::class)
        ->needs(DataServiceInterface::class)
        ->give(MaklumatPelayananServiceImpl::class);

        // Binding User Data
        $this->app->when(UserDataServiceController::class)
        ->needs(DataServiceInterface::class)
        ->give(UserDataServiceImpl::class);

        // Binding Jabatan Organisasi
        $this->app->when(JabatanOrganisasiController::class)
        ->needs(DataServiceInterface::class)
        ->give(JabatanOrganisasiServiceImpl::class);

        // Binding Gambar SOP
        $this->app->when(GambarSopController::class)
        ->needs(DataServiceInterface::class)
        ->give(GambarSopServiceImpl::class);

        // Binding Profil ppid
        $this->app->when(ProfilPpidController::class)
        ->needs(DataServiceInterface::class)
        ->give(ProfilPpidServiceImpl::class);

        // Binding Pegawai
        $this->app->when(PegawaiServiceController::class)
        ->needs(DataServiceInterface::class)
        ->give(PegawaiServiceImpl::class);

        // Binding Sematan Aplikasi
        $this->app->when(SematanAplikasiController::class)
        ->needs(DataServiceInterface::class)
        ->give(SematanAplikasiImpl::class);

        // Binding infografis
        $this->app->when(InfografisServiceController::class)
        ->needs(DataServiceInterface::class)
        ->give(InfografisServiceImpl::class);

       

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
