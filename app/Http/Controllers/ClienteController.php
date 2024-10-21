<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Grupo;
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
     * Search client.
     */
    public function buscar(Request $request)
    {
        if (empty($request->pesquisa)) {
            $clientes = Cliente::where('status', 1)->paginate(2);
        } else {
            $model = Cliente::where('status', 1);

            $pesquisa = $request->pesquisa;
            $model->where(function($query) use ($pesquisa) {
                $query->orWhere('id', 'like', "%{$pesquisa}")
                    ->orWhere('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('documento', 'like', "%{$pesquisa}%")
                    ->orWhere('celular', 'like', "%{$pesquisa}%")
                    ->orWhere('telefone', 'like', "%{$pesquisa}%")
                    ->orWhere('email', 'like', "%{$pesquisa}%");
            });
            $clientes = $model->paginate(2);
        }
        return view('cliente.buscar')->with(['method' => 'view', 'clientes' => $clientes, 'pesquisa' => $pesquisa ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::all();
        return view('cliente.gerenciar')->with(['method' => 'store', 'grupos' => $grupos]);
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
        $cliente = Cliente::find($id);
        $grupos = Grupo::all();

        return view('cliente.gerenciar')->with(['method' => 'view', 'cliente' => $cliente, 'grupos' => $grupos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        $grupos = Grupo::all();

        return view('cliente.gerenciar')->with(['method' => 'update', 'cliente' => $cliente, 'grupos' => $grupos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $response = $cliente->update($request->all());

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('cliente');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = Cliente::destroy($request->id);

        return response()->json([
            'success' => $result
        ]);
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
