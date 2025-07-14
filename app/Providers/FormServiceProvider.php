<?php

namespace App\Providers;

use App\Http\Controllers\FormContactUsController;
use App\Http\Controllers\FormKeberatanController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\FormPermohonanInformasiController;
use App\Services\FormServiceInterface;
use App\Services\Implementation\FormContactUsImpl;
use App\Services\Implementation\FormKeberatanServiceImpl;
use App\Services\Implementation\FormPengaduanImpl;
use App\Services\Implementation\FormPermohonanInformasiImpl;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Binding form keberatan controller
        $this->app->when(FormKeberatanController::class)
            ->needs(FormServiceInterface::class)
            ->give(FormKeberatanServiceImpl::class);

        // Binding form pengaduan controller
        $this->app->when(FormPengaduanController::class)
            ->needs(FormServiceInterface::class)
            ->give(FormPengaduanImpl::class);

        
        // Binding form permohonan
        $this->app->when(FormPermohonanInformasiController::class)
            ->needs(FormServiceInterface::class)
            ->give(FormPermohonanInformasiImpl::class);

        // Binding form contact us
        $this->app->when(FormContactUsController::class)
            ->needs(FormServiceInterface::class)
            ->give(FormContactUsImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
