@extends('layout.template', ['menu' => 'usuario', 'submenu' => ''])

@section('title', 'Usuários')

@section('content')
    <div class="container">
        <x-search method="usuario" search="{{ $pesquisa ?? '' }}"/>

        <div class="card">
            <div class="card-body border card-scroll h100p-list">
                <div class="row pt-3">
                    <div class="col-12">
                        <ul class="ps-0 chat-user-list mb-3">
                        @foreach($usuarios as $usuario)
                        <li class="p-3">
                            <a class="d-flex">
                                <div class="chat-user-info w-100px">
                                    <h6 class="mb-0 fs-18px mb-1">Código</h6>
                                    <div class="last-chat">
                                        <p class="mb-0 text-truncate fs-16px">
                                            {{ str($usuario->id)->padLeft(6,0) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="chat-user-info w-500px">
                                    <h6 class="mb-0 fs-18px mb-1">{{ $usuario->name }}</h6>
                                    <div class="last-chat">
                                        <p class="mb-0 text-truncate fs-16px">
                                            {{ $usuario->email }}
                                        </p>
                                    </div>
                                </div>

                                <div class="chat-user-info text-center w-100px">
                                    <h6 class="mb-0 fs-18px mb-1">Status</h6>
                                    <div class="last-chat">
                                        <p class="mb-0 fs-16px">
                                            @if($usuario->status == 1)
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
                                    <li class="p-2"><a href="usuario/editar/{{ $usuario->id }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                                    @if($usuario->id != 1)
                                        <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $usuario->name }}" data-method="usuario" data-id="{{ $usuario->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-7">
                        {{ $usuarios->links() }}
                    </div>
                    <div class="col-5 py-2 text-end">
                        Página {{ $usuarios->currentPage() }} de  {{ $usuarios->lastPage() }} - {{ $usuarios->total() }} registros encontrados
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
