<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturamentoSituacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faturamentos_situacoes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo',
        'nome',
        'permitido',
        'opcao',
        'cor',
        'status',
    ];

    public function status()
    {
        return $this->hasOne(Status::class, 'codigo', 'status');
    }
}
