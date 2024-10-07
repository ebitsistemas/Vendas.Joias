@extends('layout.template')

@section('title', 'Clientes')

@section('content')
    <div class="card direction-rtl">
        <div class="card-body card-scroll h100p">
            <h5 class="text-theme text-uppercase">Cadastro Cliente</h5>
            <form id="cliente" action="{{ url('cliente/'.$method) }}" method="POST">
                <input type="hidden" name="id" id="id" value="{{ $cliente->id ?? '' }}">
                @csrf
                {{-- DADOS GERAIS --}}
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label required" for="tipo_pessoa">Tipo Pessoa</label>
                        <select class="form-select form-select-lg fn-show" id="tipo_pessoa" name="tipo_pessoa" data-selected="{{ $cliente->tipo_pessoa ?? '' }}" required>
                            <option value="1" selected="">Pessoa Física</option>
                            <option value="2">Pessoa Jurídica</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="documento" data-show="tipo_pessoa-1">CPF</label>
                        <label class="form-label required d-none" for="documento" data-show="tipo_pessoa-2">CNPJ</label>
                        <input type="text" class="form-control form-control-lg" id="documento" name="documento" value="{{ $cliente->documento ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-label required" for="nome">Nome Completo</label>
                        <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ $cliente->nome ?? '' }}" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="rg">RG</label>
                        <input type="text" class="form-control form-control-lg" id="rg" name="rg" value="{{ $cliente->rg ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="grupo_id">Grupo</label>
                        <select class="form-select form-select-lg" id="grupo_id" name="grupo_id" data-selected="{{ $cliente->grupo_id ?? '' }}">
                            <option value="0">Selecione...</option>
                            @foreach($grupos as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="sexo">Sexo</label>
                        <select class="form-select form-select-lg" id="sexo" name="sexo" data-selected="{{ $cliente->sexo ?? '' }}">
                            <option value="0">Selecione...</option>
                            <option value="1">Feminino</option>
                            <option value="2">Masculino</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="data_nascimento">Data de Nascimento</label>
                        <input type="date" class="form-control form-control-lg" id="data_nascimento" name="data_nascimento" value="{{ $cliente->data_nascimento ?? '' }}">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="renda">Renda Mensal</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="faturamento_mensal" name="faturamento_mensal" value="{{ $cliente->faturamento_mensal ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="limite_credito">Limite Crédito</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="limite_credito" name="limite_credito" value="{{ $cliente->limite_credito ?? '' }}">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- ENDEREÇO --}}
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="form-label" for="cep">CEP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg fn-cep" id="cep" name="cep" value="{{ $cliente->cep ?? '' }}">
                            <a href="#" class="input-group-text"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label" for="logradouro">Logradouro</label>
                        <input type="text" class="form-control form-control-lg" id="logradouro" name="logradouro" value="{{ $cliente->logradouro ?? '' }}">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="form-label" for="numero">Número</label>
                        <input type="text" class="form-control form-control-lg" id="numero" name="numero" value="{{ $cliente->numero ?? '' }}">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label" for="bairro">Bairro</label>
                        <input type="text" class="form-control form-control-lg" id="bairro" name="bairro" value="{{ $cliente->bairro ?? '' }}">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-9">
                        <label class="form-label" for="cidade">Cidade</label>
                        <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ $cliente->cidade ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="uf">UF</label>
                        <input type="text" class="form-control form-control-lg" id="uf" name="uf" value="{{ $cliente->uf ?? '' }}">
                    </div>
                </div>

                <hr>

                {{-- CONTATO --}}

                <div class="row mb-2">
                    <div class="col-md-8">
                        <label class="form-label" for="exampleInputText2">E-mail</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $cliente->email ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="exampleInputText2">Celular</label>
                        <input type="text" class="form-control form-control-lg" id="celular" name="celular" value="{{ $cliente->celular ?? '' }}">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-8">
                        <label class="form-label" for="exampleInputText2">Rede Social</label>
                        <input type="text" class="form-control form-control-lg" id="rede_social" name="rede_social" value="{{ $cliente->rede_social ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="exampleInputText2">Telefone</label>
                        <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ $cliente->telefone ?? '' }}">
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-label" for="anotacoes">Anotações</label>
                        <textarea class="form-control" id="anotacoes" name="anotacoes" cols="3" rows="5">{{ $cliente->anotacoes ?? '' }}</textarea>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-theme w-100 d-flex align-items-center justify-content-center submit">
                            <i class="fa fa-save fz-16 me-2"></i> Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        /*$(document).on('click', '.submit', function () {
            var data = [];
            var $form = $('form#cliente');
            var dataSerialize = $form.serialize();

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: dataSerialize,
                beforeSend: function () {
                    toastr.info('Aguarde, salvando...!');
                },
                success: function (data) {

                },
                error: function (data) {

                }
            });
        })*/
    </script>
@endsection

