<?php

namespace App\Repositories;

use App\Models\RelatorioServico;
use App\Repositories\Contracts\RelatorioServicoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class RelatorioServicoRepository implements RelatorioServicoInterface
{
    public function getAll(): Collection
    {

        return RelatorioServico::orderBy('ano','desc')->orderBy('numero','desc')->get();
    }

    public function getOne(int $id): ? Model
    {
        return RelatorioServico::find($id);
    }

    public function create(array $data): Model
    {
        if (!$data['numero']) {
            $data['numero'] = RelatorioServico::generateNumber($data['ano']);
        }
        $relatorioServicoCreated = RelatorioServico::create($data);
        return $relatorioServicoCreated;
    }

    public function update(int $id, array $data): Model|bool
    {
        $relatorioServico = RelatorioServico::find($id);
         if ($relatorioServico) {
            $relatorioServico->update($data);
            return $relatorioServico;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $relatorioServico = RelatorioServico::find($id);
        if ($relatorioServico) {
            return $relatorioServico->delete();
        }
        return false;
    }

}
