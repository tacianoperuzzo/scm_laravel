<?php

namespace App\Repositories;

use App\Models\Setor;
use App\Repositories\Contracts\SetorInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SetorRepository implements SetorInterface
{
    public function getAll(): Collection
    {
        return Setor::all();
    }

    public function getOne(int $id): ? Model
    {
        return Setor::find($id);
    }

    public function create(array $data): Model
    {
        // Implementação para criar um novo setor
        return Setor::create($data);
    }

    public function update(int $id, array $data): bool
    {
        // Implementação para atualizar um setor existente
        $setor = $this->getOne($id);
        if ($setor) {
            $setor->update($data);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        // Implementação para deletar um setor por ID
        $setor = $this->getOne($id);
        if ($setor) {
            $setor->delete();
            return true;
        }
        return false;
    }
}
