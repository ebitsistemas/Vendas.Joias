<!-- Header Area -->
<div class="header-demo-bg shadow-sm mb-3">
    <div class="container">
        <div class="header-content header-style-two position-relative d-flex align-items-center justify-content-between">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Logo Wrapper -->
            <div class="logo">
                <a href="{{ url('') }}">
                    <img src="{{ url(env('APP_LOGO')) }}" width="110" alt="">
                </a>
            </div>

            <div class="navbar-content-wrapper d-flex align-items-center">

                <!-- Notificacoes
                <div class="search-wrapper me-2">
                    <a class="search-trigger-btn" href="#">
                        <i class="fad fa-bell fs-24px"></i>
                    </a>
                </div> -->

                <!--
                <div class="search-wrapper me-2">
                    <a class="search-trigger-btn" href="javascript:void(0);" onclick="ToggleFullScreen();">
                        <i class="fad fa-expand fs-24px" id="full-screen"></i>
                    </a>
                </div>-->

                <!-- Navbar Toggler -->
                <div class="navbar--toggler" id="affanNavbarToggler3" data-bs-toggle="offcanvas"
                     data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                    <a class="search-trigger-btn" href="javascript:void(0);">
                        <i class="fad fa-bars fs-24px"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- # Header Two Layout End -->
    </div>
</div>
