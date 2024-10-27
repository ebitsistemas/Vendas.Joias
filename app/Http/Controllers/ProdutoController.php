<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Unidade;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $produtos = Produto::where('status', 1)->paginate($config->itens_pagina);
        } else {
            $model = Produto::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('descricao', 'like', "%{$pesquisa}%")
                    ->orWhere('preco_venda', 'like', "%{$pesquisa}%");
            });
            $produtos = $model->paginate($config->itens_pagina);
        }
        return view('produto.lista')->with(['produtos' => $produtos, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Search product.
     */
    public function buscar(Request $request)
    {
        if (empty($request->pesquisa)) {
            $produtos = Produto::where('status', 1)->paginate(12);
        } else {
            $model = Produto::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('descricao_curta', 'like', "%{$pesquisa}%")
                    ->orWhere('preco_venda', 'like', "%{$pesquisa}%");
            });
            $produtos = $model->paginate(12);
        }
        return view('produto.buscar')->with([
            'method' => 'view',
            'produtos' => $produtos,
            'venda_id' => $request->venda_id,
            'pesquisa' => $pesquisa ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Unidade::all();
        $categorias = Categoria::all();
        return view('produto.gerenciar')->with(['method' => 'store', 'categorias' => $categorias, 'unidades' => $unidades]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['preco_custo'] = str_replace(',', '.', $data['preco_custo']);
        $data['preco_venda'] = str_replace(',', '.', $data['preco_venda']);
        if($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $imagem = $file->get();
            $extension = $file->getClientOriginalExtension();
            $name = Auth::id().date('YmdHis').rand(1, 9999);
            $pathImg = "imagem/{$name}.{$extension}";
            Storage::disk('public')->put($pathImg, $imagem);
            $data['imagem'] = $pathImg;
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
        $unidades = Unidade::all();
        $categorias = Categoria::all();
        return view('produto.gerenciar')->with(['method' => 'view', 'produto' => $produto, 'categorias' => $categorias, 'unidades' => $unidades]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Produto::find($id);
        $unidades = Unidade::all();
        $categorias = Categoria::all();
        return view('produto.gerenciar')->with(['method' => 'update', 'produto' => $produto, 'categorias' => $categorias, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $produto = Produto::find($request->id);
        $data['preco_custo'] = str_replace(',', '.', $data['preco_custo']);
        $data['preco_venda'] = str_replace(',', '.', $data['preco_venda']);
        if($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $imagem = $file->get();
            $extension = $file->getClientOriginalExtension();
            $name = Auth::id().date('YmdHis').rand(1, 9999);
            $pathImg = "imagem/{$name}.{$extension}";
            Storage::disk('public')->put($pathImg, $imagem);
            $data['imagem'] = $pathImg;
        }
        $response = $produto->update($data);

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('produto');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
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
