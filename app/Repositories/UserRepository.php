<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class UserRepository implements UserInterface
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
        $userCreated = User::create([...$data, 'password' => Str::random()]);
        return $userCreated;
    }

    public function update(int $id, array $data): Model|bool
    {
        $user = User::find($id);
         if ($user) {
            $user->update($data);
            return $user;
        }
        return false;
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
