<?php

namespace App\Services;

use App\Models\NomenclatureArrival;
use App\Models\NomenclatureOperation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StorehouseBalanceService
{
    public function getNomenclatureBalances(): array
    {
        $companyId = auth()->user()->company_id;

        $orderItems = DB::table(DB::raw('order_items oi'))
            ->select(
                'o.storehouse_id',
                'oi.nomenclature_id',
                DB::raw('SUM(oi.quantity) quantity'),
            )
            ->join(
                DB::raw('orders o'),
                fn($q) => $q->on('o.id', '=', 'oi.order_id')
                    ->where('o.company_id', $companyId)
                    ->whereStatus(Order::STATUS_SOLD)
                    ->whereNull('o.deleted_at')
            )
            ->groupBy('o.storehouse_id')
            ->groupBy('oi.nomenclature_id')
            ->whereNull('oi.deleted_at')
            ->get();

        $nomenclatureOperations = NomenclatureOperation::select(
            'storehouse_id',
            'type',
            'nomenclature_id',
            DB::raw('SUM(quantity) as quantity')
        )
            ->groupBy('storehouse_id')
            ->groupBy('type')
            ->groupBy('nomenclature_id')
            ->get();

        $balances = DB::table(DB::raw('nomenclature_arrivals na'))
            ->select(
                'na.nomenclature_id',
                DB::raw('n.name as nomenclature_name'),
                DB::raw('na.storehouse_id'),
                DB::raw('s.name as storehouse_name'),
                DB::raw('SUM(na.quantity) as quantity'),
                DB::raw('u.name as unit')
            )->join(
                DB::raw('nomenclatures as n'),
                fn($q) => $q->on('n.id', '=', 'na.nomenclature_id')
                    ->where('n.company_id', $companyId)
            )
            ->join(
                DB::raw('storehouses as s'),
                fn($q) => $q->on('s.id', '=', 'na.storehouse_id')
                    ->where('s.company_id', $companyId)
                    ->whereNull('s.deleted_at')
            )
            ->leftJoin(
                DB::raw('units as u'), 'u.id', '=', 'n.unit_id'
            )
            ->whereNull('na.deleted_at')
            ->where('na.company_id', $companyId)
            ->groupBy(DB::raw('na.nomenclature_id'))
            ->groupBy(DB::raw('na.storehouse_id'))
            ->get();

        $nomenclatures = $balances
            ->groupBy('nomenclature_id')
            ->map(function (Collection $m) use ($orderItems, $nomenclatureOperations) {
                $nomenclature = $m->last();

                return [
                    'nomenclature' => [
                        'id' => $nomenclature->nomenclature_id,
                        'name' => $nomenclature->nomenclature_name,
                        'unit' => $nomenclature->unit,
                    ],
                    'storehouses' => $m->groupBy('storehouse_id')
                        ->map(function (Collection $s) use ($orderItems, $nomenclature, $nomenclatureOperations) {
                            $storehouse = $s->last();

                            $storehouseOrderItems = $orderItems
                                ->where('storehouse_id', $storehouse->storehouse_id)
                                ->where('nomenclature_id', $nomenclature->nomenclature_id);

                            $nomenclatureWithdraw = $nomenclatureOperations
                                ->where('storehouse_id', $storehouse->storehouse_id)
                                ->where('nomenclature_id', $nomenclature->nomenclature_id)
                                ->where('type', NomenclatureOperation::OPERATION_TYPE_WITHDRAW);

                            $nomenclatureRefund = $nomenclatureOperations
                                ->where('storehouse_id', $storehouse->storehouse_id)
                                ->where('nomenclature_id', $nomenclature->nomenclature_id)
                                ->where('type', NomenclatureOperation::OPERATION_TYPE_REFUND);

                            $subtractQuantity = $storehouseOrderItems->sum('quantity') + $nomenclatureWithdraw->sum('quantity');

                            return [
                                'id' => $storehouse->storehouse_id,
                                'name' => $storehouse->storehouse_name,
                                'counts' => ($s->sum('quantity') + $nomenclatureRefund->sum('quantity')) - $subtractQuantity
                            ];
                        })
                ];
            });

        $nomenclatureTotals = $nomenclatures->map(fn($m) => $m['storehouses']->sum('counts'));

        $storehouses = $balances->pluck('storehouse_name', 'storehouse_id');

        return [
            'storehouses' => $storehouses,
            'nomenclatures' => $nomenclatures,
            'nomenclatureTotals' => $nomenclatureTotals
        ];
    }
}
