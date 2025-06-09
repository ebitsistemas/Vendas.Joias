<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Venda;
use App\Models\VendaPagamento;
use App\Models\FaturaItem;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            // ----- PARTE 1: Calcular o saldo inicial para todas as vendas -----
            $vendas = Venda::all();
            foreach ($vendas as $venda) {
                // Soma todos os valores recebidos para faturas pagas (situacao = 1) desta venda
                $totalPago = FaturaItem::where('venda_id', $venda->id)->where('situacao', 1)->sum('valor_recebido');
                $venda->saldo = $venda->total_liquido - $totalPago;
                $venda->save();
            }

            // ----- PARTE 2: Vincular faturas antigas a pagamentos antigos -----
            // Esta é uma lógica de "melhor esforço" baseada na estrutura antiga.
            // **AVISO: Teste isso em um ambiente de desenvolvimento primeiro!**

            // Pega todos os pagamentos que ainda não foram vinculados a nenhuma fatura
            $pagamentos = VendaPagamento::whereDoesntHave('faturasQuitadas')->get();

            foreach ($pagamentos as $pagamento) {
                // Para qual venda este pagamento era? Precisamos buscar essa informação antes da coluna ser removida.
                // Como a migração anterior já remove a coluna, o script precisa ser inteligente.
                // Uma abordagem segura é buscar a fatura correspondente.

                // Encontra faturas pagas (situacao=1), da mesma data do pagamento,
                // cujo vínculo `venda_pagamento_id` ainda está nulo.
                $faturasParaVincular = FaturaItem::where('venda_pagamento_id', null)
                    ->where('situacao', 1)
                    ->where('data_pagamento', $pagamento->data_pagamento)
                    ->get();

                // Se o valor das faturas encontradas bater com o valor do pagamento, podemos vincular.
                if ($faturasParaVincular->isNotEmpty() && $faturasParaVincular->sum('valor_recebido') == $pagamento->valor_recebido) {
                    foreach($faturasParaVincular as $fatura) {
                        $fatura->venda_pagamento_id = $pagamento->id;
                        $fatura->save();
                    }
                }
            }
        });
    }

    public function down(): void
    {
        // Data migrations são complexas de reverter.
        // O ideal é restaurar o backup se for preciso voltar atrás.
    }
};
