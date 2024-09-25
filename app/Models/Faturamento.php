<?php

namespace App\Models;

use App\Models\Global\FaturamentoTipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faturamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo',
        'faturamento_id',
        'cliente_id',
        'desconto_total',
        'total_acrescimo',
        'outras_despesas',
        'total_bruto',
        'total_liquido',
        'descricao',
        'data_faturamento',
        'data_confirmacao',
        'situacao',
        'status',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function situacaoFaturamento()
    {
        return $this->hasOne(FaturamentoSituacao::class, 'codigo', 'situacao');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'codigo', 'status');
    }

    public function itens()
    {
        return $this->hasMany(FaturamentoItem::class, 'faturamento_id', 'id');
    }
}
