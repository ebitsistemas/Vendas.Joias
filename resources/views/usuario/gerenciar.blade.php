@extends('layout.template', ['menu' => 'cliente', 'submenu' => $method])

@section('title', 'Clientes')

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
                                            <label class="form-label" for="exampleInputText2">E-mail</label>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $usuario->email ?? '' }}">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="exampleInputText2">Senha</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control form-control-lg" id="password" name="password" disabled>
                                                <button type="button" class="input-group-text fn-passEdit"><i class="fad fa-edit"></i></button>
                                                <button type="button" class="input-group-text fn-passHide"><i class="fad fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="exampleInputText2">Confirmação de senha</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control form-control-lg" id="confirm_password" disabled>
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
    </script>
@endsection

