<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'sigla',
        'nome',
        'descricao',
        'status',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'codigo', 'status');
    }
}
