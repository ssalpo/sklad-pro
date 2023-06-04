<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Nomenclature;
use App\Models\Order;
use App\Models\Showcase;
use App\Models\Unit;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function nomenclatures()
    {
        return $this->transformCollection(
            Nomenclature::when(
                request('q'),
                static fn($q, $v) => $q->where('name', 'like', '%' . $v . '%')
                    ->orWhere('barcode', 'like', '%' . $v . '%')
            )->get()
        );
    }

    public function ordersWithClient()
    {
        return Order::when(request('q'), static fn($q, $v) => $q->where('id', 'like', '%' . $v . '%'))
            ->get()
            ->transform(fn($m) => [
                'id' => $m->id,
                'text' => sprintf('Заказ №%s', $m->id),
                'client_id' => $m->client_id,
                'amount' => $m->amount
            ]);
    }

    public function clients()
    {
        return $this->transformCollection(
            Client::when(
                request('q'),
                static fn($q, $v) => $q->where('name', 'like', '%' . $v . '%')
            )->get()
        );
    }

    public function showcases()
    {
        return $this->transformCollection(
            Showcase::when(
                request('q'),
                static fn($q, $v) => $q->where('name', 'like', '%' . $v . '%')
            )->get()
        );
    }

    public function units()
    {
        return $this->transformCollection(
            Unit::when(
                request('q'),
                static fn($q, $v) => $q->where('name', 'like', '%' . $v . '%')
            )->get()
        );
    }

    private function transformCollection($items)
    {
        return $items->transform(fn($m) => [
            'id' => $m->id,
            'text' => $m->name
        ]);
    }
}
