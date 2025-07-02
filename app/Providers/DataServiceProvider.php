<?php

namespace App\Providers;

use App\Http\Controllers\BannerBerandaController;
use App\Http\Controllers\DokumenPublikController;
use App\Http\Controllers\DynamicMenuController;
use App\Http\Controllers\MaklumatPelayananController;
use App\Http\Controllers\UserDataServiceController;
use App\Services\DataServiceInterface;
use App\Services\Implementation\BannerBerandaImpl;
use App\Services\Implementation\DokumenPublikImpl;
use App\Services\Implementation\DynamicMenuImpl;
use App\Services\Implementation\MaklumatPelayananServiceImpl;
use App\Services\Implementation\UserDataServiceImpl;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Binding Banner Beranda
        $this->app->when(BannerBerandaController::class)
        ->needs(DataServiceInterface::class)
        -> give(BannerBerandaImpl::class);

        // Binding Dokumen Publik
        $this->app->when(DokumenPublikController::class)
        ->needs(DataServiceInterface::class)
        -> give(DokumenPublikImpl::class);

        // Binding Dynamic menu
        $this->app->when(DynamicMenuController::class)
        ->needs(DataServiceInterface::class)
        -> give(DynamicMenuImpl::class);

        // Binding Maklumat Pelayanan
        $this->app->when(MaklumatPelayananController::class)
        ->needs(DataServiceInterface::class)
        -> give(MaklumatPelayananServiceImpl::class);

        // Binding User Data
        $this->app->when(UserDataServiceController::class)
        ->needs(DataServiceInterface::class)
        -> give(UserDataServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
