@extends('layout.template', ['menu' => 'grupo', 'submenu' => $method])

@section('title', 'Grupos')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-scroll h100p">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-theme text-uppercase">Grupo</h5>
                                <form id="grupo" action="{{ url('grupo/'.$method) }}" method="POST">
                                    <input type="hidden" name="id" id="id" value="{{ $grupo->id ?? '' }}">
                                    @csrf
                                    {{-- DADOS GERAIS --}}
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ $grupo->nome ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="descricao">Descrição</label>
                                            <input type="text" class="form-control form-control-lg" id="descricao" name="descricao" value="{{ $grupo->descricao ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="grupo_id">Grupo</label>
                                            <select class="form-select form-select-lg" id="grupo_id" name="grupo_id" data-selected="{{ $grupo->grupo_id ?? '' }}">
                                                <option value="0">Selecione...</option>
                                                @foreach($grupos as $item)
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

