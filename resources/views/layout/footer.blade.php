<!-- Footer Nav -->
<div class="footer-nav position-relative border-top shadow-sm footer-style-two position-fixed bottom-0">
    <div class="container">
        <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li>
                <a href="{{ url('') }}">
                    <i class="fad fa-home text-primary-color"></i>
                </a>
            </li>

            <li>
                <a href="{{ url('cliente') }}">
                    <i class="fad fa-user text-primary-color"></i>
                </a>
            </li>

            <li class="active">
                <a href="{{ url('carrinho') }}" class="badge-avater badge-avater-lg">
                    <i class="fad fa-shopping-basket"></i>
                </a>
            </li>

            <li>
                <a href="{{ url('produto') }}">
                    <i class="fad fa-box text-primary-color"></i>
                </a>
            </li>

            <li>
                <a href="{{ url('venda') }}">
                    <i class="fad fa-shopping-cart text-primary-color"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).on('click', '.card-product', function () {
        $('.bagde-cart').addClass('pulse').find('span').text('02');
        setTimeout(function () {
            $('.bagde-cart').removeClass('pulse');
        }, 1500);
    });
</script>
