@extends('layout.template', ['menu' => 'venda', 'submenu' => ''])

@section('title', 'Vendas')

@section('content')
    <div class="container">
        <x-search method="venda" search="{{ $pesquisa ?? '' }}"/>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
                <div class="row pt-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list mb-3">
                            @foreach($vendas as $venda)
                                <li class="p-3">
                                    <a class="d-flex">
                                        <div class="chat-user-info w-100px">
                                            <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ str($venda->id)->padLeft(6,0) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-375px">
                                            <h6 class="mb-0 fs-18px mb-1">{{ $venda->cliente->nome ?? 'Não informado' }}</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ $venda->cliente->documento ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-150px">
                                            <h6 class="mb-0 fs-18px mb-1">Valor</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    R$ {{ number_format($venda->total_liquido, 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-150px">
                                            <h6 class="mb-0 fs-18px mb-1">Saldo</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    R$ {{ number_format($venda->saldo, 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-200px">
                                            <h6 class="mb-0 fs-18px mb-1">Data da Venda</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ date('d/m/Y', strtotime($venda->data_venda)) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info text-center w-150px">
                                            <h6 class="fs-18px mb-1">Status</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 fs-16px">
                                                    {!! $venda->situacao->label !!}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropstart chat-options-btn">
                                        <button class="btn btn-icon btn-circle btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="p-2"><a href="venda/editar/{{ $venda->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                            <li class="p-2"><a href="venda/imprimir/{{ $venda->id }}" target="_blank" class="fs-16px"><i class="fad fa-print fs-16px"></i> Imprimir</a></li>
                                            <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $venda->id }}" data-method="venda" data-id="{{ $venda->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-7">
                        {{ $vendas->links() }}
                    </div>
                    <div class="col-5 py-2 text-end">
                        Página {{ $vendas->currentPage() }} de  {{ $vendas->lastPage() }} - {{ $vendas->total() }} registros encontrados
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
