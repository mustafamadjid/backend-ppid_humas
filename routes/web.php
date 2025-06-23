<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DynamicMenuController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\UserDataServiceController;
use App\Http\Controllers\UserRegistrationServiceController;
use App\Models\FormPengaduan;
use Illuminate\Support\Facades\Route;

// Authentication
Route::prefix('/auth')->group(function () {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});


Route::prefix('/ppid')->middleware('auth:sanctum')->group(function () {
    
    // User Service Route
    Route::prefix('/user')->group(function () {
        // Register
        Route::post('/register',[UserRegistrationServiceController::class,'store']);
        
        // User Data
        Route::controller(UserDataServiceController::class)->group(function () {
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

     // Dynamic Menu
     Route::prefix('/menu-beranda')->controller(DynamicMenuController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Form Pengaduan
    Route::prefix('/pengaduan')->controller(FormPengaduanController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::delete('/{id}', 'destroy');
    });
});



