<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Repositories\Contracts\CargoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CargoRepository implements CargoInterface
{
    public function getAll(): Collection
    {
        return Cargo::all();
    }

    public function getOne(int $id): Model
    {
        return Cargo::find($id);
    }
}
