<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Situacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'situacoes';

    protected $primaryKey = 'id';

    public function status()
    {
        return $this->hasOne(Status::class, 'codigo', 'status');
    }
}
