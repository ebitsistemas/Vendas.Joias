<div class="navbar-menu">
    <div class="scanner-bg">
        <a href="{{ url('venda/cadastrar') }}" class="scanner-btn">
            <i class="fad fa-basket-shopping text-white fs-2"></i>
        </a>
    </div>
    <ul>
        <li class="active">
            <a href="{{ url('') }}">
                <div class="icon mb-2">
                    <i class="fad fa-home"></i>
                </div>
                <h5 class="active">Home</h5>
            </a>
        </li>

        <li>
            <a href="{{ url('cliente') }}">
                <div class="icon mb-2">
                    <i class="fad fa-user"></i>
                </div>
                <h5>Clientes</h5>
            </a>
        </li>

        <li></li>

        <li>
            <a href="{{ url('produto') }}">
                <div class="icon mb-2">
                    <i class="fad fa-box"></i>
                </div>
                <h5>Produtos</h5>
            </a>
        </li>

        <li>
            <a href="{{ url('venda') }}">
                <div class="icon mb-2">
                    <i class="fad fa-file-invoice"></i>
                </div>
                <h5>Vendas</h5>
            </a>
        </li>
    </ul>
</div>
