<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\FaturaItem;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Http\Utilities\Impressao80mm;

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
            $vendas = Venda::paginate($config->itens_pagina);
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
            $vendas = $model->paginate($config->itens_pagina);
        }
        return view('venda.lista')->with(['vendas' => $vendas, 'produtos' => $produtos, 'pesquisa' => $pesquisa ?? '']);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
