<div class="card mb-3">
    <div class="card-body">
        <form id="form_notas" action="{{ url('carrinho/update') }}" method="POST">
            <input type="hidden" name="id" value="{{ $venda->id }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="exampleTextarea1">Anotações</label>
                <textarea class="form-control form-control-clicked" id="anotacoes" name="anotacoes" cols="3" rows="5">{{ $venda->anotacoes }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Data da Cobrança</label>
                    <input class="form-control form-control-lg mask-date" type="date" value="" name="data_cobranca" id="data_cobranca">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-select form-control-lg" required>
                        @foreach ($situacoes as $situacaoItem)
                            <option value="{{ $situacaoItem->codigo }}" @if($situacaoItem->codigo == $venda->status) selected @endif> {{ $situacaoItem->nome }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-5">
    <div class="card-body border">
        <div class="apply-coupon">
            <div class="coupon-form">
                <button type="submit" class="btn btn-theme fs-20px p-2 w-100 my-3 fn-salvar"><i class="fa fa-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>
