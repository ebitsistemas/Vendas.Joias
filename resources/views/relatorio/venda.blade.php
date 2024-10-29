@extends('layout.template', ['menu' => 'relatorio', 'submenu' => 'Venda'])

@section('title', 'Relatório Venda')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body border">
                <form method="post" action="{{ url('relatorio/cliente') }}" enctype="multipart/form-data">
                    @csrf
                    <h3 class="fs-22px text-theme">Relatório de Vendas</h3>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="fs-6 form-label">Tipo Data</label>
                            <select class="form-select form-select-lg" name="tipo_data" data-select="{{ $request->tipo_data ?? '' }}">
                                <option value="1">Data da Venda</option>
                                <option value="2">Data de Confirmação</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="fs-6 form-label">Data Inicial</label>
                            <input class="form-control form-control-lg mask-date" id="data_inicial" name="data_inicial" value="{{ $request->data_inicial ?? '' }}">
                        </div>

                        <div class="col-md-4">
                            <label class="fs-6 form-label">Data Final</label>
                            <input class="form-control form-control-lg mask-date" id="data_final" name="data_final" value="{{ $request->data_final ?? '' }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-8">
                            <label class="fs-6 form-label">Cliente</label>
                            <select class="form-select form-select-lg" name="cliente_id" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->cliente_id ?? '' }}">
                                <option value="">Todos</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ str($cliente->id)->padLeft(4,0) }}: {{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="fs-6 form-label">Status</label>
                            <select class="form-select form-select-lg" name="status" id="status" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->status ?? '' }}">
                                <option value="">Todos</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                                <option value="2">Bloqueado</option>
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

        @if(!empty($clientes))
            <div class="card">
                <div class="card-body border">
                    <div class="row pt-3">
                        <div class="col-12">
                            <table class="table mb-0 table-striped" id="table_clientes">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Endereço</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($total = 0)
                                @foreach($clientes as $cliente)
                                    @php($total += 1)
                                    <tr>
                                        <td>
                                            {{ str($cliente->id)->padLeft(6,0) }}
                                        </td>
                                        <td>{{ $cliente->nome }}</td>
                                        <td>
                                            {{ $cliente->logradouro }}, {{ $cliente->numero }}
                                            - {{ $cliente->cidade }}-{{ $cliente->uf }}
                                        </td>
                                        <td>
                                            @if($cliente->status == 1)
                                                <span class="badge bg-success ms-2">Ativo</span>
                                            @else
                                                <span class="badge bg-danger ms-2">Inativo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

        $('#limpa-filtros').on('click', function () {
            $('#tipo_data').val('');
            $('#data_inicial').val('');
            $('#data_final').val('');
            $('#cliente_id').val('');
            $('#status').val('');
        })
    </script>
@endsection
