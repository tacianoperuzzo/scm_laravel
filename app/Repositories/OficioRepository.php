<?php

namespace App\Repositories;

use App\Models\Oficio;
use App\Repositories\Contracts\OficioInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

class OficioRepository implements OficioInterface
{
    public function getAll(): Collection
    {
        return Oficio::all()->sortByDesc(['ano', 'numero']);
    }

    public function getOne(int $id): Model
    {
        return Oficio::find($id);
    }

    public function getClone(int $id): ? Model
    {
        $oficio = Oficio::find($id);
        if ($oficio) {
            $clone = $oficio->replicate()->fill([
                'id' => null,
                'data' => now(),
                'numero' => null,
                'ano' => date('Y'),
            ]);
            return $clone;
        }
        return null;
    }

    public function create(array $data): Model
    {
        $user = Auth::user();
        $data['created_by'] = $user->cpf;
        $data['updated_by'] = $user->cpf;
        $data['data'] = date('Y/m/d', strtotime($data['data']));
        $data['ano'] = date('Y', strtotime($data['data']));
        $data['numero'] = Oficio::generateNumber($data['ano']);
        return Oficio::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = Auth::user();
        $data['updated_by'] = $user->cpf;
        $data['data'] = date('Y/m/d', strtotime($data['data']));
        $oficio = $this->getOne($id);
        if ($oficio) {
            $oficio->update($data);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        return false;
    }

    public function newPreview(int|null $id, array $data): ? Model
    {
        $oficio = Oficio::find($id);
        if ($oficio) {
            $preview = $oficio->replicate()->fill($data);
        } else {
            $preview = new Oficio($data);
        }
        return $preview;
    }

    public function renderPDF(Model $oficio, ?string $path = null): string
    {
        $numero = $oficio->numero ?? now()->timestamp;
        $pdf = $path ?? "oficios/of_{$numero}_scm_{$oficio->ano}.pdf";
        $top = 42;
        $right = 20;
        $bottom = 20;
        $left = 20;

        Pdf::view('oficio.renderPDF', ['oficio' => $oficio])
            ->headerView('oficio.header')
            ->footerView('oficio.footer', ['oficio' => $oficio])
            ->format(Format::A4)
            ->margins($top, $right, $bottom, $left)
            ->disk('public')->save($pdf);

        return $pdf;
    }

    public function deletePreview(string $path): bool
    {
        $path = Str::replaceFirst('/storage', '', $path);
        return Storage::disk('public')->delete($path);
    }
}
