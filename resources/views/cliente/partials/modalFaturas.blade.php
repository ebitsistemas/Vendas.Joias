
<!-- Modal -->
<div class="modal fade" id="modalFaturas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFaturasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-theme fs-5" id="modalFaturasLabel">Baixar Faturas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_pagamentos" action="{{ url('venda/baixar/faturas') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label required" for="valor_recebido">Valor</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control form-control-lg mask-money" id="valor_recebido" name="valor_recebido" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data do Pagamento</label>
                            <input class="form-control form-control-lg mask-date" type="text" value="{{ date('d/m/Y') }}" name="data_pagamento" id="data_pagamento">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fad fa-check-circle fs-18px me-1"></i> Baixar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fad fa-times-circle fs-18px me-1"></i> Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
