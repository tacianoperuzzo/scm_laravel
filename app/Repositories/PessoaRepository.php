<?php

namespace App\Repositories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;

class PessoaRepository
{
    public function getOne(int $id): ? Model
    {
        return Pessoa::find($id);
    }

    public function findByCpf(string $cpf): ? Model
    {
        return Pessoa::where('cpf', $cpf)->first();
    }
}
