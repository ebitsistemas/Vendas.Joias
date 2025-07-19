<?php

namespace App\Http\Controllers;

use App\Http\Utilities\Helper;
use App\Http\Utilities\Impressao80mm;
use App\Models\Cliente;
use App\Models\Configuracao;
use App\Models\FaturaItem;
use App\Models\Grupo;
use App\Models\Venda;
use App\Models\VendaPagamento;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $clientes = Cliente::where('status', 1)->orderBy('nome')->paginate($config->itens_pagina);
        } else {
            $model = Cliente::select('*');

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}%")
                    ->orWhere('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('documento', 'like', "%{$pesquisa}%")
                    ->orWhere('celular', 'like', "%{$pesquisa}%")
                    ->orWhere('telefone', 'like', "%{$pesquisa}%")
                    ->orWhere('email', 'like', "%{$pesquisa}%");
            });
            $clientes = $model->paginate($config->itens_pagina);
        }
        self::disable();
        return view('cliente.lista')->with(['clientes' => $clientes, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Search client.
     */
    public function buscar(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $clientes = Cliente::paginate($config->itens_pagina);
        } else {
            $model = Cliente::select('*');

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('documento', 'like', "%{$pesquisa}%")
                    ->orWhere('celular', 'like', "%{$pesquisa}%")
                    ->orWhere('telefone', 'like', "%{$pesquisa}%")
                    ->orWhere('email', 'like', "%{$pesquisa}%");
            });
            $clientes = $model->paginate($config->itens_pagina);
        }
        return view('cliente.buscar')->with([
            'method' => 'view',
            'clientes' => $clientes,
            'venda_id' => $request->venda_id,
            'pesquisa' => $pesquisa ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::all();
        return view('cliente.gerenciar')->with(['method' => 'store', 'grupos' => $grupos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $imagem = $file->get();
            $extension = $file->getClientOriginalExtension();
            $name = Auth::id().date('YmdHis').rand(1, 9999);
            $pathImg = "imagem/{$name}.{$extension}";
            Storage::disk('public')->put($pathImg, $imagem);
            $data['imagem'] = $pathImg;
        }
        $response = Cliente::create($data);

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('cliente');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::find($id);
        $grupos = Grupo::all();

        return view('cliente.gerenciar')->with(['method' => 'view', 'cliente' => $cliente, 'grupos' => $grupos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $config = Configuracao::first();
        $cliente = Cliente::find($id);
        $grupos = Grupo::all();

        return view('cliente.gerenciar')->with([
            'method' => 'update',
            'cliente' => $cliente,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function historico(string $id)
    {
        $config = Configuracao::first();
        $cliente = Cliente::find($id);
        $vendas = Venda::where('cliente_id', $id)->paginate($config->itens_pagina);

        $totais = [];
        $totais['saldo'] = 0;
        $totais['vendas'] = 0;
        $totais['faturas'] = 0;
        $vendasTotal = Venda::where('cliente_id', $id)->get();
        foreach ($vendasTotal as $venda) {
            if ($venda->status != 3) {
                $totais['saldo'] += $venda->saldo;
                $totais['vendas'] += $venda->total_liquido;
                $totais['faturas'] += ($venda->total_liquido - $venda->saldo);
            }
        }
        self::disable();

        return view('cliente.partials.historico')->with([
            'method' => 'update',
            'cliente' => $cliente,
            'vendas' => $vendas,
            'totais' => $totais,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $cliente = Cliente::find($request->id);
            if ($request->hasFile('imagem')) {
                $file = $request->file('imagem');
                $imagem = $file->get();
                $extension = $file->getClientOriginalExtension();
                $name = Auth::id() . date('YmdHis') . rand(1, 9999);
                $pathImg = "imagem/{$name}.{$extension}";
                Storage::disk('public')->put($pathImg, $imagem);
                $data['imagem'] = $pathImg;
            }
            $response = $cliente->update($data);

            if ($response) {
                toastr()->success('Registro alterado com sucesso!');
                return redirect()->to('cliente');
            }
        } catch (\Exception $e) {
            toastr()->error('Erro ao cadastrar registro: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = Cliente::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
    }

    public function imprimir(Request $request)
    {
        // --- PASSO 1: BUSCA DOS DADOS INICIAIS ---
        $config = Configuracao::first();
        $cliente = Cliente::find($request->id);

        if (!$cliente) {
            abort(404, 'Cliente não encontrado');
        }

        // --- PASSO 2: CALCULAR O SALDO TOTAL REAL (A "VERDADE ABSOLUTA") ---
        // Esta é a lógica que o seu painel de sistema usa e que provou ser a correta.
        $saldoTotalReal = 0;
        $vendasDoCliente = Venda::where('cliente_id', $request->id)
            ->where('status', '!=', 3) // Ignora vendas canceladas
            ->get();

        foreach ($vendasDoCliente as $venda) {
            $saldoTotalReal += $venda->saldo;
        }
        // A variável $saldoTotalReal agora contém o valor final correto da conta do cliente.

        // --- PASSO 3: OBTER A LISTA DE MOVIMENTAÇÕES PARA EXIBIR NO PDF ---
        // Pega a lista cronológica de todas as movimentações (vendas e pagamentos).
        $todasAsMovimentacoes = VendaPagamento::with('venda')
            ->where('cliente_id', $request->id)
            ->where('situacao', '!=', 3) // Ignora pagamentos de vendas canceladas
            ->get();

        // Ordena a lista pela data correta.
        $funcaoOrdenadora = function ($mov) {
            $dataPrincipal = optional($mov->venda)->data_venda ?? $mov->data_pagamento;
            return $dataPrincipal . '_' . $mov->id;
        };

        $movimentacoesOrdenadas = $todasAsMovimentacoes->sortBy($funcaoOrdenadora);

        // Separa apenas as últimas 20 movimentações para a impressão.
        $movimentacoesParaImprimir = ($movimentacoesOrdenadas->count() > 15)
            ? $movimentacoesOrdenadas->slice(-15) // Pega os últimos 20 itens
            : $movimentacoesOrdenadas; // Ou pega todos, se houver 20 ou menos


        // --- PASSO 4: CALCULAR O SALDO APENAS DESTAS MOVIMENTAÇÕES EXIBIDAS ---
        // Este loop calcula o balanço apenas dos itens que aparecerão na lista do PDF.
        $saldoDosItensImpressos = 0;
        foreach ($movimentacoesParaImprimir as $mov) {
            // Lógica final e corrigida, que ignora tipos inesperados como "saldo".
            if ($mov->tipo == 'venda') {
                $saldoDosItensImpressos += optional($mov->venda)->total_liquido ?? 0;
            } elseif ($mov->tipo == 'pagamento') {
                $saldoDosItensImpressos -= $mov->valor_recebido ?? 0;
            }
        }

        // --- PASSO 5: DETERMINAR O SALDO ANTERIOR POR DIFERENÇA ---
        // A mágica final: o saldo anterior é a diferença entre o total real e o saldo da lista.
        $saldoAnteriorFinal = $saldoTotalReal - $saldoDosItensImpressos;


        // --- PASSO FINAL: GERAR O PDF ---
        // Envia os dados corretos para a classe de impressão.
        $impressao = new Impressao80mm();
        $pdf = $impressao->saldo(
            $config,
            $movimentacoesParaImprimir, // A lista das últimas 20 movimentações
            $cliente,
            $saldoAnteriorFinal        // O saldo anterior calculado para a conta fechar
        );

        return response($pdf)->header('Content-Type', 'application/pdf')->header('filename', 'inline');
    }

    /* */
    public static function disable()
    {
        $clientesAtivos = Cliente::where('status', '1')->get();

        foreach ($clientesAtivos as $cliente) {
            $saldoVendas = Venda::where('cliente_id', $cliente->id)->sum('saldo');

            if ($saldoVendas == 0) {
                $cliente->update(['status' => '2']);
            }
        }
        self::atualizarStatusVendasQuitadas();
    }

    public static function atualizarStatusVendasQuitadas()
    {
        Venda::where('saldo', 0)
            ->where('status', '!=', '1')
            ->update(['status' => '1']);
    }
}
