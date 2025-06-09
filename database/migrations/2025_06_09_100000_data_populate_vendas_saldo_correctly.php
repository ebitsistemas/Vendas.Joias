<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Garante que a coluna 'saldo' exista antes de populá-la.
        if (!Schema::hasColumn('vendas', 'saldo')) {
            Schema::table('vendas', function (Blueprint $table) {
                $table->double('saldo')->nullable()->after('total_liquido');
            });
        }

        // 2. Itera sobre todas as vendas para calcular o saldo de cada uma.
        // Usamos um cursor para otimizar o uso de memória em caso de muitas vendas.
        foreach (DB::table('vendas')->cursor() as $venda) {

            // LÓGICA CORRIGIDA: Soma os pagamentos da tabela 'vendas_pagamentos'
            // que correspondam a esta venda, usando a estrutura antiga.
            $totalPago = DB::table('vendas_pagamentos')
                ->where('venda_id', $venda->id)
                ->sum('valor_recebido');

            $saldo = $venda->total_liquido - $totalPago;

            // Atualiza a venda com o saldo correto.
            DB::table('vendas')->where('id', $venda->id)->update(['saldo' => $saldo]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Ao reverter, apenas remove a coluna saldo, se existir.
        if (Schema::hasColumn('vendas', 'saldo')) {
            Schema::table('vendas', function (Blueprint $table) {
                $table->dropColumn('saldo');
            });
        }
    }
};
