<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Adiciona a coluna 'saldo' na tabela 'vendas'
        Schema::table('vendas', function (Blueprint $table) {
            if (!Schema::hasColumn('vendas', 'saldo')) {
                $table->double('saldo')->nullable()->after('total_liquido');
            }
        });

        // 2. Adiciona a coluna 'venda_pagamento_id' em 'faturas_itens' para criar o novo vínculo
        Schema::table('faturas_itens', function (Blueprint $table) {
            if (!Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
                $table->foreignId('venda_pagamento_id')->nullable()->after('venda_id')->constrained('vendas_pagamentos');
            }
        });

        // 3. Remove a coluna 'venda_id' de 'vendas_pagamentos', que não é mais necessária
        Schema::table('vendas_pagamentos', function (Blueprint $table) {
            if (Schema::hasColumn('vendas_pagamentos', 'venda_id')) {
                // Em alguns sistemas de banco, pode ser necessário remover a chave estrangeira primeiro se ela existir.
                // $table->dropForeign(['venda_id']);
                $table->dropColumn('venda_id');
            }
        });
    }

    // O método down() reverte as alterações, para segurança
    public function down(): void
    {
        Schema::table('vendas_pagamentos', function (Blueprint $table) {
            if (!Schema::hasColumn('vendas_pagamentos', 'venda_id')) {
                $table->integer('venda_id')->nullable();
            }
        });

        Schema::table('faturas_itens', function (Blueprint $table) {
            if (Schema::hasColumn('faturas_itens', 'venda_pagamento_id')) {
                $table->dropForeign(['venda_pagamento_id']);
                $table->dropColumn('venda_pagamento_id');
            }
        });

        Schema::table('vendas', function (Blueprint $table) {
            if (Schema::hasColumn('vendas', 'saldo')) {
                $table->dropColumn('saldo');
            }
        });
    }
};
