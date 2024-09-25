<?php

use Illuminate\Support\Facades\Route;


Route::get('', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* DASHBOARD */
Route::prefix('dashboard')->group(function () {
    Route::get('grafico', [\App\Http\Controllers\DashboardController::class, 'grafico'])->name('dashboard.grafico');
    Route::post('vendas', [\App\Http\Controllers\DashboardController::class, 'vendas'])->name('dashboard.vendas');
});

/* CLIENTES */
Route::prefix('cliente')->group(function () {
    Route::get('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.lista');
    Route::get('cadastrar', [\App\Http\Controllers\ClienteController::class, 'create'])->name('cliente.cadastrar');
    Route::post('store', [\App\Http\Controllers\ClienteController::class, 'store'])->name('cliente.store');
    Route::post('ajax', [\App\Http\Controllers\ClienteController::class, 'ajax'])->name('cliente.ajax');
});

/* PRODUTOS */
Route::prefix('produto')->group(function () {
    Route::get('', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.lista');
});

/* VENDAS */
Route::prefix('venda')->group(function () {
    Route::get('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.lista');
});
