<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Web\V1\WebController;
use App\Http\Controllers\Web\V1\PendaftaranPasienController;
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('master-data')->group(function () {
        Route::get('/golongan-darah', [WebController::class, 'GolonganDarah'])->name('master-data.golongan-darah');
        Route::get('/user-system', [WebController::class, 'UserSystem'])->name('master-data.user-system');
        Route::get('/wilayah', [WebController::class, 'Wilayah'])->name('master-data.wilayah');
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/pendaftaran-pasien', [WebController::class, 'PendaftaranPasien'])->name('transaksi.pendaftaran-pasien');
    });

    Route::prefix('v1')->group(function () {
        Route::post('/pendaftaran-pasien', [PendaftaranPasienController::class, 'store']);
    });
});

require __DIR__.'/auth.php';
