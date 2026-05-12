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
}
