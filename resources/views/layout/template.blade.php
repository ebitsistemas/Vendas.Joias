<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" />
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="{{ env('APP_NAME') }}" />
    <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap" rel="stylesheet" />

    <!-- ICONS -->
    <link href="{{ url('assets/fonts/css/all.css') }}" rel="stylesheet"/>

    <!-- iconsax css -->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/vendors/iconsax.css') }}" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{ url('assets/css/vendors/bootstrap.min.css') }}" />

    <!-- swiper css -->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/vendors/swiper-bundle.min.css') }}" />

    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ url('assets/css/style.css') }}" />
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ url('assets/css/style.custom.css') }}" />
</head>

<body>

    @include('layout.sidebar')

    @include('layout.header')

    @yield('content')

    <!-- panel-space start -->
    <section class="panel-space"></section>
    <!-- panel-space end -->

    @include('layout.footer')

<!-- swiper js -->
<script src="{{ url('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ url('assets/js/custom-swiper.js') }}"></script>

<!-- feather js -->
<script src="{{ url('assets/js/feather.min.js') }}"></script>
<script src="{{ url('assets/js/custom-feather.js') }}"></script>

<!-- iconsax js -->
<script src="{{ url('assets/js/iconsax.js') }}"></script>

<!-- bootstrap js -->
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- PWA offcanvas popup js -->
<script src="{{ url('assets/js/offcanvas-popup.js') }}"></script>

<!-- script js -->
<script src="{{ url('assets/js/script.js') }}"></script>
</body>
</html>
