<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserInterface extends BaseInterface
{
    public function updateStatus(int $id, array $data): bool;

    public function findByCpfEmail(string $cpf, string $email): ? Model;
}
