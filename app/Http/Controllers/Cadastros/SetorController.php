<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\SetorPostRequest;
use App\Models\Setor;
use App\Repositories\SetorRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetorController extends Controller
{
    protected SetorRepository $repository;
    public function __construct(SetorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $id = $request->input('id');
        return Inertia::render('sistema/cadastros/setor/index', [
            'setores' => $this->repository->getAll(),
            'setor' => Inertia::optional(fn()=>$this->repository->getOne($id))
        ]);
    }

    public function store(SetorPostRequest $request)
    {
        $this->repository->create($request->validated());
        return response()->redirectToRoute('setores.index');
    }

    public function update(SetorPostRequest $request, Int $id)
    {
        $this->repository->update($id, $request->validated());
        return response()->redirectToRoute('setores.index');
    }

    public function destroy(Int $id)
    {
        $this->repository->delete($id);
        return response()->redirectToRoute('setores.index');
    }
}
