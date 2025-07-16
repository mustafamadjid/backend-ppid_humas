<?php

namespace App\Providers;

use App\Services\AktivitasTerbaruInterface;
use App\Services\Implementation\AktivitasTerbaruImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AktivitasTerbaruProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [AktivitasTerbaruInterface::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AktivitasTerbaruInterface::class, AktivitasTerbaruImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
