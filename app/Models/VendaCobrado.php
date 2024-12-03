<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendaCobrado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendas_cobrado';

    protected $fillable = [
        'venda_id',
        'mes',
        'status',
    ];
}
