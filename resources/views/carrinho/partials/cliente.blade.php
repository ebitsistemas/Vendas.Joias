<ul class="ps-0 chat-user-list mb-3">
    <li class="p-3">
        <span class="d-flex">
            @if(isset($venda->cliente))
                <div class="chat-user-thumbnail me-3 shadow">
                    <img class="img-circle" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
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

        <span class="text-end">
        @if(isset($venda->cliente) && !empty($venda->cliente))
            <a class="btn" href="{{ route('carrinho.cliente.remover', $venda->id) }}" title="Remover Cliente">
                <i class="fa fa-times fs-26px text-theme"></i>
            </a>
        @else
            <button class="btn" type="button" onclick="location.href='{{ url('cliente/buscar/'.$venda->id) }}'" title="Buscar Cliente">
                <i class="fa fa-angle-right fs-26px text-theme"></i>
            </button>
        @endif
        </span>
    </li>
</ul>
