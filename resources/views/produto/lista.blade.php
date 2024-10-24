@extends('layout.template', ['menu' => 'produto', 'submenu' => ''])

@section('title', 'Produtos')

@section('content')
    <div class="container">
        <x-search method="produto" search="{{ $pesquisa ?? '' }}"/>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
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

                                        <div class="chat-user-info text-center w-100px">
                                            <h6 class="mb-0 fs-18px mb-1">Status</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 fs-16px">
                                                    @if($produto->status == 1)
                                                        <span class="badge bg-success ms-2">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger ms-2">Inativo</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropstart chat-options-btn">
                                        <button class="btn btn-icon dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="p-2"><a href="produto/editar/{{ $produto->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                            <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $produto->nome }}" data-method="produto" data-id="{{ $produto->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
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
@endsection
