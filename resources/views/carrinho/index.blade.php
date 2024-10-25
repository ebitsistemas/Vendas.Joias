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
                    <button class="btn text-theme" id="anotacao-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#anotacao"
                            type="button"
                            role="tab"
                            aria-controls="anotacao"
                            aria-selected="false">
                        Anotações
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
                <div class="tab-pane fade" id="anotacao" role="tabpanel" aria-labelledby="anotacao-tab">
                    @include('carrinho.partials.anotacao')
                </div>
            </div>

            @if (isset($venda))
                <div class="card">
                    <div class="card-body border">
                        <div class="apply-coupon">
                            <div class="coupon-form">
                                <button type="submit" class="btn btn-theme fs-20px p-2 w-100 my-3 fn-salvar"><i class="fa fa-save"></i> Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

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

        $(document).on('click', '.fn-salvar', function () {
            var $form = $('#form_notas');
            $form.submit();
        });

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
    </script>
@endsection
