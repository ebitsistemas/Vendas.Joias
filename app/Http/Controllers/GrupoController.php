<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Grupo;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $grupos = Grupo::where('status', 1)->paginate($config->itens_pagina);
        } else {
            $model = Grupo::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%");
            });
            $grupos = $model->paginate($config->itens_pagina);
        }
        return view('grupo.lista')->with(['grupos' => $grupos, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::all();
        return view('grupo.gerenciar')->with(['method' => 'store', 'grupos' => $grupos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Grupo::create($request->all());

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('grupo');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $grupo = Grupo::find($id);
        $grupos = Grupo::all();

        return view('grupo.gerenciar')->with(['method' => 'update', 'grupo' => $grupo, 'grupos' => $grupos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $grupo = Grupo::find($request->id);
        $response = $grupo->update($request->all());

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('grupo');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = Grupo::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
    }

    public function ajax(Request $request)
    {
        $model = Grupo::select([
            'grupos.id',
            'grupos.nome',
            'grupos_pai.nome AS grupo_pai',
            'grupos.status'
        ])
            ->leftjoin('grupos AS grupos_pai', 'grupos_pai.id', 'grupos.grupo_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'grupo_pai' => 'string',
            'status' => 'string'
        ];

        $filters = [
            'grupos.id' => 'id',
            'grupos.nome' => 'string',
            'grupos.documento' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
