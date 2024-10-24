@extends('layout.template', ['menu' => 'produto', 'submenu' => 'Buscar'])

@section('title', 'Buscar Produtos')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-9 pe-1 pt-1">
                        <form action="{{ url('produto/buscar') }}" method="post">
                            @csrf
                            <div class="input-group">
                        <span class="input-group-text px-3">
                          <i class="fal fa-search"></i>
                        </span>
                                <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $pesquisa }}" placeholder="Buscar">
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3 ps-1 pt-1">
                        <a href="{{ url('produto/cadastrar') }}" class="btn btn-theme w-100" style="padding: 14px;"><i class="fad fa-plus-circle"></i> Cadastrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
                <div class="row pt-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list mb-3">
                            @foreach($produtos as $produto)
                                <li class="p-3">
                                    <a class="d-flex" href="{{ route('carrinho.produto.adicionar', $produto->id) }}" title="Selecionar Produto">
                                        <div class="chat-user-info w-100px">
                                            <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ str($produto->id)->padLeft(6,0) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-410px">
                                            <h6 class="mb-0 fs-18px mb-1">{{ $produto->nome }}</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ $produto->categoria->nome ?? '---' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-100px">
                                            <h6 class="mb-0 fs-18px mb-1">Valor</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>

                                    <button class="btn" type="button" onclick="window.location.href='{{ url('carrinho/produto/adicionar/'.$produto->id) }}'" title="Selecionar Produto">
                                        <i class="fa fa-angle-right fs-24px text-theme"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-7">
                        {{ $produtos->links() }}
                    </div>
                    <div class="col-5 py-2 text-end">
                        Página {{ $produtos->currentPage() }} de  {{ $produtos->lastPage() }} - {{ $produtos->total() }} registros encontrados
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
