<?php

namespace App\Providers;

use App\Services\DokumenServiceInterface;
use App\Services\Implementation\DokumenPublikImpl;
use Illuminate\Support\ServiceProvider;

class DokumenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DokumenServiceInterface::class,DokumenPublikImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
