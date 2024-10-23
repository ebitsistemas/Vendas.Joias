@extends('layout.template')

@section('title', 'Clientes')

@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class="title">
                        <h4 class="text-theme">Clientes</h4>
                        <a href="{{ url('cliente/cadastrar') }}" class="btn btn-theme"><i class="fad fa-plus-circle"></i> Cadastrar</a>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    <div class="chat-search-box">
                                        <form action="{{ url('cliente') }}" method="post">
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
                            @foreach($clientes as $cliente)
                            <li class="p-3">
                                <a class="d-flex">
                                    <div class="chat-user-thumbnail me-3 shadow">
                                        @if(empty($cliente->imagem))
                                            <img class="img-circle" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                                        @else
                                            <img class="img-circle" src="{{ url('storage/'.$cliente->imagem) }}" alt="">
                                        @endif
                                    </div>

                                    <div class="chat-user-info w-100px">
                                        <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                        <div class="last-chat">
                                            <p class="mb-0 text-truncate fs-16px">
                                                {{ str($cliente->id)->padLeft(6,0) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="chat-user-info w-500px">
                                        <h6 class="mb-0 fs-18px mb-1">{{ $cliente->nome }} - {{ $cliente->documento }}</h6>
                                        <div class="last-chat">
                                            <p class="mb-0 text-truncate fs-16px">
                                                {{ $cliente->logradouro }}, {{ $cliente->numero }} - {{ $cliente->cidade }}-{{ $cliente->uf }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="chat-user-info text-center w-100px">
                                        <h6 class="mb-0 fs-18px mb-1">Status</h6>
                                        <div class="last-chat">
                                            <p class="mb-0 fs-16px">
                                                @if($cliente->status == 1)
                                                    <span class="badge bg-success ms-2">Ativo</span>
                                                @else
                                                    <span class="badge bg-danger ms-2">Inativo</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropstart chat-options-btn">
                                    <button class="btn btn-icon btn-circle btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-white fs-16px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="p-2"><a href="cliente/editar/{{ $cliente->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                        <li class="p-2"><a href="cliente/imprimir/{{ $cliente->id }}" class="fs-16px"><i class="fad fa-print fs-16px"></i> Imprimir</a></li>
                                        <li class="p-2"><a href="cliente/compartilhar/{{ $cliente->id }}" class="fs-16px"><i class="fad fa-share-nodes fs-16px"></i> Compartilhar</a></li>
                                        <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $cliente->nome }}" data-method="cliente" data-id="{{ $cliente->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                    </ul>
                                </div>
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
    </section>
@endsection
