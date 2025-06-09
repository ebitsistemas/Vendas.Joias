<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Executa as migrações.
     *
     * @return void
     */
    public function up()
    {
        // PARTE 1: Adicionar a coluna 'saldo' na tabela de vendas
        if (!Schema::hasColumn('vendas', 'saldo')) {
            Schema::table('vendas', function (Blueprint $table) {
                $table->double('saldo')->nullable()->after('total_liquido');
            });
        }

        // PARTE 2: Calcular o saldo correto para cada venda
        foreach (DB::table('vendas')->cursor() as $venda) {

            // LÓGICA FINAL E CORRETA: Soma o valor recebido da tabela 'faturas_itens'
            // onde a situação é '4' (o valor para "Pago" que descobrimos).
            $totalPago = DB::table('faturas_itens')
                ->where('venda_id', $venda->id)
                ->where('situacao', 4) // <-- A CORREÇÃO FINAL ESTÁ AQUI
                ->sum('valor_recebido');

            $saldo = $venda->total_liquido - $totalPago;

            // Atualiza a venda com o saldo correto.
            DB::table('vendas')->where('id', $venda->id)->update(['saldo' => $saldo]);
        }

        // PARTE 3: Preparar as tabelas para a NOVA lógica do sistema
        if (!Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
            Schema::table('faturas_itens', function (Blueprint $table) {
                $table->unsignedBigInteger('venda_pagamento_id')->nullable()->after('venda_id');
            });
        }
    }

    /**
     * Reverte as migrações.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('vendas', 'saldo')) {
            Schema::table('vendas', function (Blueprint $table) {
                $table->dropColumn('saldo');
            });
        }

        if (Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
            Schema::table('faturas_itens', function (Blueprint $table) {
                $table->dropColumn('venda_pagamento_id');
            });
        }
    }
};
