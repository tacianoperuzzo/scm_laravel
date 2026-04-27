<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Efetivo extends Model
{
    protected $table = 'efetivo';
    protected $guarded = ['id'];

    public function pessoa(): HasOne
    {
        return $this->hasOne(Pessoa::class);
    }
}
