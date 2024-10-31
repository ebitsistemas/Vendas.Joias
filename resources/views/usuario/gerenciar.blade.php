@extends('layout.template', ['menu' => 'usuario', 'submenu' => $method])

@section('title', 'Usuários')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body border card-scroll h100p">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-theme text-uppercase">Usuário</h5>
                                <form id="usuario" action="{{ url('usuario/'.$method) }}" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id" value="{{ $usuario->id ?? '' }}">
                                    @csrf
                                    {{-- DADOS GERAIS --}}
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label required" for="nome">Nome Completo</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ $usuario->name ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label required" for="exampleInputText2">E-mail</label>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $usuario->email ?? '' }}" required>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="exampleInputText2">Senha</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control form-control-lg passwordStrength" id="password" name="password" disabled>
                                                <button type="button" class="input-group-text fn-passEdit"><i class="fad fa-edit"></i></button>
                                                <button type="button" class="input-group-text fn-passHide"><i class="fad fa-eye"></i></button>
                                            </div>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar passwordStrengthBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="exampleInputText2">Confirmação de senha</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control form-control-lg" name="confirm_password" id="confirm_password" disabled>
                                                <button type="button" class="input-group-text fn-passEdit"><i class="fad fa-edit"></i></button>
                                                <button type="button" class="input-group-text fn-passHide"><i class="fad fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-theme w-100 d-flex align-items-center justify-content-center submit">
                                                <i class="fa fa-save fz-16 me-2"></i> Salvar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('blur', 'form .confirmPassword', function () {
            var $password = $('input[name=password]');
            var $confirmPassword = $(this);

            if ($password.val() !== $confirmPassword.val()) {
                $password.addClass('is-invalid');
                $confirmPassword.addClass('is-invalid');
                toastr.warning('As senhas não conferem!');
            } else {
                $password.removeClass('is-invalid');
                $confirmPassword.removeClass('is-invalid');
            }
        });

        /* EXIBE E OCULTA VALUE DO CAMPO */
        $(document).on('click', '.fn-passHide',  function () {
            var $botao = $(this);
            var $icon = $botao.children('i');

            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye');
                $botao.siblings('input').removeAttr('type', 'password');
                setTimeout(function () {
                    $icon.addClass('fa-eye-slash');
                    $botao.siblings('input').attr('type', 'text');
                })
            } else if($icon.hasClass('fa-eye-slash')) {
                $icon.removeClass('fa-eye-slash');
                $botao.siblings('input').removeAttr('type', 'text');
                setTimeout(function () {
                    $icon.addClass('fa-eye');
                    $botao.siblings('input').attr('type', 'password');
                })
            }
        });

        $(document).on('blur', 'form .passwordStrength', function () {
            var $password = $(this);
            var strength = $('#password_strength').val();

            if (strength <= 58) {
                $password.addClass('is-invalid');
                toastr.warning('Senha informada, é fraca, a mesma deve ser mais forte!');
            } else {
                $password.removeClass('is-invalid');
            }
        });

        $(document).on('keyup', 'form .passwordStrength', function () {
            var $input = $(this);
            var senha = $input.val();
            var forca = forcaSenha(senha);
            var color = '#d75553';

            if (forca >= 65) {
                color = '#388f39';
            } else if (forca >= 40) {
                color = '#b9a016';
            }

            var $bar =  $input.parent().parent().parent().find('.passwordStrengthBar');

            $bar.attr('aria-valuenow', forca+'%');
            $bar.css('background-color', color);
            $bar.css('width', forca+'%');
            $('#password_strength').val(forca);
        });

        function forcaSenha(senha){
            var forca = 0;

            var regLetrasMa = /[A-Z]/;
            var regLetrasMi = /[a-z]/;
            var regNumero = /[0-9]/;
            var regEspecial = /[!@#$%&*?]/;

            var tam = false;
            var tamM = false;
            var letrasMa = false;
            var letrasMi = false;
            var numero = false;
            var especial = false;

            if(senha.length >= 8) tam = true;
            if(senha.length >= 10) tamM = true;
            if(regLetrasMa.exec(senha)) letrasMa = true;
            if(regLetrasMi.exec(senha)) letrasMi = true;
            if(regNumero.exec(senha)) numero = true;
            if(regEspecial.exec(senha)) especial = true;

            if(tam) forca += 10;
            if(tamM) forca += 10;
            if(letrasMa) forca += 10;
            if(letrasMi) forca += 10;
            if(letrasMa && letrasMi) forca += 20;
            if(numero) forca += 20;
            if(especial) forca += 20;

            return forca;
        }
    </script>
@endsection

