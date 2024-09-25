<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'categoria_id',
        'nome',
        'descricao',
        'status',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id', 'id');
    }

    public function categoria_pai()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'codigo', 'status');
    }
}
