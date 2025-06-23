<?php

namespace App\Providers;

use App\Services\Implementation\UserDataServiceImpl;
use App\Services\UserDataServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UserDataServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [UserDataServiceInterface::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserDataServiceInterface::class,UserDataServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
