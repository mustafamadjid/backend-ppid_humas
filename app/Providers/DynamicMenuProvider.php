<?php

namespace App\Providers;

use App\Services\DynamicMenuInterface;
use App\Services\Implementation\DynamicMenuImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DynamicMenuProvider extends ServiceProvider implements DeferrableProvider
{

    public function provides(){
        return [DynamicMenuInterface::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DynamicMenuInterface::class,DynamicMenuImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
