<div class="card mb-3">
    <div class="card-body border">
        <form id="form_pagamentos" action="{{ url('carrinho/fatura/adicionar') }}" method="POST">
            <input type="hidden" name="venda_id" value="{{ $venda->id }}">
            <input type="hidden" name="troco" value="0,00">
            @csrf
            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label required" for="valor_recebido">Valor</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control form-control-lg money" id="valor_recebido" name="valor_recebido" value="" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label required" for="tipo_pagamento">Tipo Pagamento</label>
                    <select class="form-select form-select-lg fn-show" name="tipo_pagamento" required>
                        <option value="0">0: À vista</option>
                        <option value="1">1: À prazo</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="forma_pagamento">Forma Pagamento</label>
                    <select class="form-select form-select-lg" name="forma_pagamento" required>
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
                    <input class="form-control form-control-lg" type="date" value="2024-10-24" name="data_vencimento">
                </div>
                <div class="col-md-3" data-show="tipo_pagamento-1">
                    <label class="form-label">Número de Parcelas</label>
                    <input type="number" value="1" name="total_parcelas" class="form-control form-control-lg text-center" min="1" max="99">
                </div>
                <div class="col-md-3" data-show="tipo_pagamento-1">
                    <label class="form-label">Dias entre Parcelas</label>
                    <div class="input-group">
                        <input class="form-control form-control-lg" type="number" value="30" name="dias_parcelas">
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
                <div class="col-md-2 offset-10 text-end">
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
                            <th class="text-start w-200px">Tipo Pagamento</th>
                            <th class="text-center w-225px">Forma Pagamento</th>
                            <th class="text-center w-175px">Data Vencimento</th>
                            <th class="text-center w-175px">Parcelas</th>
                            <th class="text-center w-175px">Valor Fatura</th>
                            <th class="text-center w-100px">Status</th>
                            <th class="text-end w-50px"></th>
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
                                        Pagamento Instantâneo (PIX)
                                    @endif
                                </td>
                                <td class="text-center fs-18px">
                                    {{ \Illuminate\Support\Carbon::parse($fatura->data_vencimento)->format('d/m/Y') }}
                                </td>
                                <td class="text-center fs-18px">
                                    {{ str($fatura->numero_parcela)->padLeft(2,0) }}/{{ str($fatura->total_parcelas)->padLeft(2,0) }}
                                </td>
                                <td class="text-center fs-18px">
                                    <span>R$ {{ number_format($fatura->valor_subtotal, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-center fs-18px">
                                    @if($fatura->status == 1)
                                        <span class="badge bg-success ms-2">Concluido</span>
                                    @else
                                        <span class="badge bg-warning ms-2">Em aberto</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-icon btn-circle" href="javascript:void(0);" onclick="location.href='{{ url('carrinho/fatura/remover/'.$fatura->id) }}'">
                                        <i class="fa fa-times text-theme"></i>
                                    </a>
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
</script>
