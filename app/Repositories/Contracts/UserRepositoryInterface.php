<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends BaseInterface
{
    public function updateStatus(int $id, array $data): bool;
}
