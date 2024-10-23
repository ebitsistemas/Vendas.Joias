@extends('layout.template')

@section('title', 'Produtos')

@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    <div class="chat-search-box">
                                        <form action="{{ url('categoria') }}" method="post">
                                            @csrf
                                            <div class="input-group">
                                                <span class="input-group-text px-3" id="searchbox">
                                                  <i class="bi bi-search"></i>
                                                </span>
                                                <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $pesquisa ?? '' }}" placeholder="Buscar">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

                                        <button class="btn" type="button" title="Selecionar Produto">
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
    </section>
@endsection
