<?php

namespace App\Providers;

use App\Services\FormPengaduanInterface;
use App\Services\Implementation\FormPengaduanImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FormPengaduanProvider extends ServiceProvider implements DeferrableProvider
{
   public function provides(){
        return [FormPengaduanInterface::class];
   } 
    
    public function register(): void
    {
        $this->app->singleton(FormPengaduanInterface::class,FormPengaduanImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
