<?php

use App\Http\Controllers\Settings\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)
                ->only(['index', 'store', 'update', 'destroy']);
    Route::prefix('user')->group(function () {
        Route::put('/{id}/status', [UserController::class, 'status'])->name('user.status');
    });
});
