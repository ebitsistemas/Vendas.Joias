<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'slug',
        'grupo_id',
        'unidade_id',
        'categoria_id',
        'codigo_interno',
        'codigo_barras',
        'descricao',
        'descricao_curta',
        'preco_custo',
        'custos_adicionais',
        'margem_lucro',
        'comissao_venda',
        'descontos',
        'preco_venda_sugerido',
        'preco_venda',
        'imagem',
        'status',
    ];

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function unidade()
    {
        return $this->hasOne(Unidade::class, 'id', 'unidade_id');
    }
}
