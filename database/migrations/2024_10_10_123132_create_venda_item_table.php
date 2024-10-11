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
        if (!Schema::hasTable('vendas_itens')) {
            Schema::create('vendas_itens', function (Blueprint $table) {
                $table->id();
                $table->integer('venda_id')->nullable();
                $table->integer('produto_id')->nullable();
                $table->double('valor_unitario', 10, 2)->nullable();
                $table->double('quantidade', 10, 2)->nullable();
                $table->integer('tipo_desconto')->nullable();
                $table->double('valor_desconto_real', 10, 2)->nullable();
                $table->double('valor_desconto_percentual', 10, 2)->nullable();
                $table->double('valor_total', 10, 2)->nullable();
                $table->boolean('status')->default(1)->comment('2 - Bloqueado; 1 - Ativo; 0 - Inativo;');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas_itens');
    }
};
