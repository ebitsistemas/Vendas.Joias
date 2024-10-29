<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracao;
use App\Models\Grupo;
use App\Models\Venda;
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
            if (!empty($request->uf)) {
                $model->where('uf', $request->uf);
            }
            if (!empty($request->status)) {
                $model->where('status', $request->status);
            }
            $clientes = $model->get();
        }

        return view('relatorio.cliente')->with(['clientes' => $clientes ?? null, 'grupos' => $grupos, 'request' => $request]);
    }

    public function financeiro()
    {
        return view('relatorio.financeiro');
    }

    public function venda()
    {
        return view('relatorio.venda');
    }
}
