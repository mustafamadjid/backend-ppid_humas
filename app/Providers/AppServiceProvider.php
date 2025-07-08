<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-user', function (User $user) {
            return $user->role === 'superadmin';
        });

        RateLimiter::for('global', function ($request) {
            return Limit::perMinute(200)->by($request->ip())->response(function () {
                return response()->json([
                    'status' => 429,
                    'message' => 'Terlalu sering melakukan permintaan'
                ], 429);
            });
        });

        RateLimiter::for('logged-in',function($request){
            return Limit::perMinute(60)->by($request->user()->id)->response(function(){
                return response()->json([
                    'status' => 429,
                    'message' => 'Terlalu sering melakukan permintaan'
                ],429);
            });
        });

        RateLimiter::for('login',function($request){
            return Limit::perMinute(5)->by($request->email)->response(function(){
                return response()->json([
                    'status' => 429,
                    'message' => 'Terlalu sering melakukan percobaan login'
                ],429);
            });
        });
    }
}
