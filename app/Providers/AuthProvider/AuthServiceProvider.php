<?php

namespace App\Providers\AuthProvider;

use App\Services\AuthServices\AuthServiceInterface;
use App\Services\Implementation\Auth\AuthServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides() {
      return  [AuthServiceInterface::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
