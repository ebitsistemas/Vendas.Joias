<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'grupo_id',
        'status',
    ];

    public function grupo_pai()
    {
        return $this->hasOne(Grupo::class, 'id', 'grupo_id');
    }
}
