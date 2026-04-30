<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface OficioInterface extends BaseInterface
{
    public function getClone(int $id): ? Model;

    public function newPreview(int|null $id, array $data): ? Model;

    public function renderPDF(Model $oficio, ?string $path = null): string;

    public function deletePreview(string $path): bool;
}
