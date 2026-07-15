<?php

namespace App\Repositories;

use App\Models\NivelPermissao;
use App\Repositories\Contracts\NivelPermissaoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NivelPermissaoRepository implements NivelPermissaoInterface
{
    public function getAll(): Collection
    {
        return NivelPermissao::all();
    }

    public function getOne(int $id): ? Model
    {
        return NivelPermissao::find($id);
    }

    public function create(array $data): Model
    {
        // Implementação para criar um novo nivel
        return NivelPermissao::create($data);
    }

    public function update(int $id, array $data): bool
    {
        // Implementação para atualizar um nivel existente
        $nivel = $this->getOne($id);
        if ($nivel) {
            $nivel->update($data);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        // Implementação para deletar um nivel por ID
        $nivel = $this->getOne($id);
        if ($nivel) {
            $nivel->delete();
            return true;
        }
        return false;
    }
}
