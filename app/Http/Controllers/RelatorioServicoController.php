<?php

namespace App\Http\Controllers;

use App\Repositories\RelatorioServicoRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RelatorioServicoController extends Controller
{
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

    public function store()
    {
        // Implement the logic to store a new RelatorioServico

    }

    public function update()
    {
        // Implement the logic to update an existing RelatorioServico

    }
}
