@extends('layout.template')

@section('title', 'Carrinho')

@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
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
                                <p class="mb-0 text-truncate">
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
            <a href="{{ url('produto/buscar') }}" class="btn btn-theme p-3 mb-3">
                <i class="fa fa-box me-1"></i> Selecionar Produto
            </a>

            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0 text-center">
                        <thead>
                        <tr>
                            <th scope="col">Imagem</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($produtos as $produto)
                        <tr class="border-bottom">
                            <th scope="row">
                                <img src="{{ url('storage/'.$produto->imagem) }}" alt="">
                            </th>
                            <td>
                                <h6 class="mb-1">{{ $produto->nome }}</h6>
                            </td>
                            <td>
                                <span>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</span>
                            </td>
                            <td>
                                <div class="quantity">
                                    <input class="qty-text" type="number" value="1">
                                </div>
                            </td>
                            <td>
                                <span>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</span>
                            </td>
                            <td>
                                <a class="remove-product border border-danger" href="#">
                                    <i class="fal fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if (isset($venda))
                <div class="card-body">
                    <div class="apply-coupon">
                        <div class="coupon-form">
                            <a class="btn btn-theme fs-20px p-2 w-100 my-3" href="{{ url('carrinho/checkout/'.$venda->id) }}">Finalizar</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
