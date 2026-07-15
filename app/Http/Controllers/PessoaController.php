<?php

namespace App\Http\Controllers;

use App\Repositories\PessoaRepository;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function findByCpf(PessoaRepository $pessoaRepository, string $cpf)
    {
        $pessoa = $pessoaRepository->findByCpf($cpf);
        return response()->json($pessoa);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');
            return response()->json(['url' => $path]);
        }
        return response()->json(['error' => 'Nenhum arquivo enviado.'], 400);
    }
}
