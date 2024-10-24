@extends('layout.template', ['menu' => 'configuracao', 'submenu' => $method])

@section('title', 'Clientes')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body border card-scroll h100p">
                        <div class="standard-tab">
                            <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="btn text-theme active" id="empresa-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#empresa"
                                            type="button"
                                            role="tab"
                                            aria-controls="empresa"
                                            aria-selected="true">
                                        Empresa
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn text-theme" id="geral-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#geral"
                                            type="button"
                                            role="tab"
                                            aria-controls="geral"
                                            aria-selected="false">
                                        Geral
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn text-theme" id="layout-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#layout"
                                            type="button"
                                            role="tab"
                                            aria-controls="layout"
                                            aria-selected="false">
                                        Layout
                                    </button>
                                </li>
                            </ul>
                            <form id="configuracao" action="{{ url('configuracao/update') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" value="{{ $configuracao->id ?? '' }}">
                                @csrf

                                <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
                                    <div class="tab-pane fade show active" id="empresa" role="tabpanel" aria-labelledby="empresa-tab">
                                        {{-- DADOS GERAIS --}}
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label required" for="tipo_pessoa">Tipo Pessoa</label>
                                                <select class="form-select form-select-lg fn-show" id="tipo_pessoa" name="tipo_pessoa" data-selected="{{ $configuracao->tipo_pessoa ?? '' }}" required>
                                                    <option value="1" selected="">Pessoa Física</option>
                                                    <option value="2">Pessoa Jurídica</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="documento" data-show="tipo_pessoa-1">CPF</label>
                                                <label class="form-label d-none" for="documento" data-show="tipo_pessoa-2">CNPJ</label>
                                                <input type="text" class="form-control form-control-lg" id="documento" name="documento" value="{{ $configuracao->documento ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label class="form-label required" for="nome">Nome Completo</label>
                                                <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ $configuracao->nome ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label" for="rg" data-show="tipo_pessoa-1">RG</label>
                                                <label class="form-label d-none" for="rg" data-show="tipo_pessoa-2">Inscrição Estadual</label>
                                                <input type="text" class="form-control form-control-lg" id="rg" name="rg" value="{{ $configuracao->rg ?? '' }}">
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- ENDEREÇO --}}
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label" for="cep">CEP</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control form-control-lg fn-cep" id="cep" name="cep" value="{{ $configuracao->cep ?? '' }}">
                                                    <a href="#" class="input-group-text"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <label class="form-label" for="logradouro">Logradouro</label>
                                                <input type="text" class="form-control form-control-lg" id="logradouro" name="logradouro" value="{{ $configuracao->logradouro ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label" for="numero">Número</label>
                                                <input type="text" class="form-control form-control-lg" id="numero" name="numero" value="{{ $configuracao->numero ?? '' }}">
                                            </div>
                                            <div class="col-md-9">
                                                <label class="form-label" for="bairro">Bairro</label>
                                                <input type="text" class="form-control form-control-lg" id="bairro" name="bairro" value="{{ $configuracao->bairro ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <label class="form-label" for="cidade">Cidade</label>
                                                <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ $configuracao->cidade ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="uf">UF</label>
                                                <input type="text" class="form-control form-control-lg" id="uf" name="uf" value="{{ $configuracao->uf ?? '' }}">
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- CONTATO --}}

                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <label class="form-label" for="exampleInputText2">E-mail</label>
                                                <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $configuracao->email ?? '' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="exampleInputText2">Celular</label>
                                                <input type="text" class="form-control form-control-lg" id="celular" name="celular" value="{{ $configuracao->celular ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <label class="form-label" for="exampleInputText2">Rede Social</label>
                                                <input type="text" class="form-control form-control-lg" id="rede_social" name="rede_social" value="{{ $configuracao->rede_social ?? '' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="exampleInputText2">Telefone</label>
                                                <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ $configuracao->telefone ?? '' }}">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-2">
                                            <div class="col-md-4 col-sm-12">
                                                @if(empty($configuracao->imagem))
                                                    <img class="img-thumbnail mb-2" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                                                @else
                                                    <img class="img-thumbnail mb-2" src="{{ url('storage/'.$configuracao->imagem) }}" alt="">
                                                @endif
                                                <div class="form-file">
                                                    <input class="form-control d-none form-control-clicked" name="imagem" id="imagem" type="file">
                                                    <label class="form-file-label justify-content-center" for="imagem">
                                                <span class="form-file-button btn btn-primary d-flex align-items-center justify-content-center shadow-lg">
                                                  <i class="fa fa-plus-circle me-2"></i> Upload Logo
                                                </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label" for="itens_pagina">Itens por Página</label>
                                                <input type="number" class="form-control form-control-lg text-center" id="itens_pagina" name="itens_pagina" value="{{ $configuracao->itens_pagina ?? '' }}">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label" for="inativar_cadastro">Inativar Cadastro</label>
                                                <input type="number" class="form-control form-control-lg text-center" id="inativar_cadastro" name="inativar_cadastro" value="{{ $configuracao->inativar_cadastro ?? '0' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <div class="form-group ps-3">
                                                    <label class="form-label fs-14px" for="theme_color">Cor do Layout</label>
                                                    <input class="form-control form-control-color" name="theme_color" id="theme_color" type="color" value="{{ $configuracao->theme_color }}"
                                                           data-bs-toggle="tooltip" data-bs-placement="right" title="Selecione a cor">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-theme w-100 d-flex align-items-center justify-content-center submit">
                                            <i class="fa fa-save fz-16 me-2"></i> Salvar
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

