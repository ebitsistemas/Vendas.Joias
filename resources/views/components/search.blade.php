<div class="card mb-3">
    <div class="card-body border">
        <div class="row">
            <div class="col-9 pe-1 pt-1">
                <form action="{{ url($method) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <button type="submit" class="input-group-text px-3">
                            <i class="fal fa-search"></i>
                        </button>
                        <input class="form-control form-control-lg" type="search" name="pesquisa" value="{{ $search }}" placeholder="Buscar">
                    </div>
                </form>
            </div>

            <div class="col-3 ps-1 pt-1">
                <a href="{{ url($method.'/cadastrar') }}" class="btn btn-theme w-100" style="padding: 14px;"><i class="fad fa-plus-circle"></i> Cadastrar</a>
            </div>
        </div>
    </div>
</div>
