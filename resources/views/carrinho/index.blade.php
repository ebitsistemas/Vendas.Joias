@extends('layout.template', ['menu' => 'Carrinho', 'submenu' => ''])

@section('title', 'Carrinho')

@section('content')
    <div class="container pt-3">
        <ul class="ps-0 chat-user-list mb-3">
            <li class="p-3">
                <span class="d-flex">
                @if(isset($venda->cliente))
                        <div class="chat-user-thumbnail me-3 shadow">
                        <img class="img-circle" src="{{ url('mobile/assets/img/user1.png') }}" alt="">
                    </div>

                        <div class="chat-user-info w-410px">
                        <h6 class="mb-0">{{ $venda->cliente->nome }} - {{ $venda->cliente->documento }}</h6>
                        <div class="last-chat">
                            <p class="mb-0 text-truncate">
                                {{ $venda->cliente->logradouro }}, {{ $venda->cliente->numero }}
                            </p>
                        </div>
                    </div>
                    @else
                        <div class="chat-user-thumbnail me-3 shadow">
                            <img class="img-circle" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                        </div>

                        <div class="chat-user-info w-410px">
                            <h6 class="mb-0">Nenhum cliente selecionado</h6>
                            <div class="last-chat">
                                <p class="mb-0 text-theme">
                                    Clique no botão ao lado para selecionar o cliente
                                </p>
                            </div>
                        </div>
                    @endif
                </span>

                <button class="btn" type="button" onclick="location.href='{{ url('cliente/buscar') }}'" title="Buscar Cliente">
                    <i class="fa fa-angle-right fs-26px text-theme"></i>
                </button>
            </li>
        </ul>

        <!-- Cart Wrapper -->
        <div class="cart-wrapper-area">
            <a class="btn btn-theme p-3 mb-3" data-bs-toggle="collapse" href="#addProduto" role="button" aria-expanded="false" aria-controls="addProduto">
                <i class="fa fa-box me-1"></i> Adicionar Produto
            </a>

            <div class="collapse mb-3" id="addProduto">
                <div class="card card-body border">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="nome">Produto</label>
                            <input type="text" class="form-control form-control-lg" id="nome_produto" name="nome_produto" value="" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="preco_venda">Preço Venda</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control form-control-lg form-control-cart text-end money" id="preco_venda_produto" name="preco_venda_produto" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="quantidade">Quantidade</label>
                            <input type="number" class="form-control form-control-lg form-control-cart text-center" id="quantidade" name="quantidade" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="subtotal">Subtotal</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control form-control-lg form-control-cart text-end money" id="subtotal" name="subtotal" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-9 pt-2">
                            <a href="{{ url('produto/buscar') }}" class="text-theme">Adicionar produto já cadastrado</a>
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="button" class="btn btn-icon btn-theme"><i class="fa fa-plus-circle"></i></button>
                        </div>
                    </div>
                </div>
            </div>

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
                        @foreach($produtos as $produto)
                            <tr class="border-bottom">
                                <td class="text-start fs-18px">
                                    {{ $produto->nome }}
                                </td>
                                <td class="text-center fs-18px">
                                    <span>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="input-group pt-1">
                                        <button type="button" class="input-group-text"><i class="fa fa-minus-circle"></i></button>
                                        <input class="qty-text fs-16px" type="text" value="1">
                                        <button type="button" class="input-group-text"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </td>
                                <td class="text-center fs-18px">
                                    <span>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-icon btn-circle" href="javascrit:void(0);">
                                        <i class="fa fa-times text-theme"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if (!isset($venda))
                    <div class="card-body">
                        <div class="apply-coupon">
                            <div class="coupon-form">
                                <a class="btn btn-theme fs-20px p-2 w-100 my-3" href="{{ url('carrinho/checkout/'.($venda->id ?? '')) }}">Finalizar <i class="fa fa-right-to-bracket"></i> </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        console.log(null);
        $(document).on('blur', '#preco_venda_produto', function () {
            calculaSubtotal();
        });

        $(document).on('change', '#quantidade', function () {
            calculaSubtotal();
        });

        function calculaSubtotal() {
            var valor = $('#preco_venda_produto').val();
            var quantidade = $('#quantidade').val();
            valor = valor.replace('.', '');
            valor = valor.replace(',', '.');

            var subtotal = Number(quantidade) * Number(valor);
            $('#subtotal').val(number_format(subtotal, 2, ',', '.'));
        }
    </script>
@endsection
