<?php

namespace App\Providers;

use App\Services\DashboardServiceInterface;
use App\Services\Implementation\DashboardServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [
            DashboardServiceInterface::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DashboardServiceInterface::class, DashboardServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
