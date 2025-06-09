<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('cep/{cep}', [\App\Http\Controllers\HomeController::class, 'cep'])->name('cep')->middleware('auth');

/* LOGIN */
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('store', 'store')->name('login.store');

    Route::get('lembrar/senha', 'forgot')->name('login.forgot');
    Route::post('forgot-password', 'forgot')->name('login.forgot');

    Route::post('logout', 'destroy')->name('login.destroy');
});

/* LEMBRAR SENHA */
Route::get('/reset-password/{token}', function (string $token) {
    return view('login.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (\App\Models\User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
/* LEMBRAR SENHA */

Route::get('', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

/* DASHBOARD */
Route::prefix('dashboard')->group(function () {
    Route::get('', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
    Route::get('grafico', [\App\Http\Controllers\DashboardController::class, 'grafico'])->name('dashboard.grafico')->middleware('auth');
    Route::post('vendas', [\App\Http\Controllers\DashboardController::class, 'vendas'])->name('dashboard.vendas')->middleware('auth');
});

/* CONFIGURAÇÕES */
Route::prefix('configuracao')->group(function () {
    Route::get('', [\App\Http\Controllers\ConfiguracaoController::class, 'edit'])->name('config.editar')->middleware('auth');
    Route::get('show', [\App\Http\Controllers\ConfiguracaoController::class, 'show'])->name('config.visualizar')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\ConfiguracaoController::class, 'update'])->name('config.update')->middleware('auth');
});

/* CLIENTES */
Route::prefix('cliente')->group(function () {
    Route::get('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\ClienteController::class, 'index'])->name('cliente.search')->middleware('auth');
    Route::get('cadastrar', [\App\Http\Controllers\ClienteController::class, 'create'])->name('cliente.cadastrar')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\ClienteController::class, 'edit'])->name('cliente.editar')->middleware('auth');
    Route::get('historico/{id}', [\App\Http\Controllers\ClienteController::class, 'historico'])->name('cliente.historico')->middleware('auth');
    Route::get('show/{id}', [\App\Http\Controllers\ClienteController::class, 'show'])->name('cliente.visualizar')->middleware('auth');
    Route::get('imprimir/{id}', [\App\Http\Controllers\ClienteController::class, 'imprimir'])->name('cliente.imprimir')->middleware('auth');
    Route::get('buscar/{venda_id}', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('cliente.buscar')->middleware('auth');
    Route::post('buscar/{venda_id}', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('cliente.buscar')->middleware('auth');
    Route::post('store', [\App\Http\Controllers\ClienteController::class, 'store'])->name('cliente.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\ClienteController::class, 'update'])->name('cliente.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\ClienteController::class, 'destroy'])->name('cliente.delete')->middleware('auth');

    Route::get('disable', [\App\Http\Controllers\ClienteController::class, 'disable'])->name('cliente.disable');
});

/* CATEGORIA */
Route::prefix('categoria')->group(function () {
    Route::get('', [\App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.search')->middleware('auth');
    Route::get('cadastrar', [\App\Http\Controllers\CategoriaController::class, 'create'])->name('categoria.cadastrar')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\CategoriaController::class, 'edit'])->name('categoria.editar')->middleware('auth');
    Route::post('store', [\App\Http\Controllers\CategoriaController::class, 'store'])->name('categoria.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\CategoriaController::class, 'update'])->name('categoria.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categoria.delete')->middleware('auth');
});

/* GRUPOS */
Route::prefix('grupo')->group(function () {
    Route::get('', [\App\Http\Controllers\GrupoController::class, 'index'])->name('grupo.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\GrupoController::class, 'index'])->name('grupo.search')->middleware('auth');
    Route::get('cadastrar', [\App\Http\Controllers\GrupoController::class, 'create'])->name('grupo.cadastrar')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\GrupoController::class, 'edit'])->name('grupo.editar')->middleware('auth');
    Route::post('store', [\App\Http\Controllers\GrupoController::class, 'store'])->name('grupo.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\GrupoController::class, 'update'])->name('grupo.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\GrupoController::class, 'destroy'])->name('grupo.delete')->middleware('auth');
});

/* PRODUTOS */
Route::prefix('produto')->group(function () {
    Route::get('', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.search')->middleware('auth');
    Route::get('cadastrar', [\App\Http\Controllers\ProdutoController::class, 'create'])->name('produto.cadastrar')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\ProdutoController::class, 'edit'])->name('produto.editar')->middleware('auth');
    Route::get('show/{id}', [\App\Http\Controllers\ProdutoController::class, 'show'])->name('produto.visualizar')->middleware('auth');
    Route::get('buscar/{venda_id}', [\App\Http\Controllers\ProdutoController::class, 'buscar'])->name('produto.buscar')->middleware('auth');
    Route::post('buscar', [\App\Http\Controllers\ProdutoController::class, 'buscar'])->name('produto.buscar')->middleware('auth');
    Route::post('store', [\App\Http\Controllers\ProdutoController::class, 'store'])->name('produto.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\ProdutoController::class, 'update'])->name('produto.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produto.delete')->middleware('auth');
});

/* VENDAS */
Route::prefix('venda')->group(function () {
    Route::get('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.search')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\VendaController::class, 'edit'])->name('venda.editar')->middleware('auth');
    Route::get('imprimir/{id}', [\App\Http\Controllers\VendaController::class, 'print'])->name('venda.print');
    Route::get('comprovante/{id}', [\App\Http\Controllers\VendaController::class, 'payment'])->name('venda.payment');
    Route::post('store', [\App\Http\Controllers\VendaController::class, 'store'])->name('venda.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\VendaController::class, 'update'])->name('venda.update')->middleware('auth');
    Route::post('baixar/faturas', [\App\Http\Controllers\VendaController::class, 'baixar'])->name('venda.baixar.faturas')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\VendaController::class, 'destroy'])->name('venda.delete')->middleware('auth');

    Route::get('status', [\App\Http\Controllers\VendaController::class, 'status'])->name('venda.status');
    Route::get('cadastrar', [\App\Http\Controllers\VendaController::class, 'index'])->name('venda.cadastrar')->middleware('auth');
    Route::post('cobrado', [\App\Http\Controllers\VendaController::class, 'cobrado'])->name('venda.cobrado')->middleware('auth');
});

/* FATURAS */
Route::prefix('fatura')->group(function () {
    Route::get('imprimir/{id}', [\App\Http\Controllers\FaturaController::class, 'print'])->name('fatura.print');
    Route::get('pagar/{id}', [\App\Http\Controllers\FaturaController::class, 'pagar'])->name('fatura.pagar');
    Route::post('update', [\App\Http\Controllers\FaturaController::class, 'update'])->name('fatura.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\FaturaController::class, 'destroy'])->name('fatura.destroy')->middleware('auth');
});

/* PAGAMENTOS */
Route::prefix('pagamentos')->group(function () {
    Route::post('', [\App\Http\Controllers\PagamentoController::class, 'index'])->name('pagamentos');
    Route::post('processar', [\App\Http\Controllers\PagamentoController::class, 'processarPagamentoFifo'])->name('pagamentos.processar');
    Route::post('delete', [\App\Http\Controllers\PagamentoController::class, 'reverterPagamento'])->name('pagamentos.reverter');
});

/* RELATÓRIOS */
Route::prefix('relatorio')->group(function () {
    Route::get('', function () {
        return redirect()->route('dashboard.index');
    })->middleware('auth');

    Route::get('cliente', [\App\Http\Controllers\RelatorioController::class, 'cliente'])->name('relatorio.cliente')->middleware('auth');
    Route::post('cliente', [\App\Http\Controllers\RelatorioController::class, 'cliente'])->name('relatorio.cliente')->middleware('auth');

    Route::get('financeiro', [\App\Http\Controllers\RelatorioController::class, 'financeiro'])->name('relatorio.financeiro')->middleware('auth');
    Route::post('financeiro', [\App\Http\Controllers\RelatorioController::class, 'financeiro'])->name('relatorio.financeiro')->middleware('auth');

    Route::get('periodo', [\App\Http\Controllers\RelatorioController::class, 'periodo'])->name('relatorio.periodo')->middleware('auth');
    Route::post('periodo', [\App\Http\Controllers\RelatorioController::class, 'periodo'])->name('relatorio.periodo')->middleware('auth');

    Route::get('venda', [\App\Http\Controllers\RelatorioController::class, 'venda'])->name('relatorio.venda')->middleware('auth');
    Route::post('venda', [\App\Http\Controllers\RelatorioController::class, 'venda'])->name('relatorio.venda')->middleware('auth');
});

/* USUÁRIO */
Route::prefix('usuario')->group(function () {
    Route::get('', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.lista')->middleware('auth');
    Route::post('', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.search')->middleware('auth');
    Route::get('cadastrar', [\App\Http\Controllers\UsuarioController::class, 'create'])->name('usuario.cadastrar')->middleware('auth');
    Route::get('editar/{id}', [\App\Http\Controllers\UsuarioController::class, 'edit'])->name('usuario.editar')->middleware('auth');
    Route::get('show/{id}', [\App\Http\Controllers\UsuarioController::class, 'show'])->name('usuario.visualizar')->middleware('auth');
    Route::post('store', [\App\Http\Controllers\UsuarioController::class, 'store'])->name('usuario.store')->middleware('auth');
    Route::post('update', [\App\Http\Controllers\UsuarioController::class, 'update'])->name('usuario.update')->middleware('auth');
    Route::post('delete', [\App\Http\Controllers\UsuarioController::class, 'destroy'])->name('usuario.delete')->middleware('auth');
});

/* CARRINHO */
Route::prefix('carrinho')->group(function () {
    Route::get('', [\App\Http\Controllers\CarrinhoController::class, 'index'])->name('carrinho.index')->middleware('auth');
    Route::get('pedido/{id}', [\App\Http\Controllers\CarrinhoController::class, 'pedido'])->name('carrinho.pedido')->middleware('auth');

    Route::get('cliente/adicionar/{venda_id}/{cliente_id}', [\App\Http\Controllers\CarrinhoController::class, 'clienteAdicionar'])->name('carrinho.cliente.adicionar')->middleware('auth');
    Route::get('cliente/remover/{venda_id}', [\App\Http\Controllers\CarrinhoController::class, 'clienteRemover'])->name('carrinho.cliente.remover')->middleware('auth');

    Route::get('produto/adicionar/{venda_id}/{produto_id}', [\App\Http\Controllers\CarrinhoController::class, 'produtoAdicionar'])->name('carrinho.produto.adicionar')->middleware('auth');
    Route::post('produto/cadastrar', [\App\Http\Controllers\CarrinhoController::class, 'produtoCadastrar'])->name('carrinho.produto.cadastrar')->middleware('auth');
    Route::post('produto/quantidade', [\App\Http\Controllers\CarrinhoController::class, 'produtoQuantidade'])->name('carrinho.produto.quantidade')->middleware('auth');
    Route::get('produto/remover/{venda_id}/{item_id}', [\App\Http\Controllers\CarrinhoController::class, 'produtoRemover'])->name('carrinho.produto.remover')->middleware('auth');

    Route::post('fatura/adicionar', [\App\Http\Controllers\CarrinhoController::class, 'faturaAdicionar'])->name('carrinho.fatura.adicionar')->middleware('auth');
    Route::get('fatura/remover/{venda_id}/{item_id}', [\App\Http\Controllers\CarrinhoController::class, 'faturaRemover'])->name('carrinho.fatura.remover')->middleware('auth');

    Route::post('update', [\App\Http\Controllers\CarrinhoController::class, 'update'])->name('carrinho.update')->middleware('auth');
});
