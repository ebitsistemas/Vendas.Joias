<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Configuracao;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    use TraitDatatables;

    /**
     * Show the form for editing the specified resource.
     */
    public function show()
    {
        $config = Configuracao::first();
        return view('configuracao.gerenciar')->with(['configuracao' => $config, 'method' => 'view']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $config = Configuracao::first();
        return view('configuracao.gerenciar')->with(['configuracao' => $config, 'method' => 'update']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $config = Configuracao::first();
        $config->update($request->all());
        $response = $config->save();

        if ($response) {
            toastr()->success('Registro alterado com sucesso!');
            return redirect()->to('configuracao');
        }

        toastr()->error('Erro ao cadastrar registro!');
        return back();
    }
}
