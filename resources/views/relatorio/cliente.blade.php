@extends('layout.template', ['menu' => 'relatorio', 'submenu' => 'Cliente'])

@section('title', 'Relatório Cliente')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body border">
                <form method="post" action="{{ url('relatorio/cliente') }}" enctype="multipart/form-data">
                    @csrf
                    <h3 class="fs-22px text-theme">Relatório de Clientes</h3>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="fs-6 form-label">Tipo Pessoa</label>
                            <select class="form-select form-select-lg" name="tipo_pessoa" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->tipo_pessoa ?? '' }}">
                                <option value="">Todos</option>
                                <option value="1">Pessoa Física</option>
                                <option value="2">Pessoa Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="fs-6 form-label">Grupo</label>
                            <select class="form-select form-select-lg" name="grupo_id" data-control="select2"
                                    data-hide-search="true" data-select="{{ $request->grupo_id ?? '' }}">
                                <option value="">Todos</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="fs-6 form-label">Sexo</label>
                            <select class="form-select form-select-lg" id="sexo" name="sexo" data-selected=""
                                    data-select="{{ $request->sexo ?? '' }}">
                                <option value="">Todos</option>
                                <option value="1">Feminino</option>
                                <option value="2">Masculino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="fs-6 form-label">Cidade</label>
                            <input class="form-control form-control-lg" id="cidade" name="cidade" value="{{ $request->cidade ?? '' }}">
                        </div>

                        <div class="col-md-4">
                            <label class="fs-6 form-label">Bairro</label>
                            <input class="form-control form-control-lg" id="bairro" name="bairro" value="{{ $request->bairro ?? '' }}">
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
            $('#tipo_pessoa').val('');
            $('#grupo_id').val('');
            $('#sexo').val('');
            $('#cidade').val('');
            $('#bairro').val('');
            $('#status').val('');
        })
    </script>
@endsection
