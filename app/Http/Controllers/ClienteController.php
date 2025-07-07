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
            $somaFaturas = FaturaItem::where('venda_id', $venda->id)->sum('valor_subtotal');
            if ($venda->status != 3) {
                $totais['saldo'] += $venda->saldo;
                $totais['vendas'] += $venda->total_liquido;
                $totais['faturas'] += $somaFaturas;
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
        // --- PARTE 1: BUSCA DE DADOS ---
        $config = Configuracao::first();
        $cliente = Cliente::find($request->id);

        if (!$cliente) {
            abort(404, 'Cliente não encontrado');
        }

        // 1. Busca TODAS as movimentações do cliente.
        $todasAsMovimentacoes = VendaPagamento::with('venda')
            ->where('cliente_id', $request->id)
            ->where('situacao', '!=', 3)
            ->where('created_at', '>=', date('2025-02-07'))
            ->get();

        $funcaoOrdenadora = function ($mov) {
            $dataPrincipal = optional($mov->venda)->data_venda ?? $mov->data_pagamento;
            return $dataPrincipal . '_' . $mov->id;
        };

        // --- PARTE 2: LÓGICA DE CÁLCULO E SEPARAÇÃO ---

        // 2. Ordena TODAS as movimentações da mais antiga para a mais nova.
        $movimentacoesOrdenadas = $todasAsMovimentacoes->sortBy($funcaoOrdenadora);

        $saldoAnteriorMais20 = 0.00;
        $movimentacoesParaImprimir = collect();

        // 3. Verifica se o total excede 20 para então separar os grupos.
        if ($movimentacoesOrdenadas->count() > 20) {

            // Separa as mais antigas (todas exceto as últimas 20).
            $movimentacoesAntigas = $movimentacoesOrdenadas->slice(0, -20);

            // Separa as mais recentes (as últimas 20) que serão listadas.
            $movimentacoesParaImprimir = $movimentacoesOrdenadas->slice(-20);

            // 4. CALCULA O SALDO das movimentações antigas.
            foreach ($movimentacoesAntigas as $mov) {
                // Regra: Venda aumenta a dívida, Pagamento diminui.
                if ($mov->tipo == 'venda') {
                    $saldoAnteriorMais20 += optional($mov->venda)->total_liquido ?? 0;
                } else {
                    $saldoAnteriorMais20 -= $mov->valor_recebido ?? 0;
                }
            }

        } else {
            // Se houver 20 ou menos, não há saldo anterior e todas serão impressas.
            $saldoAnteriorMais20 = 0.00;
            $movimentacoesParaImprimir = $movimentacoesOrdenadas;
        }


        // --- PARTE 3: GERAR O PDF ---
        $impressao = new Impressao80mm();

        // 5. Passa o saldo calculado e a lista das 20 para a impressão.
        $pdf = $impressao->saldo(
            $config,
            $movimentacoesParaImprimir,
            $cliente,
            $saldoAnteriorMais20 // O resultado do cálculo das mais antigas.
        );

        return response($pdf)->header('Content-Type', 'application/pdf')->header('filename', 'inline');
    }

    /* */
    public static function disable()
    {
        $clientes = Cliente::where('status', '1')->get();

        foreach ($clientes as $cliente) {
            $vendas = Venda::where('cliente_id', $cliente->id)
                ->where('status', 0)
                ->first();

            if (empty($vendas)) {
                $modelCliente = Cliente::find($cliente->id);
                $modelCliente->update(['status' => '2']);
            }
        }
    }
}
