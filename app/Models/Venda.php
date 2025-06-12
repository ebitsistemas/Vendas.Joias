<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use HasFactory, SoftDeletes;

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
        'saldo',
        'anotacoes',
        'user_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_venda' => 'datetime', // Isso converte a string do banco para um objeto Carbon
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function faturas()
    {
        return $this->hasMany(FaturaItem::class, 'venda_id', 'id');
    }

    public function itens()
    {
        return $this->hasMany(VendaItem::class, 'venda_id', 'id');
    }

    public function situacao()
    {
        return $this->hasOne(Situacao::class, 'codigo', 'status');
    }
}
