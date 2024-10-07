<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Unidade;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produtos = Produto::all();
        return view('produto.lista')->with('produtos', $produtos);
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
        $response = Produto::create($request->all());

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
        $produto = Produto::find($request->id);
        $response = $produto->update($request->all());

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
            'produtos.codigo_barras',
            'produtos.codigo_interno',
            'categorias.nome AS categorias_nome',
            'produtos.preco_venda',
            'unidades.sigla AS sigla_unidade',
            'produtos.status'
        ])
            ->leftjoin('unidades', 'unidades.id', 'produtos.unidade_id')
            ->leftjoin('categorias', 'categorias.id', 'produtos.categoria_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'documento' => 'string',
            'tipo_pessoa' => 'integer',
            'categoria_nome' => 'string',
            'status' => 'string'
        ];

        $filters = [
            'produtos.id' => 'id',
            'produtos.nome' => 'string',
            'produtos.codigo_barras' => 'string',
            'produtos.codigo_interno' => 'string',
            'produtos.preco_venda' => 'string',
            'categorias.nome' => 'string',
            'unidades.sigla' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
