<?php

namespace App\Http\Controllers;

use App\Models\FaturaItem;
use App\Models\Venda;
use App\Models\VendaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    public function pagar(Request $request)
    {
        $fatura = FaturaItem::find($request->id);
        $response = $fatura->update([
            'data_pagamento' => Carbon::now()->format('Y-m-d'),
            'situacao' => 4
        ]);

        if ($response) {
            toastr()->success('Fatura paga com sucesso!');
            return redirect()->to('carrinho/pedido/' . $fatura->venda_id);
        }
        toastr()->error('Erro ao pagar fatura!');
        return redirect()->to('carrinho/pedido/' . $fatura->venda_id);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $fatura = FaturaItem::find($request->id);
        $response = $fatura->delete();

        $this->saldo($fatura->venda_id);

        if ($response) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function saldo($venda_id)
    {
        $faturas = FaturaItem::where('venda_id', $venda_id)->where('status', '>', 0)->sum('valor_subtotal');
        $venda = Venda::find($venda_id);
        $venda->saldo = $venda->total_liquido - $faturas;
        $venda->save();
    }
}
