@extends('layout.template')

@section('title', 'Produtos')

@section('content')
    <div class="card direction-rtl">
        <div class="card-body card-scroll h100p">
            <h5 class="text-theme text-uppercase">Cadastro Produto</h5>
            <form id="produto" action="{{ url('produto/'.$method) }}" method="POST">
                <input type="hidden" name="id" id="id" value="{{ $produto->id ?? '' }}">
                @csrf
                {{-- DADOS GERAIS --}}
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label required" for="nome">Nome</label>
                        <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ $produto->nome ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="codido_interno">Código Interno</label>
                        <input type="text" class="form-control form-control-lg" id="codido_interno" name="codido_interno" value="{{ $produto->codido_interno ?? '' }}">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-label" for="descricao_curta">Descrição Curta</label>
                        <input type="text" class="form-control form-control-lg" id="descricao_curta" name="descricao_curta" value="{{ $produto->descricao_curta ?? '' }}">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label required" for="produto_id">Unidade</label>
                        <select class="form-select form-select-lg" id="unidade_id" name="unidade_id" data-selected="{{ $produto->unidade_id ?? '' }}" required>
                            <option value="0">Selecione...</option>
                            @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="produto_id">Categoria</label>
                        <select class="form-select form-select-lg" id="categoria_id" name="categoria_id" data-selected="{{ $produto->categoria_id ?? '' }}" required>
                            <option value="0">Selecione...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="preco_custo">Preço de Custo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="preco_custo" name="preco_custo" value="{{ $cliente->preco_custo ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="limite_credito">Custos Adicionais</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="limite_credito" name="limite_credito" value="{{ $cliente->limite_credito ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="margem_lucro">Margem de Lucro</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg money" id="margem_lucro" name="margem_lucro" value="{{ $cliente->margem_lucro ?? '' }}">
                            <span class="input-group-text"> % </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="comissao_venda">Comissão de Venda</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg money" id="comissao_venda" name="comissao_venda" value="{{ $cliente->comissao_venda ?? '' }}">
                            <span class="input-group-text"> % </span>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="preco_venda_sugerido">Preço Venda Sugerido</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="preco_venda_sugerido" name="preco_venda_sugerido" value="{{ $cliente->preco_venda_sugerido ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="preco_venda">Preço Venda</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control form-control-lg money" id="preco_venda" name="preco_venda" value="{{ $cliente->preco_venda ?? '' }}" required>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-label" for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" cols="3" rows="5">{{ $produto->descricao ?? '' }}</textarea>
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
            var $form = $('form#produto');
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

