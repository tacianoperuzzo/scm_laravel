<?php

namespace App\Repositories;

use App\Models\Funcao;
use App\Repositories\Contracts\FuncaoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FuncaoRepository implements FuncaoInterface
{
    public function getAll(): Collection
    {
        // Implementação para obter todas as funções
        return Funcao::all();
    }

    public function getOne(int $id): ? Model
    {
        // Implementação para obter uma função por ID
        return Funcao::find($id);
    }

    public function create(array $data): Model
    {
        // Implementação para criar uma nova função
        return Funcao::create($data);
    }

    public function update(int $id, array $data): bool
    {
        // Implementação para atualizar uma função existente
        $funcao = $this->getOne($id);
        if ($funcao) {
            $funcao->update($data);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        // Implementação para deletar uma função por ID
        $funcao = $this->getOne($id);
        if ($funcao) {
            $funcao->delete();
            return true;
        }
        return false;
    }
}
