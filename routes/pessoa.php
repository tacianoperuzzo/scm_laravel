<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/pessoa/cpf/{cpf}', [\App\Http\Controllers\PessoaController::class, 'findByCpf'])->name('pessoa.findByCpf');

});
