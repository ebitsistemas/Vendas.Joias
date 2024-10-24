@extends('layout.template', ['menu' => 'Clientes', 'submenu' => 'Buscar'])

@section('title', 'Buscar Cliente')

@section('content')
<div class="top-products-area">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body p-2">
                        <div class="chat-search-box">
                            <form action="{{ url('cliente/buscar') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <span class="input-group-text px-3" id="searchbox">
                                      <i class="bi bi-search"></i>
                                    </span>
                                    <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $pesquisa }}" placeholder="Buscar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 g-3">
            <div class="col-12">
                <ul class="ps-0 chat-user-list">
                @foreach($clientes as $cliente)
                    <li class="p-3 chat-unread">
                        <a class="d-flex" href="{{ route('carrinho.cliente.adicionar', $cliente->id) }}" title="Selecionar Cliente">
                            <div class="chat-user-thumbnail me-3 shadow">
                                <img class="img-circle" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                            </div>

                            <div class="chat-user-info">
                                <h6 class="mb-0">{{ $cliente->nome }} - {{ $cliente->documento }} </h6>
                                <div class="last-chat">
                                    <p class="mb-0 text-muted">
                                        {{ $cliente->logradouro }}, {{ $cliente->numero }} - {{ $cliente->bairro }} - {{ $cliente->cidade }}
                                    </p>
                                </div>
                            </div>
                        </a>

                        <button class="btn" type="button" title="Selecionar Cliente">
                            <i class="fa fa-angle-right fs-24px text-theme"></i>
                        </button>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-7">
                {{ $clientes->links() }}
            </div>
            <div class="col-5 py-2 text-end">
                Página {{ $clientes->currentPage() }} de  {{ $clientes->lastPage() }} - {{ $clientes->total() }} registros encontrados
            </div>
        </div>
    </div>
</div>

@endsection
