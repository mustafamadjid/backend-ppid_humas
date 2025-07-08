<?php

namespace App\Providers;

use App\Services\DeskripsiHalamanDokumenInterface;
use App\Services\Implementation\DeskripsiHalamanDokumenImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DeskripsiHalamanDokumenProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides() {
        return [DeskripsiHalamanDokumenInterface::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DeskripsiHalamanDokumenInterface::class, DeskripsiHalamanDokumenImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
