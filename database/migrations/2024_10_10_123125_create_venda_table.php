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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_venda')->nullable();
            $table->timestamp('previsao_entrega')->nullable();
            $table->timestamp('data_confirmacao')->nullable();
            $table->integer('cliente_id')->nullable();
            $table->double('desconto_itens', 10, 2)->nullable();
            $table->double('desconto_geral', 10, 2)->nullable();
            $table->double('desconto_total', 10, 2)->nullable();
            $table->double('outras_despesas', 10, 2)->nullable();
            $table->double('total_acrescimo', 10, 2)->nullable();
            $table->double('total_bruto', 10, 2)->nullable();
            $table->double('total_liquido', 10, 2)->nullable();
            $table->text('anotacoes')->nullable();
            $table->boolean('status')->default(1)->comment('2 - Bloqueado; 1 - Ativo; 0 - Inativo;');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
