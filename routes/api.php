<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\PendaftaranPasienController;

// Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
// });

// Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['api'])->group(function () {
        Route::get('/search', [SearchController::class, 'index']);

        Route::prefix('v1')->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('pendaftaran-pasien', PendaftaranPasienController::class);
        });
    });
// });