<?php

use Illuminate\Support\Facades\Route;


Route::get('', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('cep/{cep}', [\App\Http\Controllers\HomeController::class, 'cep'])->name('cep');


/* DASHBOARD */
Route::prefix('dashboard')->group(function () {
    Route::get('grafico', [\App\Http\Controllers\DashboardController::class, 'grafico'])->name('dashboard.grafico');
    Route::post('vendas', [\App\Http\Controllers\DashboardController::class, 'vendas'])->name('dashboard.vendas');
});

/* CLIENTES */
Route::prefix('cliente')->group(function () {
    Route::get('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.lista');
    Route::get('cadastrar', [\App\Http\Controllers\ClienteController::class, 'create'])->name('cliente.cadastrar');
    Route::get('editar/{id}', [\App\Http\Controllers\ClienteController::class, 'edit'])->name('cliente.editar');
    Route::get('show/{id}', [\App\Http\Controllers\ClienteController::class, 'show'])->name('cliente.visualizar');
    Route::get('buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('cliente.buscar');
    Route::post('buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('cliente.buscar');
    Route::post('store', [\App\Http\Controllers\ClienteController::class, 'store'])->name('cliente.store');
    Route::post('update', [\App\Http\Controllers\ClienteController::class, 'update'])->name('cliente.update');
    Route::post('delete', [\App\Http\Controllers\ClienteController::class, 'destroy'])->name('cliente.delete');
    Route::post('ajax', [\App\Http\Controllers\ClienteController::class, 'ajax'])->name('cliente.ajax');
});

/* CATEGORIA */
Route::prefix('categoria')->group(function () {
    Route::get('', [\App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.lista');
    Route::get('cadastrar', [\App\Http\Controllers\CategoriaController::class, 'create'])->name('categoria.cadastrar');
    Route::get('editar/{id}', [\App\Http\Controllers\CategoriaController::class, 'edit'])->name('categoria.editar');
    Route::post('store', [\App\Http\Controllers\CategoriaController::class, 'store'])->name('categoria.store');
    Route::post('update', [\App\Http\Controllers\CategoriaController::class, 'update'])->name('categoria.update');
    Route::post('delete', [\App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categoria.delete');
    Route::post('ajax', [\App\Http\Controllers\CategoriaController::class, 'ajax'])->name('categoria.ajax');
});

/* GRUPOS */
Route::prefix('grupo')->group(function () {
    Route::get('', [\App\Http\Controllers\GrupoController::class, 'index'])->name('grupo.lista');
    Route::get('cadastrar', [\App\Http\Controllers\GrupoController::class, 'create'])->name('grupo.cadastrar');
    Route::get('editar/{id}', [\App\Http\Controllers\GrupoController::class, 'edit'])->name('grupo.editar');
    Route::post('store', [\App\Http\Controllers\GrupoController::class, 'store'])->name('grupo.store');
    Route::post('update', [\App\Http\Controllers\GrupoController::class, 'update'])->name('grupo.update');
    Route::post('delete', [\App\Http\Controllers\GrupoController::class, 'destroy'])->name('grupo.delete');
    Route::post('ajax', [\App\Http\Controllers\GrupoController::class, 'ajax'])->name('grupo.ajax');
});

/* PRODUTOS */
Route::prefix('produto')->group(function () {
    Route::get('', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.lista');
    Route::get('cadastrar', [\App\Http\Controllers\ProdutoController::class, 'create'])->name('produto.cadastrar');
    Route::get('editar/{id}', [\App\Http\Controllers\ProdutoController::class, 'edit'])->name('produto.editar');
    Route::get('show/{id}', [\App\Http\Controllers\ProdutoController::class, 'show'])->name('produto.visualizar');
    Route::get('buscar', [\App\Http\Controllers\ProdutoController::class, 'buscar'])->name('produto.buscar');
    Route::post('store', [\App\Http\Controllers\ProdutoController::class, 'store'])->name('produto.store');
    Route::post('update', [\App\Http\Controllers\ProdutoController::class, 'update'])->name('produto.update');
    Route::post('delete', [\App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produto.delete');
    Route::post('ajax', [\App\Http\Controllers\ProdutoController::class, 'ajax'])->name('produto.ajax');
});

/* VENDAS */
Route::prefix('venda')->group(function () {
    Route::get('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.lista');
    Route::get('cart', [\App\Http\Controllers\VendaController::class, 'cart'])->name('venda.cart');
    Route::get('nova', [\App\Http\Controllers\VendaController::class, 'create'])->name('venda.nova');
    Route::get('editar/{id}', [\App\Http\Controllers\VendaController::class, 'edit'])->name('venda.editar');
    Route::get('show/{id}', [\App\Http\Controllers\VendaController::class, 'show'])->name('venda.visualizar');
    Route::post('store', [\App\Http\Controllers\VendaController::class, 'store'])->name('venda.store');
    Route::post('update', [\App\Http\Controllers\VendaController::class, 'update'])->name('venda.update');
    Route::post('delete', [\App\Http\Controllers\VendaController::class, 'destroy'])->name('venda.delete');
    Route::post('ajax', [\App\Http\Controllers\VendaController::class, 'ajax'])->name('venda.ajax');
});

/* VENDAS */
Route::prefix('carrinho')->group(function () {
    Route::get('', [\App\Http\Controllers\CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::get('cliente/adicionar/{id}', [\App\Http\Controllers\CarrinhoController::class, 'clienteAdicionar'])->name('carrinho.cliente.adicionar');
    Route::get('produto/adicionar/{id}', [\App\Http\Controllers\CarrinhoController::class, 'produtoAdicionar'])->name('carrinho.produto.adicionar');

    Route::get('checkout/{id}', [\App\Http\Controllers\CarrinhoController::class, 'checkout'])->name('carrinho.checkout');

    Route::get('editar/{id}', [\App\Http\Controllers\CarrinhoController::class, 'edit'])->name('venda.editar');
    Route::get('show/{id}', [\App\Http\Controllers\CarrinhoController::class, 'show'])->name('venda.visualizar');
    Route::post('store', [\App\Http\Controllers\CarrinhoController::class, 'store'])->name('venda.store');
    Route::post('update', [\App\Http\Controllers\CarrinhoController::class, 'update'])->name('venda.update');
    Route::post('delete', [\App\Http\Controllers\CarrinhoController::class, 'destroy'])->name('venda.delete');
    Route::post('ajax', [\App\Http\Controllers\CarrinhoController::class, 'ajax'])->name('venda.ajax');
});
