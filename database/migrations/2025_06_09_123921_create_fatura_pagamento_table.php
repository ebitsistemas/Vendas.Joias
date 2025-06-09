<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fatura_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_pagamento_id')->constrained('vendas_pagamentos')->onDelete('cascade');
            $table->foreignId('fatura_item_id')->constrained('faturas_itens')->onDelete('cascade');
            $table->double('valor_aplicado');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatura_pagamento');
    }
};
