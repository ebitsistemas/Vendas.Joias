<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Adiciona a coluna 'venda_pagamento_id' em 'faturas_itens'
        if (!Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
            Schema::table('faturas_itens', function (Blueprint $table) {
                $table->foreignId('venda_pagamento_id')->nullable()->after('venda_id')->constrained('vendas_pagamentos');
            });
        }

        // Tenta vincular pagamentos antigos a faturas. Opcional, mas útil.
        // Esta lógica assume uma relação simples 1-para-1 ou similar nos dados antigos.
        $pagamentos = DB::table('vendas_pagamentos')->whereNotNull('venda_id')->get();
        foreach($pagamentos as $pagamento) {
            DB::table('faturas_itens')
                ->where('venda_id', $pagamento->venda_id)
                ->where('situacao', 1) // Onde a fatura foi marcada como paga
                ->whereNull('venda_pagamento_id') // E ainda não foi vinculada
                ->update(['venda_pagamento_id' => $pagamento->id]);
        }

        // 2. Remove a coluna 'venda_id' de 'vendas_pagamentos'
        if (Schema::hasColumn('vendas_pagamentos', 'venda_id')) {
            Schema::table('vendas_pagamentos', function (Blueprint $table) {
                $table->dropColumn('venda_id');
            });
        }
    }

    public function down(): void
    {
        // Apenas recria a coluna 'venda_id'
        if (!Schema::hasColumn('vendas_pagamentos', 'venda_id')) {
            Schema::table('vendas_pagamentos', function (Blueprint $table) {
                $table->integer('venda_id')->nullable();
            });
        }

        // Remove o vínculo
        if (Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
            Schema::table('faturas_itens', function (Blueprint $table) {
                $table->dropForeign(['venda_pagamento_id']);
                $table->dropColumn('venda_pagamento_id');
            });
        }
    }
};
