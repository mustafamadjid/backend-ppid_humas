<?php

namespace App\Providers;

use App\Services\Implementation\UserRegistrationServiceImpl;
use App\Services\UserRegistrationServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UserRegistrationServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public function provides(){
        return [UserRegistrationServiceInterface::class];
    }
    
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRegistrationServiceInterface::class,UserRegistrationServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
