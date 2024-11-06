@extends('layout.template', ['menu' => 'cliente', 'submenu' => $method])

@section('title', 'Clientes')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body border card-scroll h100p">
                        @if($method == 'update')
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <a href="{{ url('cliente/historico/'.$cliente->id) }}" class="btn btn-lg btn-theme w-100 d-flex align-items-center justify-content-center submit">
                                    <i class="fa fa-shopping-cart fz-16 me-2"></i> Histórico Vendas
                                </a>
                            </div>
                            <div class="col-md-6 d-none">
                                <a href="{{ url('cliente/faturas/'.$cliente->id) }}" class="btn btn-lg btn-theme w-100 d-flex align-items-center justify-content-center submit">
                                    <i class="fa fa-circle-dollar fz-16 me-2"></i> Histórico Faturas
                                </a>
                            </div>
                        </div>

                        <hr class="separator">
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                @include('cliente.partials.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="p-2"></span>
@endsection

