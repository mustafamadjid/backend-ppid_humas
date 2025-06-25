<?php

namespace App\Providers;

use App\Services\DokumenPublikInterface;
use App\Services\Implementation\DokumenPublikImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DokumenPublikProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(){
        return [DokumenPublikInterface::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DokumenPublikInterface::class,DokumenPublikImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
