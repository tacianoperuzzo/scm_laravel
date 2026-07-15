<?php

namespace App\Repositories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PessoaRepository
{
    public function getAll(): Collection
    {
        // Implementação para obter todos
        return Pessoa::all();
    }

    public function getOne(int $id): ? Model
    {
        // Implementação para obter um
        return Pessoa::find($id);
    }

    public function create(array $data): Model
    {
        // Implementação para criar um
        $pessoa = Pessoa::create($data);
        $this->moveFileToStorage($pessoa->foto_url);
        return $pessoa;
    }

    public function update(int $id, array $data): bool
    {
        // Implementação para atualizar um
        $pessoa = $this->getOne($id);
        if ($pessoa) {
            $pessoa->update($data);
            $this->moveFileToStorage($pessoa->foto_url);
            return true;
        }
        return false;
    }

    private function moveFileToStorage(string | null $filePath): bool
    {
        // Implementação para mover o arquivo para o storage
        if ($filePath && Storage::disk('local')->exists($filePath)) {
            Storage::disk('public')->writeStream($filePath, Storage::disk('local')->readStream($filePath));
            Storage::disk('local')->delete($filePath);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $pessoa = $this->getOne($id);
        if ($pessoa) {
            $pessoa->delete();
            return true;
        }
        return false;
    }

    public function findByCpf(string $cpf): ? Model
    {
        return Pessoa::where('cpf', $cpf)->first();
    }
}
