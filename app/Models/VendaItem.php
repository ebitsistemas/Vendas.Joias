<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',
        'produto_id',
        'valor_unitario',
        'quantidade',
        'tipo_desconto',
        'valor_desconto_real',
        'valor_desconto_percentual',
        'valor_total',
        'status',
    ];
}
