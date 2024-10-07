<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Grupo;
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
        $grupos = Grupo::all();
        return view('produto.gerenciar')->with(['method' => 'store', 'grupos' => $grupos]);
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

        return view('produto.gerenciar')->with(['method' => 'view', 'produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Produto::find($id);

        return view('produto.gerenciar')->with(['method' => 'update', 'produto' => $produto]);
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
            'produtos.documento',
            'produtos.tipo_pessoa',
            'grupos.nome AS grupo_nome',
            'produtos.status'
        ])
            ->leftjoin('grupos', 'grupos.id', 'produtos.grupo_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'documento' => 'string',
            'tipo_pessoa' => 'integer',
            'grupo_nome' => 'string',
            'status' => 'string'
        ];

        $filters = [
            'produtos.id' => 'id',
            'produtos.nome' => 'string',
            'produtos.documento' => 'string',
            'grupos.nome' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
