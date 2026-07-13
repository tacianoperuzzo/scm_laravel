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
        return $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Adiciona o atributo nas conversões para array/json
    protected $appends = ['data_pre'];

    protected function dataPre(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => \Carbon\Carbon::parse("{$attributes['ano']}-{$attributes['mes_dia']}")->format('d/m/Y'),
        );
    }

    public static function generateNumber($ano)
    {
        return self::where('ano', $ano)->max('numero') + 1;
    }

}
