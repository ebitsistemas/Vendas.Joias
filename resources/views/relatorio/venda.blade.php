@extends('layout.template', ['menu' => 'relatorio', 'submenu' => 'Venda'])

@section('title', 'Relatório Venda')

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-body border">
                <form method="post" action="{{ url('relatorio/venda') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Tipo Data</label>
                            <select class="form-select form-select-lg" name="tipo_data">
                                <option value="1" @if($request->tipo_data == 1) selected @endif>Data da Venda</option>
                                <option value="2" @if($request->tipo_data == 2) selected @endif>Data de Confirmação</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Data Inicial</label>
                            <input class="form-control form-control-lg mask-date" id="data_inicial" name="data_inicial" value="{{ $request->data_inicial ?? '' }}">
                        </div>

                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Data Final</label>
                            <input class="form-control form-control-lg mask-date" id="data_final" name="data_final" value="{{ $request->data_final ?? '' }}">
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

        @if(!empty($vendas))
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
                                    <th>Data Venda</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($total = 0)
                                @foreach($vendas as $venda)
                                    @php($total += $venda->total_liquido)
                                    <tr>
                                        <td>
                                            {{ str($venda->id)->padLeft(6,0) }}
                                        </td>
                                        <td>{{ $venda->cliente->nome ?? '' }}</td>
                                        <td>
                                            R$ {{ number_format($venda->total_liquido, 2, ',', '.') }}
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($venda->data_venda)) }}</td>
                                        <td>{!! $venda->situacao->label !!}</td>
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
