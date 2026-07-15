<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RelatorioServico extends Model
{
    protected $table = 'relatorio_servico';

    protected $guarded = ['id'];

    protected $dates = ['data_pos'];

    public function getDataPosAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('m/d/Y') : null;
    }

    public function getEscalasAttribute($value)
    {
        return $value ? trim(strip_tags($value)) : null;
    }

    public function getAlteracoesAttribute($value)
    {
        return $value ? trim(strip_tags($value)) : null;
    }

    public function getEquipamentosAttribute($value)
    {
        return $value ? trim(strip_tags($value)) : null;
    }

    public function getInstalacoesAttribute($value)
    {
        return $value ? trim(strip_tags($value)) : null;
    }

    // Adiciona o atributo nas conversões para array/json
    protected $appends = ['data_pre'];

    protected function dataPre(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => \Carbon\Carbon::createFromFormat('m-d-Y', "{$attributes['mes_dia']}-{$attributes['ano']}")->format('m/d/Y'),
        );
    }

    public static function generateNumber($ano)
    {
        return self::where('ano', $ano)->max('numero') + 1;
    }

}
