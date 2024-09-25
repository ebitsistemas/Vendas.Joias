<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_venda',
        'previsao_entrega',
        'data_confirmacao',
        'cliente_id',
        'cliente_tipo',
        'cliente_documento',
        'desconto_itens',
        'desconto_geral',
        'desconto_total',
        'outras_despesas',
        'total_acrescimo',
        'total_bruto',
        'total_liquido',
        'anotacoes',
        'status',
    ];
}
