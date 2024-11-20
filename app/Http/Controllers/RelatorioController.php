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
        /*
        echo '<pre>';
        print_r($faturas);
        exit();*/

        return view('relatorio.financeiro')->with(['faturas' => $faturas ?? null, 'clientes' => $clientes, 'situacoes' => $situacoes, 'request' => $request]);
    }

    public function periodo(Request $request)
    {
        $grupos = Grupo::all();

        if (!empty($request->has('_token'))) {
            $model = Cliente::select([
                'clientes.id',
                'clientes.nome',
                'clientes.logradouro',
                'clientes.numero',
                'clientes.cidade',
                'clientes.uf',
                'clientes.status'
            ]);
            $model->leftjoin('vendas', 'vendas.cliente_id', 'clientes.id');
            if (!empty($request->tipo_pessoa)) {
                $model->where('clientes.tipo_pessoa', $request->tipo_pessoa);
            }
            if (!empty($request->grupo_id)) {
                $model->where('clientes.grupo_id', $request->grupo_id);
            }
            if (!empty($request->cidade)) {
                $model->where('clientes.logradouro', 'like', "%{$request->cidade}%");
            }
            if (!empty($request->bairro)) {
                $model->where('clientes.bairro', 'like', "%{$request->bairro}%");
            }
            if (!empty($request->status)) {
                $model->where('clientes.status', $request->status);
            }
            $model->whereBetween('vendas.data_cobranca', [date("{$request->ano}-{$request->mes}-01"), date("{$request->ano}-{$request->mes}-t")]);
            $model->where('vendas.status', 0);
            $model->groupBy('vendas.cliente_id');
            $clientes = $model->get();
        }

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
