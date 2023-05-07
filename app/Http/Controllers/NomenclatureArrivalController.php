<?php

namespace App\Http\Controllers;

use App\Http\Requests\NomenclatureArrivalRequest;
use App\Models\NomenclatureArrival;
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
        $nomenclatureArrivals = NomenclatureArrival::with('nomenclature.unit')
            ->paginate()
            ->onEachSide(0)
            ->through(fn($m) => [
                'id' => $m->id,
                'nomenclature' => ['name' => $m->nomenclature->name, 'unit' => $m->nomenclature->unit->name],
                'quantity' => $m->quantity,
                'base_price' => $m->base_price,
                'price_for_sale' => $m->price_for_sale,
                'arrival_at_formatted' => $m->arrival_at_formatted,
                'created_at_formatted' => $m->created_at_formatted,
                'comment' => $m->comment,
            ]);

        return inertia('NomenclatureArrivals/Index', compact('nomenclatureArrivals'));
    }

    public function create()
    {
        return inertia('NomenclatureArrivals/Edit');
    }

    public function store(NomenclatureArrivalRequest $request)
    {
        $this->nomenclatureArrivalService->store($request->validated());

        Toast::success('Новый приход успешно добавлен.');

        return to_route('nomenclature-arrivals.index');
    }

    public function edit(int $id)
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        return inertia('NomenclatureArrivals/Edit', compact('nomenclatureArrival'));
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
