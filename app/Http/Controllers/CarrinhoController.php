<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FaturaItem;
use App\Models\Situacao;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaItem;
use App\Models\VendaPagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\TraitDatatables;
use Illuminate\Support\Facades\Cache;

class CarrinhoController extends Controller
{
    use TraitDatatables;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venda = Venda::create([
            'data_venda' => date('Y-m-d'),
            'user_id' => auth()->user()->id,
            'status' => 0,
        ]);

        $dadosPagamento = [
            'cliente_id' => null,
            'venda_id' => $venda->id,
            'tipo_pagamento' => null,
            'forma_pagamento' => null,
            'valor_parcela' => null,
            'numero_parcela' => 1,
            'total_parcelas' => 1,
            'dias_parcelas' => 30,
            'data_vencimento' => null,
            'data_pagamento' => Carbon::now()->format('Y-m-d'),
            'valor_recebido' => null,
            'valor_subtotal' => null,
            'troco' => 0.00,
            'situacao' => '0',
            'status' => 1,
        ];
        VendaPagamento::create($dadosPagamento);

        return redirect()->to('carrinho/pedido/' . $venda->id);
    }

    public function pedido(Request $request)
    {
        $situacoes = Situacao::where('status', 1)->get();
        $venda = Venda::find($request->id);

        return view('carrinho.index')->with(['method' => 'store', 'venda' => $venda, 'situacoes' => $situacoes]);
    }

    /**
     * Add the client.
     */
    public function clienteAdicionar(Request $request)
    {
        $venda = Venda::find($request->venda_id);
        $venda->cliente_id = $request->cliente_id;
        $response = $venda->save();

        Cliente::find($request->cliente_id)
            ->update(['status' => 1]);

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
    public function clienteRemover(Request $request)
    {
        $response = Venda::where('id', $request->venda_id)
            ->update(['cliente_id' => null]);

        if ($response) {
            toastr()->success('Cliente removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao remover cliente!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
    }

    /**
     * Add the product.
     */
    public function produtoAdicionar(Request $request)
    {
        $produto = Produto::find($request->produto_id);

        $vendaItem = VendaItem::create([
            'venda_id' => $request->venda_id,
            'produto_id' => $request->produto_id,
            'produto_nome' => $produto->nome,
            'valor_unitario' => $produto->preco_venda,
            'quantidade' => 1,
            'valor_total' => $produto->preco_venda,
            'status' => 1,
        ]);

        $total = VendaItem::where('venda_id', $request->venda_id)->sum('valor_total');
        Venda::where('id', $request->venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        $this->saldo($request->venda_id);

        if ($vendaItem) {
            toastr()->success('Produto adicionado com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao adicionar produto!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
    }

    /**
     * Add the product.
     */
    public function produtoCadastrar(Request $request)
    {
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

        $this->saldo($request->venda_id);

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

        $this->saldo($vendaItem->venda_id);

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
        $vendaItem = VendaItem::find($request->item_id);
        $response = $vendaItem->delete();

        $total = VendaItem::where('venda_id', $request->venda_id)->sum('valor_total');
        Venda::where('id', $request->venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        $this->saldo($request->venda_id);

        if ($response) {
            toastr()->success('Produto removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao remover produto!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
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

        $dataPagamento = empty($request->data_pagamento) ? date('Y-m-d') : $request->data_pagamento;

        $data = [
            'venda_id' => $request->venda_id,
            'tipo_pagamento' => $request->tipo_pagamento,
            'forma_pagamento' => $request->forma_pagamento,
            'valor_parcela' => str_replace(',', '.', str_replace('.', '', $request->valor_parcela)),
            'numero_parcela' => $request->numero_parcela ?? 1,
            'total_parcelas' => $request->total_parcelas,
            'dias_parcelas' => $request->dias_parcelas,
            'data_vencimento' => $request->data_vencimento,
            'data_pagamento' => ($request->tipo_pagamento == 0) ? $dataPagamento : date('Y-m-d'),
            'valor_recebido' => str_replace(',', '.', str_replace('.', '', $request->valor_recebido)),
            'valor_subtotal' => str_replace(',', '.', str_replace('.', '', $request->valor_recebido)),
            'troco' => str_replace(',', '.', str_replace('.', '', $request->troco)),
            'situacao' => ($request->tipo_pagamento == 0) ? '4' : '0',
            'status' => 1,
        ];

        if (isset($request->id) && !empty($request->id)) {
            $vendaItem = FaturaItem::find($request->id);
            $vendaItem->update($data);
        } else {
            $vendaItem = FaturaItem::create($data);
        }

        $this->saldo($request->venda_id);

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
        $faturaItem = FaturaItem::find($request->item_id);
        $response = $faturaItem->delete();

        $total = VendaItem::where('venda_id', $request->venda_id)->sum('valor_total');
        Venda::where('id', $request->venda_id)->update(['total_bruto' => $total, 'total_liquido' => $total]);

        $this->saldo($request->venda_id);

        if ($response) {
            toastr()->success('Produto removido com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->venda_id);
        }
        toastr()->error('Erro ao remover produto!');
        return redirect()->to('carrinho/pedido/' . $request->venda_id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (isset($response->cliente_id) AND $request->total_liquido <= 0) {
            toastr()->error('Deve ser informado um produto e valor a venda!');
            return redirect()->to('carrinho/pedido/' . $request->id);
        }
        $venda = Venda::find($request->id);
        $response = $venda->update($request->all());

        if ($response) {
            toastr()->success('Registro salvo com sucesso!');
            return redirect()->to('carrinho/pedido/' . $request->id);
        }
        toastr()->error('Erro ao salvar registro!');
        return redirect()->to('carrinho/pedido/' . $request->id);
    }

    public function saldo($venda_id)
    {
        $faturas = FaturaItem::where('venda_id', $venda_id)->where('status', '>', 0)->sum('valor_subtotal');
        $venda = Venda::find($venda_id);
        $venda->saldo = $venda->total_liquido - $faturas;
        $venda->status = ($venda->total_liquido - $faturas) <= 0 ? 1 : 0;
        $venda->save();
    }
}
