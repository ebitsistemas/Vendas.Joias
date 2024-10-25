<div class="card mb-3">
    <div class="card-body">
        <form id="form_notas" action="{{ url('carrinho/update') }}" method="POST">
            <input type="hidden" name="id" value="{{ $venda->id }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="exampleTextarea1">Anotações</label>
                <textarea class="form-control form-control-clicked" id="anotacoes" name="anotacoes" cols="3" rows="5">{{ $venda->anotacoes }}</textarea>
            </div>
        </form>
    </div>
</div>
