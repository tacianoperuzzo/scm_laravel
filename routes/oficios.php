<?php

use App\Http\Controllers\OficioController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/oficios', [OficioController::class, 'index'])->name('oficio');
    Route::prefix('oficio')->group(function () {
        Route::get('/edit/{id}', [OficioController::class, 'edit'])->name('oficio.edit');
        Route::get('/view/{id}', [OficioController::class, 'view'])->name('oficio.view');
        Route::get('/create', [OficioController::class, 'create'])->name('oficio.create');
        Route::post('/store', [OficioController::class, 'store'])->name('oficio.store');
        Route::put('/update/{id}', [OficioController::class, 'store'])->name('oficio.update');
        Route::post('/preview', [OficioController::class, 'preview'])->name('oficio.preview');
        Route::get('/preview/{id}', [OficioController::class, 'previewId'])->name('oficio.preview-id');
        Route::post('/delete-preview', [OficioController::class, 'deletePreview'])->name('oficio.delete-preview');
    });
});
