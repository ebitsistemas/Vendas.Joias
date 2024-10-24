<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Venda;
use App\Models\Produto;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendaController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::all();
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $vendas = Venda::where('status', 1)->paginate($config->itens_pagina);
        } else {
            $model = Venda::where('status', 1);

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all();
        return view('venda.grid')->with(['method' => 'store', 'produtos' => $produtos]);
    }

    public function cart()
    {
        $venda = Venda::orderBy('created_at', 'desc')->first();

        if (isset($venda->status) AND $venda->status == 0) {
            return redirect()->to('venda/edit/' . $venda->id);
        } else {
            $produtos = Produto::all();
            return view('venda.cart')->with(['method' => 'store', 'produtos' => $produtos]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['preco_custo'] = str_replace('.', '', str_replace(',', '.', $data['preco_custo']));
        $data['preco_venda'] = str_replace('.', '', str_replace(',', '.', $data['preco_venda']));
        if($request->hasFile('imagem')) {
            $file = $request->file('file');
            $name = $file->hashName();
            $upload = Storage::put("imagem/{$name}", $file);
            $data['imagem'] = $upload->path();
        }
        $response = Produto::create($data);

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('produto');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::find($id);
        return view('venda.gerenciar')->with(['method' => 'view', 'produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Produto::find($id);
        return view('venda.gerenciar')->with(['method' => 'update', 'produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $produto = Produto::find($request->id);
        $data['preco_custo'] = number_format($data['preco_custo'], 2, '.', ',');
        //$data['preco_custo'] = str_replace('.', ',', str_replace(',', '.', $data['preco_custo']));
        $data['preco_venda'] = number_format($data['preco_venda'], 2, '.', ',');
        //$data['preco_venda'] = str_replace('.', ',', str_replace(',', '.', $data['preco_venda']));
        if($request->hasFile('imagem')) {
            $file = $request->file('file');
            $name = $file->hashName();
            $path = Storage::disk('local')->put($name, $file);
            $data['imagem'] = $path;
        }
        $response = $produto->update($data);

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('produto');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    public function add(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = Produto::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
    }

    public function ajax(Request $request)
    {
        $model = Produto::select([
            'produtos.id',
            'produtos.nome',
            'produtos.codigo_interno',
            'categorias.nome AS categoria_nome',
            'produtos.preco_venda',
            'produtos.status'
        ])
            ->leftjoin('categorias', 'categorias.id', 'produtos.categoria_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'codigo_interno' => 'string',
            'categoria_nome' => 'string',
            'preco_venda' => 'money',
            'status' => 'string'
        ];

        $filters = [
            'produtos.id' => 'id',
            'produtos.nome' => 'string',
            'produtos.codigo_interno' => 'string',
            'produtos.preco_venda' => 'money',
            'categorias.nome' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
