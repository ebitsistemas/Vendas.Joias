<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo_pessoa',
        'nome',
        'documento',
        'rg',
        'sexo',
        'data_nascimento',
        'faturamento_mensal',
        'limite_credito',
        'anotacoes',
        'grupo_id',

        'cep',
        'logradouro',
        'numero',
        'complemento',
        'referencia',
        'bairro',
        'cidade',
        'codigo_ibge',
        'uf',

        'email',
        'telefone',
        'rede_social',
        'celular',

        'status'
    ];
}
