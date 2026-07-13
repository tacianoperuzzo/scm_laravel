<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $guarded = ['id'];

    protected function numeroCompleto(): Attribute
    {
        return Attribute::get(fn () => str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '/' . $this->ano);
    }

    public function autor()
    {
        return Pessoa::where('cpf', $this->created_by)->value('nome');
    }

    public static function generateNumber($ano)
    {
        return self::where('ano', $ano)->max('numero') + 1;
    }

}
