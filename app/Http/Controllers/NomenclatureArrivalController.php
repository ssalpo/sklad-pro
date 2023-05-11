<?php

namespace App\Http\Controllers;

use App\Http\Requests\NomenclatureArrivalRequest;
use App\Models\NomenclatureArrival;
use App\Models\Storehouse;
use App\Services\NomenclatureArrivalService;
use App\Services\Toast;

class NomenclatureArrivalController extends Controller
{
    public function __construct(
        public NomenclatureArrivalService $nomenclatureArrivalService
    )
    {
    }

    public function index()
    {
        $nomenclatureArrivals = NomenclatureArrival::with('storehouse','nomenclature.unit')
            ->orderBy('arrival_at', 'DESC')
            ->paginate()
            ->onEachSide(0);

        $storehousesCount = Storehouse::count();

        return inertia('NomenclatureArrivals/Index', compact('nomenclatureArrivals', 'storehousesCount'));
    }

    public function create()
    {
        $storehousesCount = Storehouse::count();

        return inertia('NomenclatureArrivals/Edit', compact('storehousesCount'));
    }

    public function store(NomenclatureArrivalRequest $request)
    {
        $this->nomenclatureArrivalService->store($request->validated());

        Toast::success('Новый приход успешно добавлен.');

        return to_route('nomenclature-arrivals.index');
    }

    public function edit(int $id)
    {
        $storehousesCount = Storehouse::count();

        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        return inertia('NomenclatureArrivals/Edit', compact('nomenclatureArrival', 'storehousesCount'));
    }

    public function update(NomenclatureArrivalRequest $request, int $id)
    {
        $this->nomenclatureArrivalService->update($id, $request->validated());

        Toast::success('Данные по приходу успешно изменены.');

        return to_route('nomenclature-arrivals.index');
    }

    public function destroy(int $id)
    {
        $nomenclatureArrival = $this->nomenclatureArrivalService->delete($id);

        Toast::success(sprintf('Приход №%s успешно удален.', $nomenclatureArrival->id));

        return to_route('nomenclature-arrivals.index');
    }
}
