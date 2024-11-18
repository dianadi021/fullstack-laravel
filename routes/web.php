<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Web\WebController;
Route::middleware(['auth'])->prefix('master-data')->group(function () {
    Route::get('/golongan-darah', [WebController::class, 'GolonganDarah'])->name('master-data.golongan-darah');
    Route::get('/user-system', [WebController::class, 'UserSystem'])->name('master-data.user-system');
    Route::get('/wilayah', [WebController::class, 'Wilayah'])->name('master-data.wilayah');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
