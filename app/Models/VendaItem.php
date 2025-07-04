<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendaItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendas_itens';

    protected $fillable = [
        'venda_id',
        'produto_id',
        'produto_nome',
        'valor_unitario',
        'quantidade',
        'tipo_desconto',
        'valor_desconto_real',
        'valor_desconto_percentual',
        'valor_total',
        'status',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
