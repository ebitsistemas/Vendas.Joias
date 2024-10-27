<!DOCTYPE html>
<html lang="pt-br">
<head>
    <base href=""/>
    <meta charset="utf-8"/>
    <title>{{ env('APP_NAME') }} - {{ env('APP_SLOGAN') }}</title>
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="pt-br"/>
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}"/>
    <meta name="author" content="Jeferson Maciel - eBit Sistemas LTDA">
    <meta name="creator" content="Jeferson Maciel">
    <meta property="og:type" content="website">
    <meta name="og:site_name" content="{{ env('APP_NAME') }} - {{ env('APP_SLOGAN') }}"/>
    <meta name="og:title" content="{{ env('APP_NAME') }} - {{ env('APP_SLOGAN') }}"/>
    <meta name="og:url" content="{{ url('') }}"/>
    <meta name="robots" content="">

    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="icon" href="{{ url(env('APP_FAVICON')) }}" type="image/png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Libre+Barcode+EAN13+Text&display=swap"
        rel="stylesheet">

    <!-- Style CSS -->
    <link href="{{ url('mobile/assets/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('mobile/assets/css/style.custom.css') }}" rel="stylesheet" type="text/css"/>

    <!-- ICONS -->
    <link href="{{ url('assets/fonts/css/all.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>

    <!-- Web App Manifest -->
    {{--    <link href="{{ url('mobile/assets/manifest.json') }}" rel="manifest"/>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ url('mobile/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- DATATABLE -->
    <link href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
    $config = \App\Models\Configuracao::first();
    @endphp
    <script>
        $(document).ready(function () {
            $(':root').css('--primary-color', "{{ $config->theme_color }}");
            $(':root').css('--primary-light-color', hexToRgbA("{{ $config->theme_color }}"));
        });
        function hexToRgbA(hex){
            var c;
            if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                c= hex.substring(1).split('');
                if(c.length== 3){
                    c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c= '0x'+c.join('');
                return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',0.4)';
            }
            throw new Error('Bad Hex');
        }
    </script>
</head>

<body data-url="{{ url('') }}">
<!-- Preloader
<div id="preloader">
    <div class="spinner-grow text-primary-color" role="status">
        <span class="visually-hidden">Carregando...</span>
    </div>
</div> -->

<!-- Internet Connection Status -->
<div class="internet-connection-status" id="internetStatus"></div>

@include('layout.header')

@include('layout.menu')

<div class="page-content-wrapper py-1">
    <div class="container">
        <x-breadcrumbs menu="{{ $menu ?? '' }}" submenu="{{ $submenu ?? '' }}"/>

        @yield('content')
    </div>
</div>

@include('layout.footer')

<!-- All JavaScript Files -->
<script src="{{ url('mobile/assets/js/slideToggle.min.js') }}"></script>
<script src="{{ url('mobile/assets/js/internet-status.js') }}"></script>
<script src="{{ url('mobile/assets/js/tiny-slider.js') }}"></script>
<script src="{{ url('mobile/assets/js/venobox.min.js') }}"></script>
<script src="{{ url('mobile/assets/js/countdown.js') }}"></script>
<script src="{{ url('mobile/assets/js/rangeslider.min.js') }}"></script>
<script src="{{ url('mobile/assets/js/index.js') }}"></script>
<script src="{{ url('mobile/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ url('mobile/assets/js/isotope.pkgd.min.js') }}"></script>

<script src="{{ url('mobile/assets/js/functions.js') }}"></script>
<script src="{{ url('assets/vendor/vendas.js') }}"></script>
{{--<script src="{{ url('mobile/assets/js/pwa.js') }}"></script>--}}
</body>

</html>
