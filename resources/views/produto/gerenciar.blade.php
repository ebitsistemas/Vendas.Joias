@extends('layout.template')

@section('title', 'Produtos')

@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="card bg-white">
                <div class="card-body card-scroll h100p">
                    <div class="row">
                        <div class="col-md-12">
                        <h5 class="text-theme text-uppercase">Cadastro Produto</h5>
                        <form id="produto" action="{{ url('produto/'.$method) }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control form-control-lg money" id="preco_custo" name="preco_custo" @if (!empty($produto)) value="{{ number_format($produto->preco_custo, 2, ',', '.') ?? '' }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required" for="preco_venda">Preço Venda</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="text" class="form-control form-control-lg money" id="preco_venda" name="preco_venda" @if (!empty($produto)) value="{{ number_format($produto->preco_venda, 2, ',', '.') ?? '' }}" @endif required>
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

                            <!--
                            <hr>

                            <div class="row mb-2">
                                <div class="col-md-4 col-sm-12">
                                    <img class="img-thumbnail mb-2" src="{{ url('mobile/assets/img/bg-img/2.jpg') }}" alt="">
                                    <div class="form-file">
                                        <input class="form-control d-none form-control-clicked" name="imagem" id="imagem" type="file">
                                        <label class="form-file-label justify-content-center" for="imagem">
                                            <span class="form-file-button btn btn-primary d-flex align-items-center justify-content-center shadow-lg">
                                              <i class="fa fa-plus-circle me-2"></i> Upload Imagem
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                             -->

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
                </div>
            </div>
        </div>
    </section>
@endsection

