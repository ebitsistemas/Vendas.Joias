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
        Schema::create('faturas_itens', function (Blueprint $table) {
            $table->id();
            $table->integer('venda_id')->nullable();
            $table->tinyInteger('tipo_pagamento')->nullable()->comment('0 - Pagamento à vista; 1 - Pagamento à prazo;');
            $table->string('forma_pagamento', 2)->nullable()->comment('01 - Dinheiro; 02 - Cheque; 03 - Cartão de Crédito; 04 - Cartão de Débito; 05 - Crédito Loja/Duplicata; DP: Depósito; TF: Transferência; 10 - Vale Alimentação; 11 - Vale Refeição; 12 - Vale Presente; 13 - Vale Combustível; 15 - Boleto Bancário; 90 - Sem Pagamento; 99 - Outros;');
            $table->double('valor_parcela', 10, 2)->nullable();
            $table->integer('numero_parcela')->nullable()->comment('Número da parcela atual;');
            $table->integer('total_parcelas')->default(1)->comment('Total de parcelas;');
            $table->integer('dias_parcelas')->nullable();
            $table->tinyInteger('tipo_juros')->nullable()->comment('1 - Por Parcela; 2 - Juros Total;');
            $table->double('valor_juros', 15, 2)->nullable()->comment('Juro aplicado ao parcelamento, em percentual;');
            $table->date('data_vencimento')->nullable();
            $table->timestamp('data_pagamento')->nullable();
            $table->double('valor_recebido', 15, 2)->nullable()->comment('Valor desta forma de pagamento;');
            $table->double('valor_subtotal', 15, 2)->nullable()->comment('Apenas informativo com o valor total do parcelamento;');
            $table->double('troco', 10, 2)->nullable();
            $table->boolean('situacao')->default(false)->comment('0 - Não pago; 1 - Pago; 2 - Cancelado; 3 - Reparcelado; 4 - Bonificado;');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas_itens');
    }
};
