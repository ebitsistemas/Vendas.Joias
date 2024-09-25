<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'unidade_id',
        'categoria_id',
        'codigo_barras',
        'descricao',
        'descricao_curta',
        'preco_custo',
        'custos_adicionais',
        'margem_lucro',
        'tributos',
        'comissao_venda',
        'descontos',
        'preco_venda_sugerido',
        'preco_venda',
        'imagem',
        'status',
    ];
}
