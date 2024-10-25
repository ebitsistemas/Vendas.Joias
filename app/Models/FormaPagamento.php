<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaPagamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'formas_pagamentos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo',
        'nome',
        'icone',
        'tipo_pagamento',
        'status',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'codigo', 'status');
    }
}
