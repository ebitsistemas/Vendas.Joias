<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo_pessoa',
        'nome',
        'documento',
        'rg',
        'sexo',
        'data_nascimento',
        'estado_civil',
        'nome_fantasia',
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
        'celular',
    ];
}
