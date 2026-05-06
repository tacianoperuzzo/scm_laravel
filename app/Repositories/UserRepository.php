<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class UserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getOne(int $id): ? Model
    {
        return User::find($id);
    }

    public function create(array $data): Model
    {
        $userCreated = User::create([...$data, 'active'=>1]);
        if ($userCreated) {
            $userCreated->pessoa()->create([...$data['pessoa'], 'cpf' => $data['cpf']]);
        }
        return $userCreated;
    }

    public function update(int $id, array $data): bool
    {
        $user = User::find($id);
        $pessoa = $user->pessoa;
         if (!$user) {
            return false;
        }
        if (!$pessoa) {
            return false;
        }
        $user->update($data);
        $pessoa->update([...$data['pessoa'], 'cpf' => $data['cpf']]);
        return true;
    }

    public function updateStatus(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }
        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByCpfEmail(string $cpf, string $email): ? Model
    {
        return User::where('cpf', $cpf)->whereHas('pessoa', function ($query) use ($email) {
            $query->where('email', $email);
        })->first();
    }

    public function findByEmail(string $email): ? Model
    {
        return User::whereHas('pessoa', function ($query) use ($email) {
            $query->where('email', $email);
        })->first();
    }
}
