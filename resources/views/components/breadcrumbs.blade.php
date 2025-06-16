<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded border p-3">
            <li class="breadcrumb-item">
                <a href="{{ url('') }}" class="text-theme">Home</a>
            </li>
            @if(isset($menu))
                @php
                    switch ($menu) {
                        case 'configuracao':
                            $link = $menu;
                            $menu = 'Configuração';
                            break;
                        case 'relatorio':
                            $link = $menu;
                            $menu = 'Relatório';
                            break;
                        case 'usuario':
                            $link = $menu;
                            $menu = 'Usuário';
                            break;
                        break;
                            default:
                            $link = $menu;
                            break;
                    }
                @endphp
                @if(isset($submenu) AND !empty($submenu))
                    <li class="breadcrumb-item fs-20px">
                        <a href="{{ url($link) }}" class="text-theme">
                            {{ ucfirst($menu) }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item fs-20px">
                        {{ ucfirst($menu) }}
                    </li>
                @endif
            @endif

            @if(isset($submenu) AND !empty($submenu))
                <li class="breadcrumb-item text-theme active" aria-current="page">
                    @php
                        switch ($submenu) {
                            case 'store':
                                $submenu = 'Cadastrar';
                                break;
                            case 'update':
                                $submenu = 'Editar';
                                break;
                            case 'copy':
                                $submenu = 'Copiar';
                                break;
                            case 'view':
                                $submenu = 'Visualizar';
                                break;
                        }
                        echo $submenu;
                    @endphp
                </li>
            @endif
        </ol>
    </nav>
</div>
