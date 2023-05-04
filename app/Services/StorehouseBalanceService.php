<?php

namespace App\Services;

use App\Models\NomenclatureArrival;
use Illuminate\Support\Facades\DB;

class StorehouseBalanceService
{
    public function getNomenclatureBalances()
    {
        $nomenclatureBalances = NomenclatureArrival::select(
            'nomenclature_id',
            DB::raw('n.name AS nomenclature_name'),
            DB::raw('SUM(quantity) AS quantity')
        )->join('nomenclatures as n', 'n.id', '=', 'nomenclature_arrivals.nomenclature_id')
            ->groupBy('nomenclature_id')
            ->get()
            ->transform(function ($m) {
                return [
                    'id' => $m->nomenclature_id,
                    'nomenclature_name' => $m->nomenclature_name,
                    'quantity' => $m->quantity
                ];
            })
            ->toArray();

        return $nomenclatureBalances;
    }
}
