<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Nomenclature;
use App\Models\Order;
use App\Models\Showcase;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $orderService
    )
    {
    }

    public function index()
    {
        $showcasesCount = Showcase::count();

        $orders = Order::with(['client', 'showcase'])->paginate()
            ->onEachSide(0)
            ->through(fn($m) => [
                'id' => $m->id,
                'amount' => $m->amount,
                'showcase' => ['name' => $m->showcase?->name],
                'profit' => $m->profit,
                'client' => ['name' => $m->client?->name],
                'created_at_formatted' => $m->created_at_formatted
            ]);

        return inertia('Orders/Index', compact('orders', 'showcasesCount'));
    }

    public function create()
    {
        $nomenclatures = Nomenclature::whereHas('nomenclatureArrivals')
            ->get()
            ->transform(
                fn($m) => [
                    'id' => $m->id,
                    'text' => $m->name
                ]
            );

        $showcasesCount = Showcase::count();

        return inertia('Orders/Edit', compact('nomenclatures', 'showcasesCount'));
    }

    public function store(OrderRequest $request)
    {
        $this->orderService->store($request->validated());

        return to_route('orders.index');
    }

    public function show(Order $order)
    {
        $order->load(['client', 'showcase', 'orderItems.nomenclature.unit']);

        $showcasesCount = Showcase::count();

        return inertia('Orders/Show', [
            'showcasesCount' => $showcasesCount,
            'order' => [
                'id' => $order->id,
                'amount' => $order->amount,
                'showcase' => ['name' => $order->showcase?->name],
                'profit' => $order->profit,
                'client' => ['name' => $order->client?->name],
                'items' => $order->orderItems->transform(fn($m) => [
                    'price_for_sale' => $m->price_for_sale,
                    'quantity' => $m->quantity,
                    'nomenclature' => ['name' => $m->nomenclature->name, 'unit' => $m->nomenclature->unit->name],
                    'total_amount' => $m->total_amount,
                    'total_profit' => $m->total_profit,
                ])
            ]
        ]);
    }
}
