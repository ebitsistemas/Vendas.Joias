<div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body p-0">
        <div class="sidenav-wrapper">
            <div class="sidenav-profile">
                <div class="sidenav-style1"></div>
                <div class="user-profile">
                    <img src="{{ url(env('APP_LOGO')) }}" alt="">
                </div>
                <div class="user-info">
                    <h6 class="user-name mb-0">{{ env('APP_NAME') }}</h6>
                    <span>{{ env('APP_SLOGAN') }}</span>
                </div>
            </div>

            <ul class="sidenav-nav ps-0">
                <li>
                    <a href="{{ url('') }}"><i class="fal fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="{{ url('cliente') }}"><i class="fal fa-user"></i> Clientes</a>
                </li>
                <li>
                    <a href="{{ url('produto') }}"><i class="fal fa-box"></i> Produtos</a>
                </li>
                <li>
                    <a href="{{ url('categoria') }}"><i class="fal fa-sitemap"></i> Categorias</a>
                </li>
                <li>
                    <a href="{{ url('grupo') }}"><i class="fal fa-folder-tree"></i> Grupos</a>
                </li>
                <li>
                    <a href="{{ url('venda') }}"><i class="fal fa-shopping-cart"></i> Vendas</a>
                </li>
                <li>
                    <form method="post" action="{{ url('logout') }}">
                        @csrf
                        <a href="{{ url('logout') }}"  onclick="event.preventDefault(); this.closest('form').submit();"
                           data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Sair do Sistema">
                            <i class="fal fa-sign-out"></i> Logout
                        </a>
                    </form>
                </li>
            </ul>

            <!-- Copyright Info -->
            <div class="copyright-info fs-12px">
                Copyright © {{ date('Y') }} {{ env('APP_NAME') }}<br>
                Desenvolvido por <a href="https://ebitsistemas.com.br/" target="_blank">eBit Sistemas LTDA</a>
            </div>
        </div>
    </div>
</div>
