<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Nomenclature;
use App\Models\Order;
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
        $orders = Order::with('client')->paginate()
            ->onEachSide(0)
            ->through(fn($m) => [
                'id' => $m->id,
                'amount' => $m->amount,
                'profit' => $m->profit,
                'client' => ['name' => $m->client?->name],
                'created_at_formatted' => $m->created_at_formatted
            ]);

        return inertia('Orders/Index', compact('orders'));
    }

    public function create()
    {
        $nomenclatures = Nomenclature::whereHas('nomenclatureArrivals')
            ->get()
            ->transform(fn($m) => [
            'id' => $m->id,
            'text' => $m->name
        ]);

        return inertia('Orders/Edit', compact('nomenclatures'));
    }

    public function store(OrderRequest $request)
    {
        $this->orderService->store($request->validated());

        return to_route('orders.index');
    }

    public function show(Order $order)
    {
        $order->load(['client', 'orderItems.nomenclature']);

        return inertia('Orders/Show', [
            'order' => [
                'id' => $order->id,
                'amount' => $order->amount,
                'profit' => $order->profit,
                'client' => ['name' => $order->client?->name],
                'items' => $order->orderItems->transform(fn($m) => [
                    'price_for_sale' => $m->price_for_sale,
                    'quantity' => $m->quantity,
                    'nomenclature' => ['name' => $m->nomenclature->name],
                    'total_amount' => $m->total_amount,
                    'total_profit' => $m->total_profit,
                ])
            ]
        ]);
    }
}
