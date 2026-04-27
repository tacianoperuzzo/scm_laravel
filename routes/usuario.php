<?php

use App\Http\Controllers\Settings\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user.users');
        Route::post('/', [UserController::class, 'store'])->name('user.create');
        Route::put('/', [UserController::class, 'update'])->name('user.update');
        Route::put('/{id}/status', [UserController::class, 'status'])->name('user.status');
    });
});
