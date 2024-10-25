<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FaturaItem;
use App\Models\Situacao;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaItem;
use App\Traits\TraitDatatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CarrinhoController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venda = Venda::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

        if (!isset($venda->status) OR $venda->status != 0) {
            $venda = Venda::create([
                'data_venda' => date('Y-m-d'),
                'user_id' => auth()->user()->id,
                'status' => 0,
            ]);
            Cache::store('database')->put('venda_id', $venda->id, 86400);
        }

        return redirect()->to('carrinho/pedido/' . $venda->id);
    }

    public function pedido(Request $request)
    {
        $situacoes = Situacao::where('status', 1)->get();
        $venda = Venda::find($request->id);
        $venda_id = Cache::get('venda_id');
        if (empty($venda_id)) {
            Cache::store('database')->put('venda_id', $venda->id, 86400);
        }

        return view('carrinho.index')->with(['method' => 'store', 'venda' => $venda, 'situacoes' => $situacoes]);
    }

    /**
     * Add the client.
     */
    public function clienteAdicionar(Request $request)
    {
        $venda_id = Cache::get('venda_id');
        $venda = Venda::find($venda_id);
        $venda->cliente_id = $request->cliente_id;
        $response = $venda->save();

        if ($response) {
            toastr()->success('Cliente adicionado com sucesso!');
            return redirect()->to('carrinho/pedido/' . $venda->id);
        }
        toastr()->error('Erro ao adicionar cliente!');
        return redirect()->to('carrinho/pedido/' . $venda->id);
    }

    /**
     * Remover the client.
     */
    public function clienteRemover()
    {
        $venda_id = Cache::get('venda_id');
        $venda = Venda::find($venda_id);
        $venda->cliente_id = null;
        $response = $venda->save();

        if ($response) {
            toastr()->success('Cliente removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $venda_id);
        }
        toastr()->error('Erro ao remover cliente!');
        return redirect()->to('carrinho/pedido/' . $venda_id);
    }

    /**
     * Add the product.
     */
    public function produtoAdicionar(Request $request)
    {
        $venda_id = Cache::get('venda_id');
        $produto = Produto::find($request->produto_id);

        $vendaItem = VendaItem::create([
            'venda_id' => $venda_id,
            'produto_id' => $request->produto_id,
            'produto_nome' => $produto->nome,
            'valor_unitario' => $produto->preco_venda,
            'quantidade' => 1,
            'valor_total' => $produto->preco_venda,
            'status' => 1,
        ]);

        $total = VendaItem::where('venda_id', $venda_id)->sum('valor_total');
        Venda::where('id', $venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        if ($vendaItem) {
            toastr()->success('Produto adicionado com sucesso!');
            return redirect()->to('carrinho/pedido/' . $venda_id);
        }
        toastr()->error('Erro ao adicionar produto!');
        return redirect()->to('carrinho/pedido/' . $venda_id);
    }

    /**
     * Add the product.
     */
    public function produtoCadastrar(Request $request)
    {
        //dd($request->all());
        $vendaItem = VendaItem::create([
            'venda_id' => $request->venda_id,
            'produto_id' => $request->produto_id,
            'produto_nome' => $request->produto_nome,
            'valor_unitario' => str_replace(',', '.', str_replace('.', '', $request->valor_unitario)),
            'quantidade' => doubleval($request->quantidade),
            'valor_total' => str_replace(',', '.', str_replace('.', '', $request->valor_total)),
            'status' => 1,
        ]);

        $total = VendaItem::where('venda_id', $request->venda_id)->sum('valor_total');
        Venda::where('id', $request->venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        if ($vendaItem) {
            toastr()->success('Produto adicionado com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao adicionar produto!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
    }

    /**
     * Alter quant the product.
     */
    public function produtoQuantidade(Request $request)
    {
        $vendaItem = VendaItem::find($request->id);

        if ($request->quantidade <= 0) {
            $vendaItem->delete();
        } else {
            $vendaItem->update([
                'quantidade' => doubleval($request->quantidade),
                'valor_total' => doubleval($request->quantidade) * $vendaItem->valor_unitario,
            ]);
        }

        $total = VendaItem::where('venda_id', $vendaItem->venda_id)->sum('valor_total');
        Venda::where('id', $vendaItem->venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        if ($vendaItem) {
            toastr()->success('Produto adicionado com sucesso!');
            return redirect()->to('carrinho/pedido/' . $vendaItem->venda_id);
        }
        toastr()->error('Erro ao adicionar produto!');
        return redirect()->to('carrinho/pedido/' . $vendaItem->venda_id);
    }

    /**
     * Remover the client.
     */
    public function produtoRemover(Request $request)
    {
        $venda_id = Cache::get('venda_id');
        $response = VendaItem::find($request->item_id)->delete();

        $total = VendaItem::where('venda_id', $venda_id)->sum('valor_total');
        Venda::where('id', $venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        if ($response) {
            toastr()->success('Produto removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $venda_id);
        }
        toastr()->error('Erro ao remover produto!');
        return redirect()->to('carrinho/pedido/' . $venda_id);
    }

    /**
     * Add the payment.
     */
    public function faturaAdicionar(Request $request)
    {
        if (empty($request->valor_recebido)) {
            toastr()->error('Valor da fatura deve ser informado, campo obrigatório!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }

        $vendaItem = FaturaItem::create([
            'venda_id' => $request->venda_id,
            'tipo_pagamento' => $request->tipo_pagamento,
            'forma_pagamento' => $request->forma_pagamento,
            'valor_parcela' => str_replace(',', '.', str_replace('.', '', $request->valor_parcela)),
            'numero_parcela' => $request->numero_parcela ?? 1,
            'total_parcelas' => $request->total_parcelas,
            'dias_parcelas' => $request->dias_parcelas,
            'data_vencimento' => $request->data_vencimento,
            'data_pagamento' => $request->data_pagamento,
            'valor_recebido' => str_replace(',', '.', str_replace('.', '', $request->valor_recebido)),
            'valor_subtotal' => str_replace(',', '.', str_replace('.', '', $request->valor_recebido)),
            'troco' => str_replace(',', '.', str_replace('.', '', $request->troco)),
            'situacao' => ($request->tipo_pagamento == 0) ? '4' : '0',
            'status' => 1,
        ]);

        //$total = FaturaItem::where('venda_id', $request->venda_id)->sum('valor_subtotal');

        if ($vendaItem) {
            toastr()->success('Fatura adicionada com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao adicionar fatura!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
    }

    /**
     * Remover the payment.
     */
    public function faturaRemover(Request $request)
    {
        $venda_id = Cache::get('venda_id');
        $response = VendaItem::find($request->item_id)->delete();

        $total = VendaItem::where('venda_id', $venda_id)->sum('valor_total');
        Venda::where('id', $venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        if ($response) {
            toastr()->success('Produto removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $venda_id);
        }
        toastr()->error('Erro ao remover produto!');
        return redirect()->to('carrinho/pedido/' . $venda_id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $venda = Venda::find($request->id);
        $response = $venda->update($request->all());

        if ($response) {
            toastr()->success('Registro salvo com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->id);
        }
        toastr()->error('Erro ao salvar registro!');
        return redirect()->to('carrinho/pedido/' . $request->id);
    }

    /**
     * Display the specified resource.
     */
    public function checkout(Request $request)
    {
        $venda = Venda::find($request->id);
        return view('carrinho.produtos.DELETAR.php')->with(['method' => 'view', 'venda' => $venda]);
    }
}
