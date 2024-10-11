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
        if (!Schema::hasTable('produtos')) {
            Schema::create('produtos', function (Blueprint $table) {
                $table->id();
                $table->string('nome', 255)->nullable();
                $table->string('slug', 255)->nullable();
                $table->text('descricao')->nullable();
                $table->string('descricao_curta', 255)->nullable();
                $table->integer('unidade_id')->nullable();
                $table->integer('categoria_id')->nullable();
                $table->string('codigo_interno', 60)->nullable();
                $table->string('codigo_barras', 60)->nullable();
                $table->double('preco_custo', 10, 2)->nullable();
                $table->double('custos_adicionais', 10, 2)->nullable();
                $table->double('margem_lucro', 10, 2)->nullable();
                $table->double('comissao_venda', 10, 2)->nullable();
                $table->double('descontos', 10, 2)->nullable();
                $table->double('preco_venda_sugerido', 10, 2)->nullable();
                $table->double('preco_venda', 10, 2)->nullable();
                $table->text('imagem')->nullable();
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
        Schema::dropIfExists('produtos');
    }
};
