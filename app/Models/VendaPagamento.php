<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendaPagamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendas_pagamentos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
        'cliente_id',
        'venda_id',
        'tipo_pagamento',
        'forma_pagamento',
        'valor_parcela',
        'numero_parcela',
        'total_parcelas',
        'dias_parcelas',
        'tipo_juros',
        'valor_juros',
        'data_vencimento',
        'data_pagamento',
        'valor_recebido',
        'valor_subtotal',
        'saldo',
        'troco',
        'situacao',
        'status',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id', 'id');
    }

    public function formaPagamento()
    {
        return $this->hasOne(FormaPagamento::class, 'codigo', 'forma_pagamento');
    }

    public function faturamentoTipos()
    {
        return $this->hasOne(FaturaTipo::class, 'codigo', 'tipo_pagamento');
    }

    public function situacaoFatura()
    {
        return $this->hasOne(FaturaSituacao::class, 'codigo', 'situacao');
    }

    /**
     * Define a relação onde um Pagamento pode ter quitado várias Faturas.
     * Este é o método que está em falta.
     */
    public function faturasQuitadas()
    {
        return $this->hasMany(FaturaItem::class);
    }
}
