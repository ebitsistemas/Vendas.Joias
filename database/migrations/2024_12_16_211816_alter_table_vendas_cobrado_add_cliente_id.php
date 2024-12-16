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
        Schema::table('vendas_cobrado', function (Blueprint $table) {
            $table->integer('cliente_id')->nullable()->after('venda_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas_cobrado', function (Blueprint $table) {
            $table->integer('cliente_id');
        });
    }
};
