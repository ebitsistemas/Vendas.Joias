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
    <style>
        .btn-login{
            color: white !important;
            background-color: #93731a !important;
        }
        .text-login{
            color: #93731a !important;
        }
    </style>
</head>

<body data-url="{{ url('') }}">

<!-- Internet Connection Status -->
<div class="internet-connection-status" id="internetStatus"></div>

<!-- Login Wrapper Area -->
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-container">
        <div class="text-center px-4">
            <img class="login-intro-img" src="{{ url(env('APP_LOGO')) }}" alt="">
        </div>

        <!-- Register Form -->
        <div class="register-form mt-4">
            <h6 class="mb-3 text-center text-uppercase text-login fs-22px">Login Sistema</h6>

            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="email" id="email" placeholder="E-mail" required>
                    @error('email')
                    <div class="pt-1 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Senha" required>
                        <button type="button" class="input-group-text fn-passHide"><i class="fad fa-eye"></i></button>
                    </div>
                    @error('password')
                    <div class="pt-1 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @error('error')
                <div class="pt-1 text-danger">{{ $message }}</div>
                @enderror

                <button class="btn btn-login w-100" type="submit">Acessar</button>
            </form>
        </div>
    </div>
</div>

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
