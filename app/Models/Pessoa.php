<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pessoa extends Model
{
    protected $table = 'pessoas';

    protected $guarded = ['id'];

    protected $dates = ['nascimento', 'data_entrada', 'data_saida'];

    protected $appends = ['foto'];

    public function getNascimentoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getDataEntradaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getDataSaidaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getFotoAttribute($value)
    {
        return $this->foto_url ? (Storage::disk('public')->exists($this->foto_url) ? asset('storage/' . $this->foto_url) : asset('assets/no-image.png')) : null;
    }

}
