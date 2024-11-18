<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\PasienRegisterController;

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

        Route::post('/pendaftaran-pasien', [PasienRegisterController::class, 'store']);
        Route::get('/pendaftaran-pasien', [PasienRegisterController::class, 'index']);
        Route::get('/pendaftaran-pasien/{id}', [UserController::class, 'show']);
        Route::put('/pendaftaran-pasien/{id}', [PasienRegisterController::class, 'update']);
        Route::delete('/pendaftaran-pasien/{id}', [PasienRegisterController::class, 'destroy']);
    });
});
