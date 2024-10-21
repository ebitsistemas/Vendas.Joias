@extends('layout.template')

@section('title', 'Buscar Produto')

@section('content')
<div class="top-products-area">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body p-2">
                        <div class="chat-search-box">
                            <form action="{{ url('produto/buscar') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <span class="input-group-text px-3" id="searchbox">
                                      <i class="bi bi-search"></i>
                                    </span>
                                    <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $pesquisa }}" placeholder="Buscar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 g-3">
            @foreach($produtos as $produto)
                <div class="col-6 col-sm-4 col-lg-3">
                    <div class="card single-product-card">
                        <div class="card-body p-3">
                            <a class="product-thumbnail d-block" href="javascript:void(0);">
                                <img src="{{ url('storage/'.$produto->imagem) }}">
                            </a>
                            <a class="product-title d-block text-truncate" href="javascript:void(0);">{{ $produto->nome }}</a>
                            <p class="sale-price">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                            <a class="btn btn-primary rounded-pill btn-sm" href="{{ route('carrinho.produto.adicionar', $produto->id) }}"><i class="fa fa-plus fw-bold"></i> Adicionar</a>
                        </div>
                    </div>
                </div>
            @endforeach
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

@endsection
