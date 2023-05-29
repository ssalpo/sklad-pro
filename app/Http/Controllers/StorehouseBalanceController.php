<?php

namespace App\Http\Controllers;

use App\Services\StorehouseBalanceService;
use Illuminate\Http\Request;

class StorehouseBalanceController extends Controller
{
    public function __construct(
        public StorehouseBalanceService $storehouseBalanceService
    )
    {
    }

    public function index()
    {
        $balances = $this->storehouseBalanceService
            ->setFilters(request()?->all())
            ->getNomenclatureBalances();

        return inertia('StorehouseBalance/Index', compact('balances'));
    }
}
