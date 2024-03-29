<?php

namespace App\Services;

use App\Models\NomenclatureArrival;
use App\Models\NomenclatureOperation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StorehouseBalanceService
{
    private array $filters = [];

    public function getNomenclatureBalances()
    {
        $orderItems = OrderItem::select(
            'nomenclature_id',
            DB::raw('SUM(quantity) as quantity')
        )->join(
            'orders',
            fn($q) => $q->on('orders.id', '=', 'order_items.order_id')
                ->where('orders.status', Order::STATUS_SOLD)
                ->where('orders.company_id', auth()->user()->company_id)
        )
            ->groupBy('nomenclature_id')
            ->get();

        $nomenclatureOperations = NomenclatureOperation::select(
            'type',
            'nomenclature_id',
            DB::raw('SUM(quantity) as quantity')
        )
            ->groupBy('type')
            ->groupBy('nomenclature_id')
            ->get();

        return NomenclatureArrival::select(
            'nomenclature_id',
            DB::raw('n.name AS nomenclature_name'),
            DB::raw('n.base_price AS nomenclature_base_price'),
            DB::raw('SUM(quantity) AS quantity'),
            DB::raw('u.name as unit_name'),
        )->join(
            'nomenclatures as n',
            fn($q) => $q->on('n.id', '=', 'nomenclature_arrivals.nomenclature_id')
                ->where(
                    fn($q) => $q->when(
                        Arr::get($this->filters, 'query'),
                        fn($q, $v) => $q->where('n.name', 'like', '%' . $v . '%')
                            ->orWhere('n.barcode', 'like', '%' . $v . '%')
                    )
                )
        )
            ->leftJoin('units as u', 'u.id', '=', 'n.unit_id')
            ->groupBy('nomenclature_id')
            ->get()
            ->transform(function ($m) use ($orderItems, $nomenclatureOperations) {
                $orderItem = $orderItems->where('nomenclature_id', $m->nomenclature_id)->first();
                $nomenclatureWithdraw = $nomenclatureOperations->where('nomenclature_id', $m->nomenclature_id)
                    ->where('type', NomenclatureOperation::OPERATION_TYPE_WITHDRAW)->first();

                $nomenclatureRefund = $nomenclatureOperations->where('nomenclature_id', $m->nomenclature_id)
                    ->where('type', NomenclatureOperation::OPERATION_TYPE_REFUND)->first();

                $subtractQuantity = ($orderItem?->quantity ?? 0) + ($nomenclatureWithdraw?->quantity ?? 0);

                return [
                    'id' => $m->nomenclature_id,
                    'nomenclature' => [
                        'name' => $m->nomenclature_name,
                        'base_price' => $m->nomenclature_base_price,
                    ],
                    'quantity' => ($m->quantity + ($nomenclatureRefund?->quantity ?? 0)) - $subtractQuantity,
                    'unit' => [
                        'name' => $m->unit_name
                    ]
                ];
            });
    }

    public function setFilters(array $filters): StorehouseBalanceService
    {
        $this->filters = $filters;

        return $this;
    }
}
