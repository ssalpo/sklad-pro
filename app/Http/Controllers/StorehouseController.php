<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorehouseRequest;
use App\Models\Storehouse;
use App\Services\StorehouseService;
use App\Services\Toast;
use Illuminate\Http\Request;

class StorehouseController extends Controller
{
    public function __construct(
        public StorehouseService $storehouseService
    )
    {
    }

    public function index()
    {
        $storehouses = Storehouse::orderBy('created_at', 'DESC')->get();

        return inertia('Storehouses/Index', compact('storehouses'));
    }

    public function create()
    {
        return inertia('Storehouses/Edit');
    }

    public function store(StorehouseRequest $request)
    {
        $this->storehouseService->store($request->validated());

        Toast::success('Склад успешно добавлен.');

        return to_route('storehouses.index');
    }

    public function edit(Storehouse $storehouse)
    {
        return inertia('Storehouses/Edit', compact('storehouse'));
    }

    public function update(int $id, StorehouseRequest $request)
    {
        $this->storehouseService->update($id, $request->validated());

        Toast::success('Данные успешно изменены.');

        return to_route('storehouses.index');
    }

    public function destroy(int $id)
    {
        $storehouse = $this->storehouseService->delete($id);

        Toast::success(sprintf('"%s" успешно удалена.', $storehouse->name));

        return to_route('storehouses.index');
    }
}
