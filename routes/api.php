<?php

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\UserController;

Route::middleware(['api'])->group(function () {
    // Route::get('/search', [SearchServices::class, 'index']);

    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'edit']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Route::get('/pendaftaran-pasien', [PendaftaranServices::class, 'index']);
    // Route::post('/pendaftaran-pasien', [PendaftaranServices::class, 'store']);
    // Route::put('/pendaftaran-pasien/{id}', [PendaftaranServices::class, 'edit']);
    // Route::delete('/pendaftaran-pasien/{id}', [PendaftaranServices::class, 'destroy']);
});
