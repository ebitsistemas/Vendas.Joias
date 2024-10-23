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
        if (!Schema::hasTable('configuracoes')) {
            Schema::create('configuracoes', function (Blueprint $table) {
                $table->id();
                $table->string('nome', 60)->nullable();
                $table->string('descricao', 60)->nullable();
                $table->string('theme_color', 60)->nullable();
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
        Schema::dropIfExists('configuracao');
    }
};
