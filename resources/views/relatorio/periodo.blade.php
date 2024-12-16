@extends('layout.template', ['menu' => 'relatorio', 'submenu' => 'Período'])

@section('title', 'Relatório Período')

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-body border">
                <form method="post" action="{{ url('relatorio/periodo') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <label class="fs-6 form-label">Mês</label>
                            <select class="form-select form-select-lg" name="mes" id="mes" data-control="select2" data-hide-search="true">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if($request->mes == $i) selected @elseif($i == date('n')) selected @endif>{{ str($i)->padLeft(2, 0) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="fs-6 form-label">Ano</label>
                            <input type="number" class="form-control form-control-lg" id="ano" name="ano" min="2024" value="{{ $request->ano ?? date('Y') }}">
                        </div>
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Tipo Pessoa</label>
                            <select class="form-select form-select-lg" name="tipo_pessoa" data-control="select2" data-hide-search="true">
                                <option value="">Todos</option>
                                <option value="1" @if($request->tipo_pessoa == 1) selected @endif>Pessoa Física</option>
                                <option value="2" @if($request->tipo_pessoa == 2) selected @endif>Pessoa Jurídica</option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Grupo</label>
                            <select class="form-select form-select-lg" name="grupo_id" data-control="select2" data-hide-search="true">
                                <option value="">Todos</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" @if($request->grupo_id == $grupo->id) selected @endif>{{ $grupo->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Cidade</label>
                            <input class="form-control form-control-lg" id="cidade" name="cidade" value="{{ $request->cidade ?? '' }}">
                        </div>

                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Bairro</label>
                            <input class="form-control form-control-lg" id="bairro" name="bairro" value="{{ $request->bairro ?? '' }}">
                        </div>
                        <div class="col-sm-4">
                            <label class="fs-6 form-label">Status</label>
                            <select class="form-select form-select-lg" name="status" id="status" data-control="select2"
                                    data-hide-search="true">
                                <option value="">Todos</option>
                                <option value="1" @if($request->status == 1) selected @endif>Ativo</option>
                                <option value="2" @if($request->status == 2) selected @endif>Inativo</option>
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
            <div class="card mb-5">
                <div class="card-body border pt-1">
                    <div class="row">
                        <div class="col-12">
                            <table class="table mb-0 table-striped" id="table_clientes">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Data Cobrança</th>
                                    <th>Saldo</th>
                                    <th>Cobrado?</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                        <tr>
                                            <td>
                                                {{ str($cliente->id)->padLeft(6,0) }}
                                            </td>
                                            <td>{{ $cliente->nome }}</td>
                                            <td class="text-center">
                                                {{ date($cliente->dia_cobranca.'/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($cliente->saldoTotal, 2, ',', '') }}
                                            </td>
                                            <td>
                                                @if($cliente->cobrado_status == 1)
                                                    <form action="{{ url('venda/cobrado') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                                                        <input type="hidden" name="mes" value="{{ $request->mes ?? date('n') }}">
                                                        <input type="hidden" name="status" value="2">
                                                        <button type="submit" class="btn btn-success ms-2"><i class="fal fa-check-circle"></i> Sim</button>
                                                    </form>
                                                @else
                                                    <form action="{{ url('venda/cobrado') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                                                        <input type="hidden" name="mes" value="{{ $request->mes ?? date('n') }}">
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-danger ms-2"><i class="fal fa-times-circle"></i> Não</button>
                                                    </form>
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
            $('#tipo_pessoa').val('');
            $('#mes').val('');
            $('#ano').val('');
            $('#grupo_id').val('');
            $('#cidade').val('');
            $('#bairro').val('');
            $('#status').val('');
        })
    </script>
@endsection
