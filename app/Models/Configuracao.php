<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuracao extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'configuracoes';

    protected $fillable = [
        'tipo_pessoa',
        'nome',
        'documento',
        'rg',

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
        'imagem',

        'itens_pagina',
        'inativar_cadastro',
        'theme_color',

        'status',
    ];
}
