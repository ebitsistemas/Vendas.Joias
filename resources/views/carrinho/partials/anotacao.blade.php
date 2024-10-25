<div class="card mb-3">
    <div class="card-body">
        <form id="form_notas" action="{{ url('carrinho/update') }}" method="POST">
            <input type="hidden" name="id" value="{{ $venda->id }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="exampleTextarea1">Anotações</label>
                <textarea class="form-control form-control-clicked" id="anotacoes" name="anotacoes" cols="3" rows="5">{{ $venda->anotacoes }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach ($situacoes as $situacaoItem)
                        <option value="{{ $situacaoItem->codigo }}" @if($situacaoItem->codigo == $venda->status) selected @endif> {{ $situacaoItem->nome }} </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>
