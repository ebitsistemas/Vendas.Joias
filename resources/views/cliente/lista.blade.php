@extends('layout.template')

@section('title', 'Clientes')

@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class="title">
                        <h4 class="text-theme">Clientes</h4>
                        <a href="{{ url('cliente/cadastrar') }}" class="btn btn-theme"><i class="fad fa-plus-circle"></i> Cadastrar</a>
                    </div>

                    <div class="row pt-3">
                        <table class="table table-striped" id="table-clientes"></table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @csrf

    <script>
        table = $("#table-clientes").DataTable({
            order: [0, 'desc'],
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('cliente.ajax') }}",
                "type": "POST",
                "datatype": "json",
                "data": {
                    _token: function () {
                        return $("input[name*='_token']").val()
                    },
                }
            },
            columns: [
                {
                    title: 'Código',
                    data: 'id',
                    name: 'id',
                    width: 50,
                    className: 'ps-5'
                },
                {
                    title: 'Tipo Ppessoa',
                    data: 'tipo_pessoa',
                    name: 'tipo_pessoa',
                    render: (data, type, row) => {
                        return row.tipo_pessoa == '1' ? 'Pessoa Física' : 'Pessoa Jurídica';
                    }
                },
                {
                    title: 'Nome',
                    data: 'nome',
                    name: 'nome',
                    width: 250,
                },
                {
                    title: 'Documento',
                    data: 'documento',
                    name: 'documento',
                    className: 'text-center',
                },
                {
                    title: 'Grupo',
                    data: 'grupo_nome',
                    name: 'grupo_nome'
                },
                {
                    title: 'Status',
                    data: 'status',
                    name: 'status',
                    render: (data, type, row) => {
                        return row.status == '1' ? 'Ativo' : 'Desativado';
                    }
                },
                {
                    title: 'Operações',
                    data: 'id',
                    name: 'id',
                    width: 175,
                    className: 'text-center',
                    render: (data, type, row) => {
                        var button = '';
                        button += '<div class="dropdown">';
                        button += '     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fad fa-cog"></i></button>';
                        button += '     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
                        button += '         <li><a href="cliente/editar/' + data + '" class="dropdown-item text-primary" href="#"><i class="fad fa-edit"></i> Editar </a></li>';
                        button += '         <li><a href="cliente/imprimir/' + data + '" class="dropdown-item text-dark" href="#"><i class="fad fa-print"></i> Imprimir</a></li>';
                        button += '         <li><a href="cliente/compartilhar/' + data + '" class="dropdown-item text-success" href="#"><i class="fad fa-share-nodes"></i> Compartilhar</a></li>';
                        button += '         <li><a class="dropdown-item text-danger fn-remover" href="javascript:void(0);" data-content="'+row.nome+'" data-method="cliente" data-id="'+row.id+'"><i class="fad fa-trash"></i> Remover</a></li>';
                        button += '     </ul>';
                        button += '</div>';
                        return button;
                    }
                },
            ]
        });
    </script>
@endsection
