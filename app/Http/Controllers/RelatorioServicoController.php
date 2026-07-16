<?php

namespace App\Http\Controllers;

use App\Http\Requests\RelatorioServico\RelatorioServicoPostRequest;
use App\Repositories\RelatorioServicoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RelatorioServicoController extends Controller
{
    protected RelatorioServicoRepository $repository;
    public function __construct(RelatorioServicoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        RelatorioServicoRepository $relatorioServicoRepository,
        Request $request)
    {
        $listagem = $relatorioServicoRepository->getAll();
        $id = $request->input('id');
        return Inertia::render('coseg/relatorio_servico/index', [
            'listagem' => $listagem,
            'model' => Inertia::optional(fn() => $relatorioServicoRepository->getOne($id)),
        ]);
    }

    public function create()
    {
        return Inertia::render('coseg/relatorio_servico/create');
    }

    public function store(RelatorioServicoPostRequest $request, RelatorioServicoRepository $relatorioServicoRepository)
    {
        $relatorioServico = $this->repository->create($request->validated());
        return response()->redirectToRoute('relatorio-servico.index');
    }

    public function update(RelatorioServicoPostRequest $request, int $id)
    {
        $relatorioServico = $this->repository->update($id, $request->validated());
        return response()->redirectToRoute('relatorio-servico.index');
    }
}
