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
                            <label class="fs-6 form-label">UF</label>
                            <select class="form-select form-select-lg" id="uf" name="uf" data-selected=""
                                    data-select="{{ $request->uf ?? '' }}">
                                <option value="">Todos</option>
                                <option value="AC">
                                    AC: Acre
                                </option>
                                <option value="AL">
                                    AL: Alagoas
                                </option>
                                <option value="AM">
                                    AM: Amazonas
                                </option>
                                <option value="AP">
                                    AP: Amapá
                                </option>
                                <option value="BA">
                                    BA: Bahia
                                </option>
                                <option value="CE">
                                    CE: Ceará
                                </option>
                                <option value="DF">
                                    DF: Distrito Federal
                                </option>
                                <option value="ES">
                                    ES: Espírito Santo
                                </option>
                                <option value="GO">
                                    GO: Goiás
                                </option>
                                <option value="MA">
                                    MA: Maranhão
                                </option>
                                <option value="MG">
                                    MG: Minas Gerais
                                </option>
                                <option value="MS">
                                    MS: Mato Grosso do Sul
                                </option>
                                <option value="MT">
                                    MT: Mato Grosso
                                </option>
                                <option value="PA">
                                    PA: Pará
                                </option>
                                <option value="PB">
                                    PB: Paraíba
                                </option>
                                <option value="PE">
                                    PE: Pernambuco
                                </option>
                                <option value="PI">
                                    PI: Piauí
                                </option>
                                <option value="PR" selected>
                                    PR: Paraná
                                </option>
                                <option value="RJ">
                                    RJ: Rio de Janeiro
                                </option>
                                <option value="RN">
                                    RN: Rio Grande do Norte
                                </option>
                                <option value="RO">
                                    RO: Rondônia
                                </option>
                                <option value="RR">
                                    RR: Roraima
                                </option>
                                <option value="RS">
                                    RS: Rio Grande do Sul
                                </option>
                                <option value="SC">
                                    SC: Santa Catarina
                                </option>
                                <option value="SE">
                                    SE: Sergipe
                                </option>
                                <option value="SP">
                                    SP: São Paulo
                                </option>
                                <option value="TO">
                                    TO: Tocantins
                                </option>
                                <option value="EX">
                                    EX: Exterior
                                </option>
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
                            <ul class="ps-0 chat-user-list mb-3">
                                @foreach($clientes as $cliente)
                                    <li class="p-3">
                                        <a class="d-flex">
                                            <div class="chat-user-thumbnail me-3 shadow">
                                                @if(empty($cliente->imagem))
                                                    <img class="img-circle"
                                                         src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                                                @else
                                                    <img class="img-circle" src="{{ url('storage/'.$cliente->imagem) }}"
                                                         alt="">
                                                @endif
                                            </div>

                                            <div class="chat-user-info w-100px">
                                                <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                                <div class="last-chat">
                                                    <p class="mb-0 text-truncate fs-16px">
                                                        {{ str($cliente->id)->padLeft(6,0) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="chat-user-info w-500px">
                                                <h6 class="mb-0 fs-18px mb-1">{{ $cliente->nome }}
                                                    - {{ $cliente->documento }}</h6>
                                                <div class="last-chat">
                                                    <p class="mb-0 text-truncate fs-16px">
                                                        {{ $cliente->logradouro }}, {{ $cliente->numero }}
                                                        - {{ $cliente->cidade }}-{{ $cliente->uf }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="chat-user-info text-center w-100px">
                                                <h6 class="mb-0 fs-18px mb-1">Status</h6>
                                                <div class="last-chat">
                                                    <p class="mb-0 fs-16px">
                                                        @if($cliente->status == 1)
                                                            <span class="badge bg-success ms-2">Ativo</span>
                                                        @else
                                                            <span class="badge bg-danger ms-2">Inativo</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropstart chat-options-btn">
                                            <button class="btn btn-icon btn-circle btn-light dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="p-2"><a href="cliente/editar/{{ $cliente->id }}"
                                                                   class="fs-16px"><i class="fad fa-edit fs-16px"></i>
                                                        Editar </a></li>
                                                <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover"
                                                                   href="javascript:void(0);"
                                                                   data-content="{{ $cliente->nome }}"
                                                                   data-method="cliente" data-id="{{ $cliente->id }}"><i
                                                            class="fad fa-trash fs-16px"></i> Remover</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
