<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetorController extends Controller
{
    public function index(Request $request)
    {
        $setores = Setor::all();
        $id = $request->input('id');
        return Inertia::render('sistema/cadastros/setor/index', [
            'setores' => $setores,
            'setor' => Inertia::optional(fn()=>Setor::find($id))
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => ['string', 'max:255'],
            'sigla' => ['string', 'max:255', 'nullable']
        ]);
        Setor::create($validated);
        return response()->redirectToRoute('setores.index');
    }

    public function update(Request $request, Int $id)
    {
        $setor = Setor::find($id);
        if (!$setor) throw new NotFoundHttpException();
        $validated = $request->validate([
            'descricao' => ['string', 'max:255'],
            'sigla' => ['string', 'max:255', 'nullable']
        ]);
        $setor->update($validated);
        return response()->redirectToRoute('setores.index');
    }

    public function destroy(Request $request, Int $id)
    {
        $setor = Setor::find($id);
        if (!$setor) throw new NotFoundHttpException();
        Setor::find($id)->delete();
        return response()->redirectToRoute('setores.index');
    }
}
