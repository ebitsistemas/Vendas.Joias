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
                        <label class="form-label" for="nome">Nome</label>
                        <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ $produto->nome ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="descricao">Descrição</label>
                        <input type="text" class="form-control form-control-lg" id="descricao" name="descricao" value="{{ $produto->descricao ?? '' }}">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label" for="produto_id">Produto</label>
                        <select class="form-select form-select-lg" id="produto_id" name="produto_id" data-selected="{{ $produto->produto_id ?? '' }}">
                            <option value="0">Selecione...</option>
                            @foreach($produtos as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>
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

