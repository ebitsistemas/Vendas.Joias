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
                <a href="javascript:void(0);" class="badge-avater badge-avater-lg add-venda">
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
    $(document).on('click', '.add-venda', function () {
        Swal.fire({
            title: 'Nova Venda',
            text: "Deseja iniciar uma nova venda?",
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-check-circle"></i> Sim',
            cancelButtonText: '<i class="fa fa-times-circle"></i> Não',
            customClass: {
                actions: 'my-actions',
                confirmButton: 'btn btn-success me-3',
                cancelButton: 'btn btn-danger',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url('carrinho') }}';
            }
        });
    });
</script>
