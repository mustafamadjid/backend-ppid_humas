<?php

namespace App\Providers;

use App\Services\Implementation\VisitorServiceImpl;
use App\Services\VisitorServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class VisitorProvider extends ServiceProvider 
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VisitorServiceInterface::class, VisitorServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
