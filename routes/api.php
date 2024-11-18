<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\SearchController;
Route::get('/search', [SearchController::class, 'index']);

use App\Http\Controllers\Api\UserController;
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users', [UserController::class, 'edit']);
Route::delete('/users', [UserController::class, 'destroy']);
