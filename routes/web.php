<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('dashboard');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/oficios.php';
require __DIR__.'/coadm.php';
require __DIR__.'/sistema.php';
require __DIR__.'/usuario.php';
require __DIR__.'/pessoa.php';
