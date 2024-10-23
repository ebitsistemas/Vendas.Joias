<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Configuracao;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $categorias = Categoria::where('status', 1)->paginate($config->itens_pagina);
        } else {
            $model = Categoria::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%");
            });
            $categorias = $model->paginate($config->itens_pagina);
        }
        return view('categoria.lista')->with(['categorias' => $categorias, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('categoria.gerenciar')->with(['method' => 'store', 'categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Categoria::create($request->all());

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('categoria');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::find($id);
        $categorias = Categoria::all();

        return view('categoria.gerenciar')->with(['method' => 'update', 'categoria' => $categoria, 'categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $categoria = Categoria::find($request->id);
        $response = $categoria->update($request->all());

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('categoria');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = Categoria::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
    }

    public function ajax(Request $request)
    {
        $model = Categoria::select([
            'categorias.id',
            'categorias.nome',
            'categorias_pai.nome AS categoria_pai',
            'categorias.status'
        ])
            ->leftjoin('categorias AS categorias_pai', 'categorias_pai.id', 'categorias.categoria_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'categoria_pai' => 'string',
            'status' => 'string'
        ];

        $filters = [
            'categorias.id' => 'id',
            'categorias.nome' => 'string',
            'categorias.documento' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
