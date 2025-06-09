<?php

namespace App\Http\Controllers;

use App\Http\Utilities\Helper;
use App\Models\Venda;
use App\Models\VendaPagamento;
use App\Models\FaturaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PagamentoController extends Controller
{
    /**
     * Processa um pagamento de um cliente, quitando as vendas com saldo devedor
     * mais antigas primeiro (lógica FIFO - First-In, First-Out).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processarPagamentoFifo(Request $request)
    {
        if ($request->has('valor')) {
            $valorFormatado = str_replace('.', '', $request->input('valor')); // Remove o separador de milhares (.)
            $valorFormatado = str_replace(',', '.', $valorFormatado); // Substitui a vírgula (,) por ponto (.)
            $request->merge(['valor' => $valorFormatado]);
        }
        if ($request->has('data_pagamento')) {
            $dataFormatada = Carbon::parse($request->input('data_pagamento'))->format('Y-m-d');
            $request->merge(['data_pagamento' => $dataFormatada]);
        }

        echo '<pre>';
        print_r($request->all());
        exit;

        // 1. Validação dos dados de entrada do formulário (agora com o valor já formatado)
        $validatedData = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'valor' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
            'forma_pagamento' => 'required|string|max:2',
        ]);

        $clienteId = $validatedData['cliente_id'];
        $valorTotalPago = $validatedData['valor']; // Pega o valor já validado e formatado

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
                    'data_venda' => $venda->data_venda->format('d/m/Y'),
                    'valor_original' => $venda->total_liquido,
                    'valor_quitado' => $valorAplicar,
                    'saldo_restante_venda' => $venda->saldo
                ];
            }

            DB::commit();

            Helper::print($detalhesQuitacao);

            return response()->json([
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
            ], 200);

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
    public function reverterPagamento($pagamentoId)
    {
        try {
            DB::beginTransaction();

            // Encontra o pagamento e já carrega as faturas e vendas relacionadas para evitar múltiplas queries
            $pagamento = VendaPagamento::with('faturasQuitadas.venda')->findOrFail($pagamentoId);

            if ($pagamento->situacao != 1) { // 1 = Concluído
                throw new Exception('Este pagamento não pode ser revertido (possivelmente já foi estornado).');
            }

            // 1. Itera sobre cada fatura que este pagamento quitou
            foreach ($pagamento->faturasQuitadas as $faturaItem) {
                // 2. Devolve o saldo para a venda original
                $venda = $faturaItem->venda;
                $venda->saldo += $faturaItem->valor_recebido;
                $venda->save();

                // 3. Marca o registro da fatura como cancelado
                $faturaItem->situacao = 2; // 2 = Cancelado
                $faturaItem->save();
            }

            // 4. Marca o pagamento principal como cancelado/estornado
            $pagamento->situacao = 2; // 2 = Cancelado/Estornado
            $pagamento->save();

            DB::commit();

            return response()->json(['message' => 'Pagamento revertido com sucesso!'], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocorreu um erro ao reverter o pagamento.', 'error' => $e->getMessage()], 500);
        }
    }
}
