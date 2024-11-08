@extends('layout.template', ['menu' => 'Carrinho', 'submenu' => ''])

@section('title', 'Carrinho')

@section('content')
    <div class="container pt-3 mb-5">
        <div class="standard-tab">
            <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn text-theme active" id="geral-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#geral"
                            type="button"
                            role="tab"
                            aria-controls="geral"
                            aria-selected="true">
                        Geral
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn text-theme" id="pagamento-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#pagamento"
                            type="button"
                            role="tab"
                            aria-controls="pagamento"
                            aria-selected="false">
                        Pagamento
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn text-theme" id="outros-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#outros"
                            type="button"
                            role="tab"
                            aria-controls="outros"
                            aria-selected="false">
                        Outros
                    </button>
                </li>
            </ul>

            <div class="tab-content border-0 pt-2" id="affanTabs1Content">
                <div class="tab-pane fade show active" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                    @include('carrinho.partials.cliente')
                    @include('carrinho.partials.produto')
                </div>
                <div class="tab-pane fade" id="pagamento" role="tabpanel" aria-labelledby="pagamento-tab">
                    @include('carrinho.partials.pagamento')
                </div>
                <div class="tab-pane fade" id="outros" role="tabpanel" aria-labelledby="outros-tab">
                    @include('carrinho.partials.anotacao')
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body border">
                    <div class="row">
                        @php($total = $venda->faturas->sum('valor_subtotal'))
                        @php($saldo = $total - $venda->total_liquido)
                        <div class="col-4">
                            <!-- Single Counter -->
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0">
                                    R$ <span class="counter">{{ number_format($venda->total_liquido, 2, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">TOTAL DA VENDA</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <!-- Single Counter -->
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0">
                                    R$ <span class="counter">{{ number_format($total, 2, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">TOTAL DAS FATURAS</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <!-- Single Counter -->
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0 @if($saldo < 0) text-danger @else text-primary @endif">
                                    R$ <span class="counter">{{ number_format($venda->saldo, 2, ',', '.') }}</span>
                                </h4>
                                <p class="mb-0 fz-12">SALDO</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-body border">
                    <div class="apply-coupon">
                        <div class="coupon-form">
                            <a href="{{ url('venda/imprimir/'.$venda->id) }}" class="btn btn-theme fs-20px p-2 w-100 my-3" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="p-2"></span>

    <script>
        console.log(null);
        $(document).on('blur', '#valor_unitario', function () {
            calculaSubtotal();
        });

        $(document).on('change', '#quantidade', function () {
            calculaSubtotal();
        });

        function calculaSubtotal() {
            var valor = $('#valor_unitario').val();
            var quantidade = $('#quantidade').val();
            valor = valor.replace('.', '');
            valor = valor.replace(',', '.');

            var subtotal = Number(quantidade) * Number(valor);
            $('#subtotal').val(number_format(subtotal, 2, ',', '.'));
        }

        $(document).on('click', '.quant-minus', function () {
            var $quant = $(this).parent('div.input-group').find('.qty-text');
            var quantidade = $quant.val();
            var id = $quant.data('id');
            var $form = $('#form_item_update');

            $form.find('input[name=quantidade]').val(Number(quantidade) - 1);
            $form.find('input[name=id]').val(id);
            $form.submit();
        });

        $(document).on('click', '.quant-plus', function () {
            var $quant = $(this).parent('div.input-group').find('.qty-text');
            var quantidade = $quant.val();
            var id = $quant.data('id');
            var $form = $('#form_item_update');

            $form.find('input[name=quantidade]').val(Number(quantidade) + 1);
            $form.find('input[name=id]').val(id);
            $form.submit();
        });

        $(document).on('click', '.add-pagamento', function () {
            var $form = $('#form_pagamentos');
            var $valor = $form.find('input[name=valor_recebido]');
            var valor = Number($valor.val());

            $form.submit();
        });

        $(document).on('click', '.fn-salvar', function () {
            var $form = $('#form_notas');

            $form.submit();
        });
    </script>
@endsection
