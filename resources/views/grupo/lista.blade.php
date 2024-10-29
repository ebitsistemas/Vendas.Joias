@extends('layout.template', ['menu' => 'grupo', 'submenu' => ''])

@section('title', 'Grupos')

@section('content')
    <div class="container">
        <x-search method="cliente" search="{{ $pesquisa ?? '' }}"/>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">

                <div class="row pt-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list mb-3">
                            @foreach($grupos as $grupo)
                                <li class="p-3">
                                    <a class="d-flex">

                                        <div class="chat-user-info w-100px">
                                            <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    {{ str($grupo->id)->padLeft(6,0) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="chat-user-info w-410px">
                                            <h6 class="mb-0 fs-18px mb-1">{{ $grupo->nome }}</h6>
                                            <div class="last-chat">
                                                <p class="mb-0 text-truncate fs-16px">
                                                    Grupo Pai: {{ $grupo->grupo_pai->nome ?? '---' }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropstart chat-options-btn">
                                        <button class="btn btn-icon btn-circle btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="p-2"><a href="grupo/editar/{{ $grupo->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                            <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $grupo->nome }}" data-method="grupo" data-id="{{ $grupo->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-7">
                        {{ $grupos->links() }}
                    </div>
                    <div class="col-5 py-2 text-end">
                        Página {{ $grupos->currentPage() }} de  {{ $grupos->lastPage() }} - {{ $grupos->total() }} registros encontrados
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
