@extends('layout.template', ['menu' => 'relatorio', 'submenu' => 'Financeiro'])

@section('title', 'Relatório Financeiro')

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-body border">
                <form method="post" action="{{ url('relatorio/financeiro') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Tipo Data</label>
                            <select class="form-select form-select-lg" name="tipo_data">
                                <option value="1" @if($request->tipo_data == 1) selected @endif>Data da Lançamento</option>
                                <option value="2" @if($request->tipo_data == 2) selected @endif>Data de Vencimento</option>
                                <option value="1" @if($request->tipo_data == 3) selected @endif>Data da Confirmação</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Data Inicial</label>
                            <input class="form-control form-control-lg" type="date" id="data_inicial" name="data_inicial" value="{{ $request->data_inicial ?? '' }}">
                        </div>

                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Data Final</label>
                            <input class="form-control form-control-lg" type="date" id="data_final" name="data_final" value="{{ $request->data_final ?? '' }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="form-label" for="tipo_pagamento">Tipo Pagamento</label>
                            <select class="form-select form-select-lg fn-show" name="tipo_pagamento" id="tipo_pagamento">
                                <option value="">Todos</option>
                                <option value="0">0: À vista</option>
                                <option value="1">1: À prazo</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" for="forma_pagamento">Forma Pagamento</label>
                            <select class="form-select form-select-lg" name="forma_pagamento" id="forma_pagamento">
                                <option value="">Todos</option>
                                <option value="01">01: Dinheiro</option>
                                <option value="03">03: Cartão de Crédito</option>
                                <option value="04">04: Cartão de Débito</option>
                                <option value="05">05: Duplicata</option>
                                <option value="15">15: Boleto Bancário</option>
                                <option value="16">16: Depósito Bancário</option>
                                <option value="17">17: Pagamento Instantâneo (PIX)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <label class="fs-6 form-label">Cliente</label>
                            <select class="form-select form-select-lg" name="cliente_id" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->cliente_id ?? '' }}">
                                <option value="">Todos</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @if($request->cliente_id == $cliente->id) selected @endif>{{ str($cliente->id)->padLeft(4,0) }}: {{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Status</label>
                            <select class="form-select form-select-lg" name="status" id="status" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->status ?? '' }}">
                                <option value="">Todos</option>
                                @foreach($situacoes as $situacao)
                                    <option value="{{ $situacao->codigo }}" @if($request->status == $situacao->codigo) selected @endif>{{ $situacao->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary border me-3"><i
                                        class="fad fa-file-pdf"></i> Gerar Relatório
                                </button>
                                <button type="button" class="btn btn-danger limpa-filtros"><i class="fad fa-eraser"></i>
                                    Limpar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($faturas))
            <div class="card mb-5">
                <div class="card-body border pt-1">
                    <div class="row">
                        <div class="col-12">
                            <table class="table mb-0 table-striped" id="table_clientes">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                    <th>Data Lançamento</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($total = 0)
                                @foreach($faturas as $fatura)
                                    @php($total = $total + $fatura->valor_recebido)
                                    <tr>
                                        <td>
                                            {{ str($fatura->id)->padLeft(6,0) }}
                                        </td>
                                        <td>{{ $fatura->nome_cliente ?? '' }}</td>
                                        <td>
                                            R$ {{ number_format($fatura->valor_recebido, 2, ',', '.') }}
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($fatura->created_at)) }}</td>
                                        <td>{!! $fatura->situacaoFatura->label ?? ' -- ' !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h3 class="text-theme fs-22px text-end">TOTAL: R$ {{ number_format($total, 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        @endif
        <br>
        <br>
    </div>

    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script>
        $('#table_clientes').DataTable( {
            paging: false,
            searching:false,
            language: {
                info: "Exibindo _START_ a _END_ de _TOTAL_ itens",
            }
        });

        $('.limpa-filtros').on('click', function () {
            $('#tipo_data').val(1).trigger('change');
            $('#data_inicial').val('').trigger('change');
            $('#data_final').val('').trigger('change');
            $('#cliente_id').val('').trigger('change');
            $('#status').val('').trigger('change');
        });
    </script>
@endsection
