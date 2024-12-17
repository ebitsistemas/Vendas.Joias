<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FaturaItem;
use App\Models\FaturaSituacao;
use App\Models\Grupo;
use App\Models\Situacao;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorio.index');
    }

    public function cliente(Request $request)
    {
        $grupos = Grupo::all();

        if (!empty($request->has('_token'))) {
            $model = Cliente::select('*');
            if (!empty($request->tipo_pessoa)) {
                $model->where('tipo_pessoa', $request->tipo_pessoa);
            }
            if (!empty($request->grupo_id)) {
                $model->where('grupo_id', $request->grupo_id);
            }
            if (!empty($request->sexo)) {
                $model->where('sexo', $request->sexo);
            }
            if (!empty($request->cidade)) {
                $model->where('cidade', 'like', "%{$request->cidade}%");
            }
            if (!empty($request->bairro)) {
                $model->where('bairro', 'like', "%{$request->bairro}%");
            }
            if (!empty($request->status)) {
                $model->where('status', $request->status);
            }
            $clientes = $model->get();
        }

        return view('relatorio.cliente')->with(['clientes' => $clientes ?? null, 'grupos' => $grupos, 'request' => $request]);
    }

    public function financeiro(Request $request)
    {
        $clientes = Cliente::all();
        $situacoes = FaturaSituacao::all();

        if (!empty($request->has('_token'))) {
            $model = FaturaItem::select('*');
            $model->leftjoin('vendas', 'vendas.id', '=', 'faturas_itens.venda_id');
            $model->leftjoin('clientes', 'clientes.id', '=', 'vendas.cliente_id');
            if (!empty($request->data_inicial) AND !empty($request->data_final)) {
                $inicio = Carbon::createFromFormat('d/m/Y', $request->data_inicial)->format('Y-m-d');
                $fim = Carbon::createFromFormat('d/m/Y', $request->data_final)->format('Y-m-d');
                if ($request->tipo_data == 1) {
                    $model->whereBetween('faturas_itens.created_at', [$inicio, $fim]);
                } else if ($request->tipo_data == 2) {
                    $model->whereBetween('faturas_itens.data_vencimento', [$inicio, $fim]);
                } else if ($request->tipo_data == 3) {
                    $model->whereBetween('faturas_itens.data_pagamento', [$inicio, $fim]);
                }
            }
            if (!empty($request->cliente_id)) {
                $model->where('vendas.cliente_id', $request->cliente_id);
            }
            if ($request->status != '') {
                $model->where('faturas_itens.situacao', $request->status);
            }
            $faturas = $model->get();
        }

        return view('relatorio.financeiro')->with(['faturas' => $faturas ?? null, 'clientes' => $clientes, 'situacoes' => $situacoes, 'request' => $request]);
    }

    public function periodo(Request $request)
    {
        /* add dia na pesquisa do periodo */
        $grupos = Grupo::all();

        $ano = ($request->ano) ? $request->ano : date('Y');
        $mes = ($request->mes) ? $request->mes : date('m');

        $sqlCobrado = '';
        if ($request->cobrado != "") {
            $sqlCobrado .= "AND vendas_cobrado.status = 1";
        }
        $sql = "SELECT * FROM (
                    SELECT `clientes`.`id`,
                           `clientes`.`nome`,
                           `clientes`.`status`,
                           `clientes`.`dia_cobranca`,
                           (SELECT SUM(vendas.saldo) FROM vendas WHERE `vendas`.`cliente_id` = `clientes`.`id`) as saldo,  /* AND date(`vendas`.`data_venda`) >= '{$ano}-{$mes}-01' */
                           (SELECT vendas_cobrado.status FROM vendas_cobrado WHERE vendas_cobrado.cliente_id = clientes.id AND vendas_cobrado.data = '{$ano}-{$mes}-01' {$sqlCobrado}) as cobrado_status
                    FROM `clientes` WHERE true ";
        if (!empty($request->tipo_pessoa)) {
            $sql .= "and clientes.tipo_pessoa = {$request->tipo_pessoa}";
        }
        if (!empty($request->grupo_id)) {
            $sql .= "and clientes.grupo_id = {$request->grupo_id}";
        }
        if (!empty($request->status)) {
            $sql .= "and clientes.status = {$request->status}";
        }
        $sql .= "and `clientes`.`deleted_at` is null ";
        $sql .= "group by `clientes`.`id`) as dados WHERE saldo > 0";

        $clientes = \DB::select($sql);

        return view('relatorio.periodo')->with(['clientes' => $clientes ?? null, 'grupos' => $grupos, 'request' => $request]);
    }

    public function venda(Request $request)
    {
        $clientes = Cliente::all();
        $situacoes = Situacao::all();

        if (!empty($request->has('_token'))) {
            $model = Venda::select('*');
            if (!empty($request->data_inicial) AND !empty($request->data_final)) {
                $inicio = Carbon::createFromFormat('d/m/Y', $request->data_inicial)->format('Y-m-d');
                $fim = Carbon::createFromFormat('d/m/Y', $request->data_final)->format('Y-m-d');
                if ($request->tipo_data == 1) {
                    $model->whereBetween('data_venda', [$inicio, $fim]);
                } else if ($request->tipo_data == 2) {
                    $model->whereBetween('data_confirmacao', [$inicio, $fim]);
                }
            }
            if (!empty($request->cliente_id)) {
                $model->where('cliente_id', $request->cliente_id);
            }
            if ($request->status != '') {
                $model->where('status', $request->status);
            }
            $vendas = $model->get();
        }

        // pegar data do ultimo pagamento
        // verificar se teve pagamento na venda, no mes do filtro [para mostrar os pagos e não pagos]

        return view('relatorio.venda')->with(['vendas' => $vendas ?? null, 'clientes' => $clientes, 'situacoes' => $situacoes, 'request' => $request]);
    }
}
