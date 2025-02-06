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
        Schema::table('vendas_pagamentos', function (Blueprint $table) {
            $table->integer('tipo')->nullable()->after('id');
            $table->double('saldo')->nullable()->after('valor_subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas_pagamentos', function (Blueprint $table) {
            $table->integer('tipo');
            $table->integer('saldo');
        });
    }
};
