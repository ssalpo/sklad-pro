<?php

namespace App\Http\Controllers;

use App\Services\AnalyticService;

class DashboardController extends Controller
{
    public function __construct(
        public AnalyticService $analyticService
    )
    {
    }

    public function index()
    {
        $filterParams = request()?->all();

        $dateFrom = request()?->input('date.0') ?? now();
        $dateTo = request()?->input('date.1') ?? now();

        $totalProfitAmount = $this->analyticService->setFilters($filterParams)
            ->ordersProfitInRange($dateFrom, $dateTo);

        $totalSalesAmount = $this->analyticService->setFilters($filterParams)
            ->ordersAmountInRange($dateFrom, $dateTo);

        $nomenclatureProfits = $this->analyticService->setFilters($filterParams)
            ->getNomenclatureTotalsInRange($dateFrom, $dateTo);

        return inertia('Dashboard', compact('totalProfitAmount', 'totalSalesAmount', 'nomenclatureProfits', 'filterParams'));
    }
}
