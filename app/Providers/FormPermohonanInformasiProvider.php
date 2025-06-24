<?php

namespace App\Providers;


use App\Services\FormPermohonanInformasiInterface;
use App\Services\Implementation\FormPermohonanInformasiImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FormPermohonanInformasiProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [FormPermohonanInformasiInterface::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FormPermohonanInformasiInterface::class,FormPermohonanInformasiImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
