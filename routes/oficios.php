<?php

use App\Http\Controllers\OficioController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('oficios', OficioController::class);

    Route::prefix('oficio')->group(function () {
        Route::post('/preview/{id?}', [OficioController::class, 'preview'])->name('oficio.preview');
        Route::post('/delete-preview', [OficioController::class, 'deletePreview'])->name('oficio.delete-preview');
    });
});
