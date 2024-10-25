<!-- Cart -->
<div class="cart-wrapper-area">
    <a class="btn btn-theme p-3 mb-3" data-bs-toggle="collapse" href="#addProduto" role="button" aria-expanded="false" aria-controls="addProduto">
        <i class="fa fa-box me-1"></i> Adicionar Produto
    </a>

    <div class="collapse mb-3" id="addProduto">
        <div class="card card-body border">
            <form id="configuracao" action="{{ url('carrinho/produto/cadastrar') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="venda_id" id="venda_id" value="{{ $venda->id ?? '' }}">
                @csrf
                <div class="row mb-2">
                    <div class="col-lg-6 col-sm-6">
                        <label class="form-label" for="nome">Produto</label>
                        <input type="text" class="form-control form-control-lg" id="produto_nome" name="produto_nome" value="" required>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <label class="form-label" for="preco_venda">Preço Venda</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg form-control-cart text-end money" id="valor_unitario" name="valor_unitario" required>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <label class="form-label" for="quantidade">Quantidade</label>
                        <input type="number" class="form-control form-control-lg form-control-cart text-center" id="quantidade" name="quantidade" value="1" required>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <label class="form-label" for="subtotal">Subtotal</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg form-control-cart text-end money" id="subtotal" name="valor_total" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-9 pt-2">
                        <a href="{{ url('produto/buscar') }}" class="text-theme">Adicionar produto já cadastrado</a>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-icon btn-theme"><i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(empty($venda->itens))
        <div class="alert custom-alert-three alert-info alert-dismissible fade show" role="alert">
            <div class="row">
                <div class="col text-center pt-3">
                    <i class="fal fa-shopping-cart fs-60px"></i>

                    <div class="alert-text p-3">
                        <h6>Carrinho vazio!</h6>
                        <span>Nenhum produto adicionado ao pedido de venda.</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card cart-table border mb-3">
            <div class="table-responsive card-body">
                <table class="table mb-0 text-center">
                    <thead>
                    <tr>
                        <th class="text-start w-200px">Produto</th>
                        <th class="text-center w-125px">Preço</th>
                        <th class="text-center w-200px">Quantidade</th>
                        <th class="text-center w-125px">Subtotal</th>
                        <th class="text-end w-50px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($venda->itens as $item)
                        <tr class="border-bottom">
                            <td class="text-start fs-18px">
                                {{ $item->produto_nome }}
                            </td>
                            <td class="text-center fs-18px">
                                <span>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                <div class="input-group pt-1">
                                    <button type="button" class="input-group-text quant-minus"><i class="fa fa-minus-circle"></i></button>
                                    <input class="qty-text fs-16px" type="text" value="{{ $item->quantidade }}" data-id="{{ $item->id }}">
                                    <button type="button" class="input-group-text quant-plus"><i class="fa fa-plus-circle"></i></button>
                                </div>
                            </td>
                            <td class="text-center fs-18px">
                                <span>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-icon btn-circle" href="javascript:void(0);" onclick="location.href='{{ url('carrinho/produto/remover/'.$item->id) }}'">
                                    <i class="fa fa-times text-theme"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="fw-800 fs-18px">
                        <td class="text-end" colspan="3">
                            TOTAL
                        </td>
                        <td class="text-center">
                            R$ {{ number_format($venda->total_liquido, 2, ',', '.') }}
                        </td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif
</div>

<form id="form_item_update" action="{{ url('carrinho/produto/quantidade') }}" method="post">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="quantidade">
</form>
