<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clientes = Cliente::all();
        return view('cliente.lista')->with('clientes', $clientes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.gerenciar')->with(['method' => 'store']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Cliente::create($request->all());

        if ($response) {
            toastr()->success('Registro cadastrado com sucesso!');
            return redirect()->to('cliente');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
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

    public function ajax(Request $request)
    {
        $model = Cliente::select([
            'clientes.id',
            'clientes.nome',
            'clientes.documento',
            'clientes.tipo_pessoa',
            'grupos.nome AS grupo_nome',
            'clientes.status'
        ])
            ->leftjoin('grupos', 'grupos.id', 'clientes.grupo_id');

        $properties = [
            'id' => 'id',
            'nome' => 'string',
            'documento' => 'string',
            'tipo_pessoa' => 'integer',
            'grupo_nome' => 'string',
            'status' => 'string'
        ];

        $filters = [
            'clientes.id' => 'id',
            'clientes.nome' => 'string',
            'clientes.documento' => 'string',
            'grupos.nome' => 'string',
        ];

        $response = $this->dtable($request, $model, $properties, $filters);
        return response()->json($response);
    }
}
