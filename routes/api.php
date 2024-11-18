<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\PendaftaranPasienController;

// Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
// });

Route::middleware(['api'])->group(function () {
    Route::get('/search', [SearchController::class, 'index']);

    Route::prefix('v1')->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::post('/pendaftaran-pasien', [PendaftaranPasienController::class, 'store']);
        Route::get('/pendaftaran-pasien', [PendaftaranPasienController::class, 'index']);
        Route::get('/pendaftaran-pasien/{id}', [UserController::class, 'show']);
        Route::put('/pendaftaran-pasien/{id}', [PendaftaranPasienController::class, 'update']);
        Route::delete('/pendaftaran-pasien/{id}', [PendaftaranPasienController::class, 'destroy']);
    });
});
