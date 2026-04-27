<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncaoController extends Controller
{
    public function index(Request $request)
    {
        $funcoes = Funcao::all();
        $id = $request->input('id');
        return Inertia::render('sistema/cadastros/funcao/index', [
            'funcoes' => $funcoes,
            'funcao' => Inertia::optional(fn()=>Funcao::find($id))
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => ['string', 'max:255']
        ]);
        Funcao::create($validated);
        return response()->redirectToRoute('funcoes.index');
    }

    public function update(Request $request, Int $id)
    {
        $funcao = Funcao::find($id);
        if (!$funcao) throw new NotFoundHttpException();
        $validated = $request->validate([
            'descricao' => ['string', 'max:255']
        ]);
        $funcao->update($validated);
        return response()->redirectToRoute('funcoes.index');
    }

    public function destroy(Request $request, Int $id)
    {
        $funcao = Funcao::find($id);
        if (!$funcao) throw new NotFoundHttpException();
        Funcao::find($id)->delete();
        return response()->redirectToRoute('funcoes.index');
    }
}
