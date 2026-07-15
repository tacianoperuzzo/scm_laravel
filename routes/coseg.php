<?php

use App\Http\Controllers\RelatorioServicoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('relatorio-servico', RelatorioServicoController::class)
                ->only(['index', 'store', 'update', 'destroy']);
});
