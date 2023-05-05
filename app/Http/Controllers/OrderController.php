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
        $nomenclatures = Nomenclature::all()->transform(fn($m) => [
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
}
