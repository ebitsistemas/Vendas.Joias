@extends('layout.template', ['menu' => '', 'submenu' => ''])

@section('title', 'Home')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <img src="{{ url('assets/images/logo.png') }}" class="img-fluid" style="max-height: 300px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-home text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Home</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('dashboard') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-chart-line text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Dashboard</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('cliente') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-user text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Clientes</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('produto') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-box text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Produtos</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('categoria') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-sitemap text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Categorias</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('grupo') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-folder-tree text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Grupos</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('venda') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-shopping-cart text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Vendas</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('usuario') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-user-shield text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Usuários</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                <div class="card">
                    <a href="{{ url('configuracao') }}" class="card-body bg-theme-light-hover border border-2 p-2">
                        <div class="text-center py-3">
                            <i class="fal fa-cogs text-theme fs-44px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-26px mt-3">Config.</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
