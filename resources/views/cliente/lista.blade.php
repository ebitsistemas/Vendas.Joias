@extends('layout.template', ['menu' => 'cliente', 'submenu' => ''])

@section('title', 'Clientes')

@section('content')
    <div class="container">
        <x-search method="cliente" search="{{ $pesquisa ?? '' }}"/>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
                <div class="row pt-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list mb-3">
                        @foreach($clientes as $cliente)
                        <li class="p-3">
                            <a class="d-flex">
                                <div class="chat-user-thumbnail me-3 shadow">
                                    @if(empty($cliente->imagem))
                                        <img class="img-circle" src="{{ url('mobile/assets/img/no_client.jpg') }}" alt="">
                                    @else
                                        <img class="img-circle" src="{{ url('storage/'.$cliente->imagem) }}" alt="">
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
                                    <h6 class="mb-0 fs-18px mb-1">{{ $cliente->nome }} - {{ $cliente->documento }}</h6>
                                    <div class="last-chat">
                                        <p class="mb-0 text-truncate fs-16px">
                                            @if (!empty($cliente->logradouro)) {{ $cliente->logradouro }}, {{ $cliente->numero }} - @endif @if (!empty($cliente->cidade)) {{ $cliente->cidade }}-{{ $cliente->uf }}@endif
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
                                <button class="btn btn-icon btn-circle btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="p-2"><a href="cliente/editar/{{ $cliente->id }}" class="fs-26px"><i class="fad fa-edit fs-20px"></i> Editar </a></li>
                                    <li class="p-2"><a href="cliente/historico/{{ $cliente->id }}" class="fs-26px"><i class="fad fa-clock-rotate-left fs-18px"></i> Histórico </a></li>
                                    <li class="p-2"><a class="dropdown-item text-danger fs-20px mt-1 fn-remover" href="javascript:void(0);" data-content="{{ $cliente->nome }}" data-method="cliente" data-id="{{ $cliente->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                </ul>
                            </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        {{ $clientes->links() }}
                    </div>
                    <div class="col-5 py-2 text-end">
                        Página {{ $clientes->currentPage() }} de  {{ $clientes->lastPage() }} - {{ $clientes->total() }} registros encontrados
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareImage() {
            const imageUrl = 'https://srembalagens.com.br/wp-content/uploads/2024/09/logo-Coca.jpg'; // Substitua pela URL da sua imagem
            const message = 'Confira esta imagem!'; // Mensagem que será compartilhada
            const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}%20${encodeURIComponent(imageUrl)}`;
            window.open(whatsappUrl, '_blank');
        }
        /*
        <input type="file" id="imageInput" accept="image/*">
        <button onclick="shareImage()">Compartilhar no WhatsApp</button>

        function shareImage() {
            const input = document.getElementById('imageInput');
            if (input.files.length === 0) {
                alert('Por favor, selecione uma imagem.');
                return;
            }
            const file = input.files[0];
            const url = URL.createObjectURL(file);

            const message = 'Confira esta imagem!'; // Mensagem que será compartilhada
            const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}%20${encodeURIComponent(url)}`;

            window.open(whatsappUrl, '_blank');
        }
        */
    </script>
@endsection
