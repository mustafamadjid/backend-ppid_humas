<?php

namespace App\Providers;

use App\Models\MaklumatPelayanan;
use App\Services\Implementation\MaklumatPelayananServiceImpl;
use App\Services\MaklumatPelayananServiceInterfce;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;


class MaklumatPelayananProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [MaklumatPelayananServiceInterfce::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MaklumatPelayananServiceInterfce::class,MaklumatPelayananServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
