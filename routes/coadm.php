<?php

use App\Http\Controllers\EfetivoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('efetivo')->group(function () {
        Route::get('/', [EfetivoController::class, 'index'])->name('efetivo');
    });
});
