<?php

namespace App\Providers;

use App\Services\FormKeberatanInterface;
use App\Services\Implementation\FormKeberatanServiceImpl;
use Illuminate\Support\ServiceProvider;

class FormKeberatanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FormKeberatanInterface::class,FormKeberatanServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
