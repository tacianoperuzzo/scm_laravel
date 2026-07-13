<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CargoInterface
{
    public function getAll(): Collection;

    public function getOne(int $id): ? Model;
}
