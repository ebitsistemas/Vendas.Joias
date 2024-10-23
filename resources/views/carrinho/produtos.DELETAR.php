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
                                    <input class="form-control" type="search" placeholder="Buscar 123" aria-describedby="searchbox">
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
                        <a class="product-thumbnail d-none" href="javascript:void(0);">
                            <img src="{{ url('storage/'.$produto->imagem) }}">
                        </a>
                        <a class="product-title d-block text-truncate" href="javascript:void(0);">{{ $produto->nome }}</a>
                        <p class="sale-price">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                        <a class="btn btn-primary rounded-pill btn-sm add" data-id="{{ $produto->id }}" href="javascript:void(0);"><i class="fa fa-plus fw-bold"></i> Adicionar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.add', function () {
        var id = $(this).data('id');
        var venda_id = null;
        if (localStorage.getItem("venda_id") !== null) {
            venda_id = localStorage.getItem("venda_id");
        }

        $.ajax({
            type: 'POST',
            url: 'venda/add',
            data: {
                id: id,
                venda_id: venda_id,
                _token: $("input[name*='_token']").val(),
            },
            beforeSend: function () {
                toastr.info('Aguarde, salvando...!');
            },
            success: function (data) {

            },
            error: function (data) {

            }
        });
    });

    function addVenda() {
        $.ajax({
            type: 'POST',
            url: 'venda/add',
            data: {
                id: id,
                venda_id: venda_id,
                _token: $("input[name*='_token']").val(),
            },
            beforeSend: function () {
                toastr.info('Aguarde, salvando...!');
            },
            success: function (data) {

            },
            error: function (data) {

            }
        });
    }
</script>
@endsection
