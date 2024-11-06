<?php

namespace App\Observers;

use App\Models\FaturaItem;
use App\Models\Venda;

class FaturaObserver
{
    public function created(FaturaItem $faturaItem)
    {
        if ($faturaItem->status > 0) {
            $venda = Venda::where('id', $faturaItem->venda_id)->first();
            $venda->status = 1;
            $venda->save();
        }
    }

    public function updated(FaturaItem $faturaItem)
    {
        if ($faturaItem->isDirty('status')) {
            if ($faturaItem->status > 0) {
                $venda = Venda::where('id', $faturaItem->venda_id)->first();
                $venda->status = 1;
                $venda->save();
            }
        }
    }
}
