@extends('layout.template', ['menu' => 'cliente', 'submenu' => $method])

@section('title', 'Clientes')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body border card-scroll h100p">
                        <div class="minimal-tab">
                            <ul class="nav nav-tabs mb-3" id="affanTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="btn active" id="geral-tab" data-bs-toggle="tab" data-bs-target="#geral" type="button"
                                            role="tab" aria-controls="geral" aria-selected="true">Geral</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico" type="button" role="tab"
                                            aria-controls="historico" aria-selected="false">Histórico</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content rounded-lg p-3">
                            <div class="tab-pane fade show active" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                                @include('cliente.partials.form')
                            </div>
                            @if($method == 'update')
                            <div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
                                @include('cliente.partials.historico')
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="p-2"></span>
@endsection

