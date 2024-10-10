@extends('layout.template')

@section('title', 'Grupos')

@section('content')
<div class="top-products-area">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <div class="chat-search-box">
                            <!-- Search Form -->
                            <form action="#">
                                <div class="input-group">
                                    <span class="input-group-text" id="searchbox">
                                      <i class="bi bi-search"></i>
                                    </span>
                                    <input class="form-control" type="search" placeholder="Buscar" aria-describedby="searchbox">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @foreach($produtos as $produto)
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card single-product-card">
                    <div class="card-body p-3">
                        <a class="product-thumbnail d-block" href="#">
                            <img src="{{ url('storage/'.$produto->imagem) }}" alt="">
                        </a>
                        <a class="product-title d-block text-truncate" href="#">{{ $produto->nome }}</a>
                        <p class="sale-price">{{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                        <a class="btn btn-primary rounded-pill btn-sm" href="#">Adicionar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
