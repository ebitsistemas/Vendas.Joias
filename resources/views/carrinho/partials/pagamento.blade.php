<div class="card mb-3">
    <div class="card-body border">
        <form id="form_pagamentos" action="{{ url('carrinho/fatura/adicionar') }}" method="POST">
            <input type="hidden" name="venda_id" id="venda_id" value="{{ $venda->id }}">
            <input type="hidden" name="troco" id="troco" value="0,00">
            <input type="hidden" name="id" id="id">
            @csrf
            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label required" for="valor_recebido">Valor</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fn-saldo">R$</span>
                        <input type="text" class="form-control form-control-lg mask-money" id="valor_recebido" name="valor_recebido" value="" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label required" for="tipo_pagamento">Tipo Pagamento</label>
                    <select class="form-select form-select-lg fn-show" name="tipo_pagamento" id="tipo_pagamento" required>
                        <option value="0">0: À vista</option>
                        <option value="1">1: À prazo</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="forma_pagamento">Forma Pagamento</label>
                    <select class="form-select form-select-lg" name="forma_pagamento" id="forma_pagamento" required>
                        <option value="01" selected>01: Dinheiro</option>
                        <option value="03">03: Cartão de Crédito</option>
                        <option value="04">04: Cartão de Débito</option>
                        <option value="05">05: Duplicata</option>
                        <option value="15">15: Boleto Bancário</option>
                        <option value="16">16: Depósito Bancário</option>
                        <option value="17">17: Pagamento Instantâneo (PIX)</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2 d-none" data-show="tipo_pagamento-1">
                <div class="col-md-3" data-show="tipo_pagamento-1">
                    <label class="form-label">Data do Pagamento</label>
                    <input class="form-control form-control-lg mask-date" type="date" value="" name="data_vencimento" id="data_vencimento">
                </div>
                <div class="col-md-3" data-show="tipo_pagamento-1">
                    <label class="form-label">Número de Parcelas</label>
                    <input type="number" value="1" name="total_parcelas" id="total_parcelas" class="form-control form-control-lg text-center" min="1" max="99">
                </div>
                <div class="col-md-3" data-show="tipo_pagamento-1">
                    <label class="form-label">Dias entre Parcelas</label>
                    <div class="input-group">
                        <input class="form-control form-control-lg" type="number" value="30" name="dias_parcelas" id="dias_parcelas">
                        <span class="input-group-text dias-parcelas"> dias </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Valor por Parcela</label>
                    <div class="input-group">
                        <span class="input-group-text"> R$ </span>
                        <input type="text" name="valor_parcela" id="valor_parcela" class="form-control form-control-lg mask-money" value="0,00" readonly="">
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <button type="button" class="btn btn-icon btn-theme add-pagamento"><i class="fa fa-plus-circle"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body border">
        @if(empty($venda->faturas))
            <div class="alert custom-alert-three alert-info alert-dismissible fade show" role="alert">
                <div class="row">
                    <div class="col text-center pt-3">
                        <i class="fal fa-shopping-cart fs-60px"></i>

                        <div class="alert-text p-3">
                            <h6>Carrinho vazio!</h6>
                            <span>Nenhum produto adicionado ao pedido de venda.</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card cart-table border mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0 text-center">
                        <thead>
                        <tr>
                            <th class="text-start w-175px">Tipo Pagamento</th>
                            <th class="text-center w-225px">Forma Pagamento</th>
                            <th class="text-center w-175px">Data Pagamento</th>
                            <th class="text-center w-175px">Parcelas</th>
                            <th class="text-center w-175px">Valor Fatura</th>
                            <th class="text-center w-100px">Status</th>
                            <th class="text-end w-100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($saldo = 0)
                        @foreach($venda->faturas as $fatura)
                            <tr class="border-bottom">
                                <td class="text-start fs-18px">
                                    @if($fatura->tipo_pagamento == 0)
                                        À vista
                                    @else
                                        À prazo
                                    @endif
                                </td>
                                <td class="text-center fs-18px">

                                    @if($fatura->forma_pagamento == '01')
                                        Dinheiro
                                    @elseif($fatura->forma_pagamento == '03')
                                        Cartão de Crédito
                                    @elseif($fatura->forma_pagamento == '04')
                                        Cartão de Débito
                                    @elseif($fatura->forma_pagamento == '05')
                                        Duplicata
                                    @elseif($fatura->forma_pagamento == '15')
                                        Boleto Bancário
                                    @elseif($fatura->forma_pagamento == '16')
                                        Depósito Bancário
                                    @elseif($fatura->forma_pagamento == '17')
                                        PIX
                                    @endif
                                </td>
                                <td class="text-center fs-18px">
                                    {{ \Illuminate\Support\Carbon::parse($fatura->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="text-center fs-18px">
                                    {{ str($fatura->numero_parcela)->padLeft(2,0) }}/{{ str($fatura->total_parcelas)->padLeft(2,0) }}
                                </td>
                                <td class="text-center fs-18px">
                                    <span>R$ {{ number_format($fatura->valor_subtotal, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-center fs-18px">
                                    {!! $fatura->situacaoFatura->label !!}
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-icon btn-circle btn-light btn-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="p-2"><a href="javascript:void(0);" class="text-primary fs-16px fn-editar" data-id="{{ $fatura->id }}" data-value='{{ json_encode($fatura) }}'><i class="fad fa-edit fs-16px"></i> Editar</a></li>
                                        <li class="p-2"><a href="{{ url('fatura/pagar/'.$fatura->id) }}" class="text-success fs-16px"><i class="fad fa-check-circle fs-16px"></i> Pagar</a></li>
                                        <li class="p-2"><a href="{{ url('venda/comprovante/'.$fatura->id) }}" target="_blank" class="text-theme fs-16px"><i class="fad fa-file-invoice-dollar fs-16px"></i> Comprovante </a></li>
                                        <li class="px-2 py-0"><hr class="border-secondary"></li>
                                        <li class="p-2"><a class="text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $fatura->id }}" data-method="fatura" data-id="{{ $fatura->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    $(document).on('blur', '#valor_recebido', function () {
        var valor = $(this).val();

       $('#valor_parcela').val(valor);
    });

    $(document).on('click', '.fn-saldo', function () {
        var saldo = $('#saldoCarrinho').val();

        $('#valor_recebido').val(saldo);
    })

    $(document).on('click', '.fn-editar', function () {
        var value = $(this).data('value');
        $('#tipo_pagamento').val(value.tipo_pagamento).trigger('change');
        $('#forma_pagamento').val(value.forma_pagamento).trigger('change');
        $('#data_vencimento').val(value.data_vencimento);
        $('#dias_parcelas').val(value.dias_parcelas);
        $('#total_parcelas').val(value.total_parcelas);
        $('#valor_recebido').val(number_format(value.valor_recebido, 2, ',', '.'));
        $('#valor_parcela').val(number_format(value.valor_parcela, 2, ',', '.'));
        $('#id').val(value.id);
    });
</script>
