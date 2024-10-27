<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use App\Models\Configuracao;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = Configuracao::first();
        if (empty($request->pesquisa)) {
            $usuarios = User::where('status', 1)->paginate($config->itens_pagina);
        } else {
            $model = User::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%");
            });
            $usuarios = $model->paginate($config->itens_pagina);
        }
        return view('usuario.lista')->with(['usuarios' => $usuarios, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('usuario.gerenciar')->with(['method' => 'store', 'usuarios' => $usuarios]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = User::create($request->all());

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('usuario');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::find($id);
        $usuarios = User::all();

        return view('usuario.gerenciar')->with(['method' => 'update', 'usuario' => $usuario, 'usuarios' => $usuarios]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $usuario = User::find($request->id);
        $response = $usuario->update($request->all());

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('usuario');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = User::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
    }
}
