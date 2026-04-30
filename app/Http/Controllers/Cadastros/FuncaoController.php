<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\FuncaoPostRequest;
use App\Models\Funcao;
use App\Repositories\FuncaoRepository;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncaoController extends Controller
{
    protected FuncaoRepository $repository;
    public function __construct(FuncaoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $id = $request->input('id');
        return Inertia::render('sistema/cadastros/funcao/index', [
            'funcoes' => $this->repository->getAll(),
            'funcao' => Inertia::optional(fn()=>$this->repository->getOne($id))
        ]);
    }

    public function store(FuncaoPostRequest $request)
    {
        $this->repository->create($request->validated());
        return response()->redirectToRoute('funcoes.index');
    }

    public function update(FuncaoPostRequest $request, Int $id)
    {
        $this->repository->update($id, $request->validated());
        return response()->redirectToRoute('funcoes.index');
    }

    public function destroy(Int $id)
    {
        $this->repository->delete($id);
        return response()->redirectToRoute('funcoes.index');
    }
}
