<?php

namespace App\Http\Controllers;

use App\Http\Requests\NomenclatureOperationRequest;
use App\Models\NomenclatureOperation;
use App\Models\Storehouse;
use App\Services\NomenclatureOperationService;
use Illuminate\Http\Request;

class NomenclatureOperationController extends Controller
{
    public function __construct(
        public NomenclatureOperationService $nomenclatureOperationService
    )
    {
    }

    public function index()
    {
        $storehousesCount = Storehouse::count();

        $nomenclatureOperations = NomenclatureOperation::with(['storehouse', 'nomenclature.unit'])
            ->whereType(\request('type'))
            ->orderBy('created_at', 'DESC')
            ->paginate()
            ->onEachSide(0);

        return inertia('NomenclatureOperations/Index', compact('nomenclatureOperations', 'storehousesCount'));
    }

    public function create()
    {
        $storehousesCount = Storehouse::count();

        return inertia('NomenclatureOperations/Edit', compact('storehousesCount'));
    }

    public function store(NomenclatureOperationRequest $request)
    {
        $this->nomenclatureOperationService->store($request->validated());

        return to_route('nomenclature-operations.index', ['type' => $request->type]);
    }

    public function edit(NomenclatureOperation $nomenclatureOperation)
    {
        $storehousesCount = Storehouse::count();

        return inertia('NomenclatureOperations/Edit', compact('nomenclatureOperation', 'storehousesCount'));
    }

    public function update(NomenclatureOperationRequest $request, int $id)
    {
        $this->nomenclatureOperationService->update($id, $request->validated());

        return to_route('nomenclature-operations.index', ['type' => $request->type]);
    }

    public function destroy(int $id)
    {
        $nomenclatureOperation = $this->nomenclatureOperationService->destroy($id);

        return to_route('nomenclature-operations.index', ['type' => $nomenclatureOperation->type]);
    }
}
