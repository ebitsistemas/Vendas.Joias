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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('tipo_pessoa')->nullable()->comment('1 - Pessoa Física; 2 - Pessoa Jurídica;');
            $table->string('nome', 60)->nullable();
            $table->string('documento', 18)->nullable()->comment('O Documento devera ser salvo com sua mascara.');
            $table->string('rg', 20)->nullable();
            $table->tinyInteger('sexo')->nullable()->comment('	1 - Feminino; 2 - Masculino;');
            $table->date('data_nascimento')->nullable();
            $table->double('faturamento_mensal', 10, 2)->nullable();
            $table->double('limite_credito', 10, 2)->nullable();
            $table->integer('grupo_id')->nullable();
            $table->string('anotacoes', 1000)->nullable();

            $table->string('cep', 9)->nullable()->comment('Máscara xxxxx-xxx');
            $table->string('logradouro', 60)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro', 60)->nullable();
            $table->string('cidade', 60)->nullable();
            $table->string('uf', 2)->nullable();

            $table->string('email')->nullable();
            $table->string('telefone', 14)->nullable()->comment('Máscara (xx) xxxx-xxxx');
            $table->string('celular', 15)->nullable()->comment('Máscara (xx) xxxxx-xxxx');
            $table->string('rede_social')->nullable();
            $table->text('imagem')->nullable();

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
        Schema::dropIfExists('cliente');
    }
};
