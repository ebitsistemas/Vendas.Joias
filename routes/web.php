<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('cep/{cep}', [\App\Http\Controllers\HomeController::class, 'cep'])->name('cep');

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('store', 'store')->name('login.store');
    Route::post('logout', 'destroy')->name('login.destroy');
});


/* DASHBOARD */
Route::prefix('dashboard')->group(function () {
    Route::get('grafico', [\App\Http\Controllers\DashboardController::class, 'grafico'])->name('dashboard.grafico');
    Route::post('vendas', [\App\Http\Controllers\DashboardController::class, 'vendas'])->name('dashboard.vendas');
});

/* CONFIGURAÇÕES */
Route::prefix('configuracao')->group(function () {
    Route::get('', [\App\Http\Controllers\ConfiguracaoController::class, 'edit'])->name('config.editar');
    Route::get('show', [\App\Http\Controllers\ConfiguracaoController::class, 'show'])->name('config.visualizar');
    Route::post('update', [\App\Http\Controllers\ConfiguracaoController::class, 'update'])->name('config.update');
});


/* CLIENTES */
Route::prefix('cliente')->group(function () {
    Route::get('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.lista');
    Route::post('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.search');
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
    Route::post('', [\App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.search');
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
    Route::post('', [\App\Http\Controllers\GrupoController::class, 'index'])->name('grupo.search');
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
    Route::post('', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.search');
    Route::get('cadastrar', [\App\Http\Controllers\ProdutoController::class, 'create'])->name('produto.cadastrar');
    Route::get('editar/{id}', [\App\Http\Controllers\ProdutoController::class, 'edit'])->name('produto.editar');
    Route::get('show/{id}', [\App\Http\Controllers\ProdutoController::class, 'show'])->name('produto.visualizar');
    Route::get('buscar', [\App\Http\Controllers\ProdutoController::class, 'buscar'])->name('produto.buscar');
    Route::post('buscar', [\App\Http\Controllers\ProdutoController::class, 'buscar'])->name('produto.buscar');
    Route::post('store', [\App\Http\Controllers\ProdutoController::class, 'store'])->name('produto.store');
    Route::post('update', [\App\Http\Controllers\ProdutoController::class, 'update'])->name('produto.update');
    Route::post('delete', [\App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produto.delete');
    Route::post('ajax', [\App\Http\Controllers\ProdutoController::class, 'ajax'])->name('produto.ajax');
});

/* VENDAS */
Route::prefix('venda')->group(function () {
    Route::get('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.lista');
    Route::post('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.search');
    Route::get('cart', [\App\Http\Controllers\VendaController::class, 'cart'])->name('venda.cart');
    Route::get('nova', [\App\Http\Controllers\VendaController::class, 'create'])->name('venda.nova');
    Route::get('editar/{id}', [\App\Http\Controllers\VendaController::class, 'edit'])->name('venda.editar');
    Route::get('imprimir/{id}', [\App\Http\Controllers\VendaController::class, 'print'])->name('venda.print');
    Route::post('store', [\App\Http\Controllers\VendaController::class, 'store'])->name('venda.store');
    Route::post('update', [\App\Http\Controllers\VendaController::class, 'update'])->name('venda.update');
    Route::post('delete', [\App\Http\Controllers\VendaController::class, 'destroy'])->name('venda.delete');
    Route::post('ajax', [\App\Http\Controllers\VendaController::class, 'ajax'])->name('venda.ajax');
});

/* CARRINHO */
Route::prefix('carrinho')->group(function () {
    Route::get('', [\App\Http\Controllers\CarrinhoController::class, 'index'])->name('carrinho.index')->middleware('auth');
    Route::get('pedido/{id}', [\App\Http\Controllers\CarrinhoController::class, 'pedido'])->name('carrinho.pedido')->middleware('auth');
    Route::get('checkout/{id}', [\App\Http\Controllers\CarrinhoController::class, 'checkout'])->name('carrinho.checkout')->middleware('auth');

    Route::get('cliente/adicionar/{cliente_id}', [\App\Http\Controllers\CarrinhoController::class, 'clienteAdicionar'])->name('carrinho.cliente.adicionar')->middleware('auth');
    Route::get('cliente/remover/{cliente_id}', [\App\Http\Controllers\CarrinhoController::class, 'clienteRemover'])->name('carrinho.cliente.remover')->middleware('auth');

    Route::get('produto/adicionar/{produto_id}', [\App\Http\Controllers\CarrinhoController::class, 'produtoAdicionar'])->name('carrinho.produto.adicionar')->middleware('auth');
    Route::post('produto/cadastrar', [\App\Http\Controllers\CarrinhoController::class, 'produtoCadastrar'])->name('carrinho.produto.cadastrar')->middleware('auth');
    Route::post('produto/quantidade', [\App\Http\Controllers\CarrinhoController::class, 'produtoQuantidade'])->name('carrinho.produto.quantidade')->middleware('auth');
    Route::get('produto/remover/{item_id}', [\App\Http\Controllers\CarrinhoController::class, 'produtoRemover'])->name('carrinho.produto.remover')->middleware('auth');

    Route::post('fatura/adicionar', [\App\Http\Controllers\CarrinhoController::class, 'faturaAdicionar'])->name('carrinho.fatura.adicionar')->middleware('auth');
    Route::get('fatura/remover/{item_id}', [\App\Http\Controllers\CarrinhoController::class, 'faturaRemover'])->name('carrinho.fatura.remover')->middleware('auth');

    Route::post('update', [\App\Http\Controllers\CarrinhoController::class, 'update'])->name('carrinho.update');
});
