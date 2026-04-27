<?php

use App\Http\Controllers\Cadastros\FuncaoController;
use App\Http\Controllers\Cadastros\SetorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('sistema')->group(function () {
        Route::prefix('cadastros')->group(function () {
            Route::resource('setores', SetorController::class)
                ->only(['index', 'store', 'update', 'destroy']);
            Route::resource('funcoes', FuncaoController::class)
                ->only(['index', 'store', 'update', 'destroy']);
        });
    });
});
