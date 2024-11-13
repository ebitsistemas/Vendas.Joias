@extends('layout.template', ['menu' => 'cliente', 'submenu' => 'Buscar'])

@section('title', 'Buscar Cliente')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-9 pe-1 pt-1">
                        <form action="{{ url('cliente/buscar/'.$venda_id) }}" method="post">
                            @csrf
                            <div class="input-group">
                                <button type="submit" class="input-group-text px-3">
                                  <i class="fal fa-search"></i>
                                </button>
                                <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $pesquisa }}" placeholder="Buscar">
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3 ps-1 pt-1">
                        <a href="{{ url('cliente/cadastrar') }}" class="btn btn-theme w-100" style="padding: 14px;"><i class="fad fa-plus-circle"></i> Cadastrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
                <div class="row mb-3 g-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list">
                            @foreach($clientes as $cliente)
                                <li class="p-3 chat-unread">
                                    <a class="d-flex" href="{{ url("carrinho/cliente/adicionar/{$venda_id}/{$cliente->id}") }}" title="Selecionar Cliente">
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

                                    <button class="btn" type="button" onclick="window.location.href='{{ url("carrinho/cliente/adicionar/{$venda_id}/{$cliente->id}") }}'" title="Selecionar Cliente">
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
    </div>
@endsection
