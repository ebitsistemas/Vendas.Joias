@extends('layout.template', ['menu' => 'cliente', 'submenu' => 'Histórico'])

@section('title', 'Clientes')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="row">
                <div class="col-6">
                    <div class="alert alert-success d-flex align-items-center p-5">
                        <span class="svg-icon me-3"><i class="fad fa-check-circle text-success fs-1"></i></span>

                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Sucesso</h4>
                            <span>{{ session('mensagem') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(session('erro'))
            <div class="row">
                <div class="col-6">
                    <div class="alert alert-danger d-flex align-items-center p-5">
                        <span class="svg-icon me-3"><i class="fad fa-check-circle text-danger fs-1"></i></span>

                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Erro</h4>
                            <span>{{ session('erro') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body border card-scroll h100p">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <ul class="ps-0 chat-user-list mb-3">
                                    @foreach($pagamentos as $pagamento)
                                        <li class="p-3">
                                            <a class="d-flex">
                                                <div class="chat-user-info w-100px">
                                                    <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                                    <div class="last-chat">
                                                        <p class="mb-0 text-truncate fs-16px">
                                                            {{ str($pagamento->id)->padLeft(6,0) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="chat-user-info w-375px">
                                                    <h6 class="mb-0 fs-18px mb-1">{{ $pagamento->cliente->nome ?? 'Não informado' }}</h6>
                                                    <div class="last-chat">
                                                        <p class="mb-0 text-truncate fs-16px">
                                                            {{ $pagamento->cliente->documento ?? '' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="chat-user-info w-150px">
                                                    <h6 class="mb-0 fs-18px mb-1">Valor Recebido</h6>
                                                    <div class="last-chat">
                                                        <p class="mb-0 text-truncate fs-16px">
                                                            R$ {{ number_format($pagamento->valor_recebido, 2, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="chat-user-info w-200px">
                                                    <h6 class="mb-0 fs-18px mb-1">Data do Recebimento</h6>
                                                    <div class="last-chat">
                                                        <p class="mb-0 text-truncate fs-16px">
                                                            {{ date('d/m/Y', strtotime($pagamento->data_pagamento)) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="chat-user-info text-center w-150px">
                                                    <h6 class="fs-18px mb-1">Status</h6>
                                                    <div class="last-chat">
                                                        <p class="mb-0 fs-16px">
                                                            {!! $pagamento->situacaoFatura->label !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropstart chat-options-btn">
                                                <button class="btn btn-icon btn-circle btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li class="p-2 mt-3"><a class="dropdown-item text-danger fs-20px mt-1 fn-remover" href="javascript:void(0);" data-content="{{ $pagamento->id }}" data-method="pagamentos" data-id="{{ $pagamento->id }}"><i class="fad fa-ban fs-16px"></i> Cancelar</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-7">
                                {{ $pagamentos->links() }}
                            </div>
                            <div class="col-5 py-2 text-end">
                                Página {{ $pagamentos->currentPage() }} de  {{ $pagamentos->lastPage() }} - {{ $pagamentos->total() }} registros encontrados
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
