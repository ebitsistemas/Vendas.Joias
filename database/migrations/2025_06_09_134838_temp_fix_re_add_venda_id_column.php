<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Esta migração apenas garante que a coluna 'venda_id' exista para a próxima migração usar.
        if (!Schema::hasColumn('vendas_pagamentos', 'venda_id')) {
            Schema::table('vendas_pagamentos', function (Blueprint $table) {
                // Adiciona a coluna 'venda_id' de volta, se ela não existir.
                $table->integer('venda_id')->nullable()->after('cliente_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // O método 'down' pode ficar vazio, pois a migração seguinte irá remover a coluna de qualquer forma.
    }
};
