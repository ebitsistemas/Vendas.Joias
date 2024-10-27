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
                                            <div class="form-group position-relative">
                                                <input type="password" class="form-control form-control-lg" id="password" name="password">
                                                <div class="position-absolute" id="password-visibility">
                                                    <i class="bi bi-eye"></i>
                                                    <i class="bi bi-eye-slash"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="exampleInputText2">Confirmação de senha</label>
                                            <div class="form-group position-relative">
                                                <input type="password" class="form-control form-control-lg form-control-clicked" id="confirm_password">
                                                <div class="position-absolute" id="password-visibility">
                                                    <i class="bi bi-eye"></i>
                                                    <i class="bi bi-eye-slash"></i>
                                                </div>
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
        let passWord = document.getElementById('password-visibility');

        if (passWord) {
            passWord.addEventListener('click', passwordFunction);
        }

        function passwordFunction() {
            let passInput = document.getElementById('password');
            passWord.classList.toggle('active');

            if (passInput.type === 'password') {
                passInput.type = 'text';
            } else {
                passInput.type = 'password';
            }
        }
    </script>
@endsection

