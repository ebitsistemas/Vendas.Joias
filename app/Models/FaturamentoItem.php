<?php

namespace App\Models;

use App\Models\Global\BandeiraCartao;
use App\Models\Global\DocumentoTipo;
use App\Models\Global\FaturamentoTipo;
use App\Models\FormaPagamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturamentoItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faturamentos_itens';

    protected $primaryKey = 'id';

    protected $fillable = [
        'faturamento_id',
        'faturamento_fk',
        'tabela_fk',
        'tipo_operacao',
        'local',
        'categoria_id',
        'plano_conta_id',
        'conta_id',
        'caixa_id',
        'tipo_pagamento',
        'tipo_ocorrencia',
        'forma_recorrencia',
        'quantidade_recorrencia',
        'recorrencia_situacao',
        'recorrencia_atual',
        'forma_pagamento',
        'bandeira_cartao',
        'valor_parcela',
        'numero_parcela',
        'total_parcelas',
        'dias_parcelas',
        'tipo_juros',
        'valor_juros',
        'referencia',
        'data_vencimento',
        'data_pagamento',
        'valor_recebido',
        'valor_subtotal',
        'troco',
        'situacao',
        'status',
    ];

    public function bandeiraCartao()
    {
        return $this->hasOne(BandeiraCartao::class, 'id', 'bandeira_cartao');
    }

    public function categoria()
    {
        return $this->hasOne(Grupo::class, 'id', 'categoria_id');
    }

    public function caixa()
    {
        return $this->hasOne(Caixa::class, 'id', 'caixa_id');
    }

    public function formaPagamento()
    {
        return $this->hasOne(FormaPagamento::class, 'codigo', 'forma_pagamento');
    }

    public function faturamentoTipos()
    {
        return $this->hasOne(FaturamentoTipo::class, 'codigo', 'tipo_pagamento');
    }

    public function conta()
    {
        return $this->hasOne(Conta::class, 'id', 'conta_id');
    }

    public function planoConta()
    {
        return $this->hasOne(PlanoConta::class, 'id', 'plano_conta_id');
    }

    public function operacaoTipo()
    {
        return $this->hasOne(DocumentoTipo::class, 'codigo', 'tipo_operacao');
    }

    public function situacaoFatura()
    {
        return $this->hasOne(FaturamentoSituacao::class, 'codigo', 'situacao');
    }
}
