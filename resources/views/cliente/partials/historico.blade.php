
<div class="card-body card-scroll h100p-list p-0">
    <ul class="ps-0 chat-user-list mb-3">
        @foreach($vendas as $venda)
            <li class="p-3">
                <a class="d-flex">
                    <div class="chat-user-info w-100px">
                        <h6 class="mb-0 fs-18px mb-1">Código</h6>
                        <div class="last-chat">
                            <p class="mb-0 text-truncate fs-16px">
                                {{ str($venda->id)->padLeft(6,0) }}
                            </p>
                        </div>
                    </div>

                    <div class="chat-user-info w-375px">
                        <h6 class="mb-0 fs-18px mb-1">{{ $venda->cliente->nome ?? 'Não informado' }}</h6>
                        <div class="last-chat">
                            <p class="mb-0 text-truncate fs-16px">
                                {{ $venda->cliente->documento ?? '' }}
                            </p>
                        </div>
                    </div>

                    <div class="chat-user-info w-150px">
                        <h6 class="mb-0 fs-18px mb-1">Valor</h6>
                        <div class="last-chat">
                            <p class="mb-0 text-truncate fs-16px">
                                R$ {{ number_format($venda->total_liquido, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="chat-user-info w-200px">
                        <h6 class="mb-0 fs-18px mb-1">Data da Venda</h6>
                        <div class="last-chat">
                            <p class="mb-0 text-truncate fs-16px">
                                {{ date('d/m/Y', strtotime($venda->data_venda)) }}
                            </p>
                        </div>
                    </div>

                    <div class="chat-user-info text-center w-150px d-sm-none">
                        <h6 class="fs-18px mb-1">Status</h6>
                        <div class="last-chat">
                            <p class="mb-0 fs-16px">
                                {!! $venda->situacao->label !!}
                            </p>
                        </div>
                    </div>
                </a>
                <div class="dropstart chat-options-btn">
                    <button class="btn btn-icon btn-circle btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v text-theme fs-18px"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="p-2"><a href="{{ url('venda/editar/'.$venda->id) }}" class="fs-16px"><i class="fad fa-edit fs-16px"></i> Editar </a></li>
                        <li class="p-2"><a href="{{ url('venda/imprimir/'.$venda->id) }}" target="_blank" class="fs-16px"><i class="fad fa-print fs-16px"></i> Imprimir</a></li>
                        <li class="p-2"><a class="dropdown-item text-danger fs-16px fn-remover" href="javascript:void(0);" data-content="{{ $venda->id }}" data-method="venda" data-id="{{ $venda->id }}"><i class="fad fa-trash fs-16px"></i> Remover</a></li>
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="row g-3">
        <div class="col-7">
            {{ $vendas->links() }}
        </div>
        <div class="col-5 py-2 text-end">
            Página {{ $vendas->currentPage() }} de  {{ $vendas->lastPage() }} - {{ $vendas->total() }} registros encontrados
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body border">
                    <div class="row">
                        @php($saldo = 0)
                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0">
                                    R$ {{ number_format($totais['vendas'], 2, ',', '.') }}
                                </h4>
                                <p class="mb-0 fz-12">TOTAL DAS VENDAS</p>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0">
                                    R$ {{ number_format($totais['faturas'], 2, ',', '.') }}
                                </h4>
                                <p class="mb-0 fz-12">TOTAL DAS FATURAS</p>
                            </div>
                        </div>

                        @php($saldo = $totais['faturas'] - $totais['vendas'])
                        <div class="col-4">
                            <div class="single-counter-wrap text-center">
                                <h4 class="mb-0 @if($saldo < 0) text-danger @else text-primary @endif">
                                    R$ {{ number_format($saldo, 2, ',', '.') }}
                                </h4>
                                <p class="mb-0 fz-12">SALDO</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
