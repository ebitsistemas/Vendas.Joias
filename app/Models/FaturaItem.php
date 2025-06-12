<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faturas_itens';

    protected $primaryKey = 'id';

    protected $fillable = [
        'venda_id',
        'venda_pagamento_id',
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
        'troco',
        'situacao',
        'status',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function pagamentos()
    {
        return $this->belongsToMany(VendaPagamento::class, 'fatura_pagamento', 'fatura_item_id', 'venda_pagamento_id')
            ->withPivot('valor_aplicado') // Informa ao Laravel sobre a coluna extra
            ->withTimestamps();
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
}
