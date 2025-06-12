<?php

namespace App\Http\Controllers;

use App\Http\Utilities\Helper;
use App\Models\Cliente;
use App\Models\Configuracao;
use App\Models\Venda;
use App\Models\VendaPagamento;
use App\Models\FaturaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $config = Configuracao::first();

        $cliente = Cliente::find($request->id);
        $pagamentos = VendaPagamento::with(['cliente', 'situacaoFatura'])
            ->where('cliente_id', $cliente->id)
            ->where('tipo', 'pagamento')
            ->where('id', '>', 1683)
            ->paginate($config->itens_pagina);

        return view('cliente.pagamentos')->with(['cliente' => $cliente, 'pagamentos' => $pagamentos]);
    }

    /**
     * Processa um pagamento de um cliente, quitando as vendas com saldo devedor
     * mais antigas primeiro (lógica FIFO - First-In, First-Out).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processarPagamentoFifo(Request $request)
    {
        if ($request->has('valor_recebido')) {
            $valorFormatado = str_replace('.', '', $request->input('valor_recebido')); // Remove o separador de milhares (.)
            $valorFormatado = str_replace(',', '.', $valorFormatado); // Substitui a vírgula (,) por ponto (.)
            $request->merge(['valor_recebido' => $valorFormatado]);
        }
        if ($request->has('data_pagamento')) {
            $dataFormatada = Carbon::createFromFormat('d/m/Y', $request->input('data_pagamento'))->format('Y-m-d');
            $request->merge(['data_pagamento' => $dataFormatada]);
        }

        // 1. Validação dos dados de entrada do formulário (agora com o valor já formatado)
        $validatedData = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'valor_recebido' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
            'forma_pagamento' => 'required|string|max:2',
        ]);

        $clienteId = $validatedData['cliente_id'];
        $valorTotalPago = $validatedData['valor_recebido']; // Pega o valor já validado e formatado

        $detalhesQuitacao = [];
        try {
            DB::beginTransaction();

            $vendasDevedoras = Venda::where('cliente_id', $clienteId)
                ->where('saldo', '>', 0)
                ->orderBy('data_venda', 'asc')
                ->lockForUpdate()
                ->get();

            if ($vendasDevedoras->isEmpty()) {
                return response()->json(['message' => 'Este cliente não possui débitos em aberto.'], 404);
            }

            $pagamento = VendaPagamento::create([
                'tipo' => 'pagamento',
                'cliente_id' => $clienteId,
                'valor_recebido' => $valorTotalPago,
                'data_pagamento' => $validatedData['data_pagamento'],
                'forma_pagamento' => $validatedData['forma_pagamento'],
                'situacao' => 1,
            ]);

            $valorRestanteDoPagamento = $valorTotalPago;

            foreach ($vendasDevedoras as $venda) {
                if ($valorRestanteDoPagamento <= 0) {
                    break;
                }

                $valorAplicar = min($venda->saldo, $valorRestanteDoPagamento);

                $venda->saldo -= $valorAplicar;
                $venda->save();

                FaturaItem::create([
                    'venda_id' => $venda->id,
                    'venda_pagamento_id' => $pagamento->id,
                    'valor_recebido' => $valorAplicar,
                    'data_pagamento' => $validatedData['data_pagamento'],
                    'forma_pagamento' => $validatedData['forma_pagamento'],
                    'situacao' => 1,
                ]);

                $valorRestanteDoPagamento -= $valorAplicar;

                $detalhesQuitacao[] = [
                    'venda_id' => $venda->id,
                    'data_venda' => $venda->data_venda,
                    'valor_original' => $venda->total_liquido,
                    'valor_quitado' => $valorAplicar,
                    'saldo_restante_venda' => $venda->saldo
                ];
            }

            DB::commit();

            return redirect()->to('/cliente/historico/'.$clienteId);

            /*return response()->json([
                'success' => 'Pagamento processado com sucesso!',
                'pagamento_id' => $pagamento->id,
                'cliente_id' => $clienteId,
                'detalhes_pagamento' => [
                    'valor_pago' => $valorTotalPago,
                    'data_pagamento' => $validatedData['data_pagamento'],
                    'forma_pagamento' => $validatedData['forma_pagamento'],
                    'valor_nao_utilizado' => $valorRestanteDoPagamento,
                ],
                'vendas_quitadas' => $detalhesQuitacao
            ], 200);*/

        } catch (Exception $e) {
            DB::rollBack();
            Helper::print($e->getMessage());
            return response()->json(['erro' => 'Ocorreu um erro ao processar o pagamento.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Reverte (estorna) um pagamento processado, restaurando os saldos das vendas.
     *
     * @param int $pagamentoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function reverterPagamento(Request $request)
    {
        try {
            DB::beginTransaction();
            $pagamentoId = $request->id;
            // Encontra o pagamento e já carrega as faturas e vendas relacionadas para evitar múltiplas queries
            $pagamento = VendaPagamento::with('faturasQuitadas')->findOrFail($pagamentoId);
            $faturasItens = FaturaItem::where('venda_pagamento_id', $pagamento->id)->get();

            Helper::print($faturasItens);
            // 1. Itera sobre cada fatura que este pagamento quitou
            foreach ($faturasItens as $faturaItem) {
                // 2. Devolve o saldo para a venda original
                $venda = $faturaItem->venda;
                $venda->saldo += $faturaItem->valor_recebido;
                $venda->save();
                Helper::print($venda);

                // 3. Marca o registro da fatura como cancelado
                $faturaItem->situacao = 3; // 3 = Cancelado
                $faturaItem->save();
            }
            Helper::print($pagamento);

            // 4. Marca o pagamento principal como cancelado/estornado
            $pagamento->situacao = 3; // 3 = Cancelado/Estornado
            $pagamento->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pagamento revertido com sucesso!'
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocorreu um erro ao reverter o pagamento.', 'error' => $e->getMessage()], 500);
        }
    }
}
