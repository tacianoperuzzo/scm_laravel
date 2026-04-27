<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Efetivo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EfetivoController extends Controller
{
    public function index(Request $request)
    {
        $efetivos = Efetivo::all();
        $cargos = Cargo::all();

        return Inertia::render('coadm/efetivo/index', [
            'efetivos' => $efetivos,
            'cargos' => $cargos,
        ]);
    }
}
