<?php

namespace App\Http\Controllers;

use App\Http\Utilities\Helper;
use App\Models\Situacao;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\FaturaItem;
use App\Models\Configuracao;
use App\Models\VendaCobrado;
use App\Models\VendaItem;
use App\Models\VendaPagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Utilities\Impressao80mm;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produtos = Produto::all();
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $vendas = Venda::orderBy('id', 'desc')->paginate($config->itens_pagina);
        } else {
            $model = Venda::select('*');

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('total_liquido', 'like', "%{$pesquisa}%")
                    ->orWhere('cliente_documento', 'like', "%{$pesquisa}%")
                    ->orWhere('data_venda', 'like', "%{$pesquisa}%")
                    ->orWhere('anotacoes', 'like', "%{$pesquisa}%");
            });
            $vendas = $model->orderBy('id', 'desc')->paginate($config->itens_pagina);
        }
        return view('venda.lista')->with(['vendas' => $vendas, 'produtos' => $produtos, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $situacoes = Situacao::where('status', 1)->get();
        $venda = Venda::find($request->id);

        return view('carrinho.index')->with(['method' => 'update', 'venda' => $venda, 'situacoes' => $situacoes]);
    }

    public function print(Request $request)
    {
        $config = Configuracao::first();

        $model = Venda::with([
            'itens',
            'cliente',
            'faturas',
            'situacao',
        ]);
        $venda = $model->find($request->id);

        $impressao = new Impressao80mm();
        $pdf = $impressao->cupom($config, $venda);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }

    public function payment(Request $request)
    {
        $config = Configuracao::first();

        $fatura = FaturaItem::find($request->id);

        $model = Venda::with([
            'itens',
            'cliente',
            'faturas',
            'situacao',
        ]);
        $venda = $model->find($fatura->venda_id);

        $totalPago = FaturaItem::where('venda_id', $fatura->venda_id)->sum('valor_subtotal');

        $impressao = new Impressao80mm();
        $pdf = $impressao->pagamento($config, $venda, $fatura, $totalPago);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function baixar(Request $request)
    {
        try {
            DB::beginTransaction();

            $vendas = Venda::where('cliente_id', $request->cliente_id)
                ->where('status', 0)
                ->get();

            $valorRecebido = str_replace('.', '', $request->valor_recebido);
            $valorRecebido = floatval(str_replace(',', '.', $valorRecebido));
            if (empty($request->data_pagamento) OR $request->data_pagamento == '1970-01-01' OR $request->data_pagamento == '01/01/1970') {
                $dataPagamento = Carbon::now()->format('Y-m-d');
            } else {
                $dataPagamento = Carbon::createFromFormat('d/m/Y', $request->data_pagamento)->format('Y-m-d');
            }

            $this->saldoAnterior($request->cliente_id, $request->tipo_pagamento);

            $now = Carbon::now()->format('Y-m-d H:i:s');
            $created = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');

            $pagamentoAnterior = VendaPagamento::where('cliente_id', $request->cliente_id)
                ->where('tipo_pagamento', $request->tipo_pagamento)
                ->where('forma_pagamento', $request->forma_pagamento)
                ->where('valor_parcela', $valorRecebido)
                ->whereBetween('created_at', [$created, $now])
                ->latest()
                ->first();

            if (empty($pagamentoAnterior)) {
                $dadosPagamento = [
                    'tipo' => 'pagamento',
                    'cliente_id' => $request->cliente_id,
                    'venda_id' => null,
                    'tipo_pagamento' => $request->tipo_pagamento,
                    'forma_pagamento' => $request->forma_pagamento,
                    'valor_parcela' => $valorRecebido,
                    'numero_parcela' => 1,
                    'total_parcelas' => 1,
                    'dias_parcelas' => 30,
                    'data_vencimento' => $request->data_vencimento,
                    'data_pagamento' => $dataPagamento,
                    'valor_recebido' => $valorRecebido,
                    'valor_subtotal' => $valorRecebido,
                    'troco' => 0.00,
                    'situacao' => ($request->tipo_pagamento == 0) ? '4' : '0',
                    'status' => 1,
                ];
                VendaPagamento::create($dadosPagamento);

                foreach ($vendas as $venda) {
                    if ($valorRecebido > 0) {
                        $saldo = floatval($venda->saldo);
                        $valorPagamento = $valorRecebido > $saldo ? $saldo : $valorRecebido;
                        $valorRecebido = floatval($valorRecebido) - $valorPagamento;

                        $data = [
                            'tipo' => 'venda',
                            'venda_id' => $venda->id,
                            'tipo_pagamento' => $request->tipo_pagamento,
                            'forma_pagamento' => $request->forma_pagamento,
                            'valor_parcela' => $valorPagamento,
                            'numero_parcela' => 1,
                            'total_parcelas' => 1,
                            'dias_parcelas' => 30,
                            'data_vencimento' => $request->data_vencimento,
                            'data_pagamento' => ($request->tipo_pagamento == 0) ? $dataPagamento : Carbon::now()->format('Y-m-d'),
                            'valor_recebido' => $valorPagamento,
                            'valor_subtotal' => $valorPagamento,
                            'troco' => 0.00,
                            'situacao' => ($request->tipo_pagamento == 0) ? '4' : '0',
                            'status' => 1,
                        ];
                        FaturaItem::create($data);
                        $this->saldo($venda->id);
                    }
                }
            }

            DB::commit();

            return redirect()->to('cliente/historico/'.$request->cliente_id);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            //return redirect()->back();
        }
    }

    public function cobrado(Request $request)
    {
        $venda = VendaCobrado::where('cliente_id', $request->cliente_id)
            ->where('data', date('Y-'.$request->mes."-01"))
            ->first();
        if ($venda) {
            $venda->status = $request->status;
            $venda->save();
        } else {
            VendaCobrado::create([
                'cliente_id' => $request->cliente_id,
                'data' => date('Y-'.$request->mes."-01"),
                'status' => $request->status,
            ]);
        }

        return redirect()->back();
    }

    public function saldo($venda_id)
    {
        $faturas = FaturaItem::where('venda_id', $venda_id)
            ->where('status', '>', 0)
            ->sum('valor_subtotal');

        $venda = Venda::find($venda_id);
        $venda->saldo = floatval($venda->total_liquido) - floatval($faturas);
        $venda->status = (floatval($venda->total_liquido) - floatval($faturas)) <= 0 ? 1 : 0;
        $venda->save();
    }

    public static function saldoAnterior($cliente_id, $tipo_pagamento)
    {
        $saldoAnterior = Venda::where('cliente_id', $cliente_id)->sum('saldo');
        $existeSaldoAnterior = VendaPagamento::where('cliente_id', $cliente_id)->where('tipo', 'saldo')->first();

        if (!$existeSaldoAnterior) {
            $dadosPagamentoSaldo = [
                'tipo' => 'saldo',
                'cliente_id' => $cliente_id,
                'venda_id' => null,
                'tipo_pagamento' => null,
                'forma_pagamento' => null,
                'valor_parcela' => $saldoAnterior,
                'numero_parcela' => 1,
                'total_parcelas' => 1,
                'dias_parcelas' => 30,
                'data_vencimento' => Carbon::parse('2025-02-10')->format('Y-m-d'),
                'data_pagamento' => Carbon::parse('2025-02-10')->format('Y-m-d'),
                'valor_recebido' => $saldoAnterior,
                'valor_subtotal' => $saldoAnterior,
                'troco' => 0.00,
                'situacao' => ($tipo_pagamento == 0) ? '4' : '0',
                'status' => 1,
            ];
            VendaPagamento::create($dadosPagamentoSaldo);
        }
    }

    public function status()
    {
        $vendas = Venda::with('itens')
            ->where('saldo', '<=', 0)
            ->get();

        foreach ($vendas as $venda) {
            if (!empty($venda->itens)) {
                $venda->status = 1;
                $venda->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        \DB::beginTransaction();

        $result = Venda::destroy($request->id);
        FaturaItem::where('venda_id', $request->id)->delete();
        VendaItem::where('venda_id', $request->id)->delete();
        VendaPagamento::where('venda_id', $request->id)->delete();

        \DB::commit();

        return response()->json([
            'success' => $result
        ]);
    }
}
