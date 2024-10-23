@extends('layout.template')

@section('title', 'Produtos')

@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class="title">
                        <h4 class="text-theme">Produtos</h4>
                        <a href="{{ url('produto/cadastrar') }}" class="btn btn-theme"><i class="fad fa-plus-circle"></i> Cadastrar</a>
                    </div>

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
                                        <a class="d-flex">

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
                                        <div class="dropstart chat-options-btn">
                                            <button class="btn btn-icon btn-circle btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-white fs-16px"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="p-2"><a href="categoria/editar/{{ $produto->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                                <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $produto->nome }}" data-method="cliente" data-id="{{ $produto->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                            </ul>
                                        </div>
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
