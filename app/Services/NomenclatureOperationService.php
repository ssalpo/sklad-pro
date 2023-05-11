<?php

namespace App\Services;

use App\Models\Nomenclature;
use App\Models\NomenclatureOperation;

class NomenclatureOperationService
{
    public function store(array $data): NomenclatureOperation
    {
        $data['base_price'] = Nomenclature::findOrFail($data['nomenclature_id'])?->base_price;

        return NomenclatureOperation::create(array_merge(
            $data,
            StorehouseService::getDefaultField($data['storehouse_id'] ?? null)
        ));
    }

    public function update(int $id, array $data): NomenclatureOperation
    {
        $nomenclatureOperation = NomenclatureOperation::whereType($data['type'])->findOrFail($id);

        $nomenclatureOperation->update(array_merge(
            $data,
            StorehouseService::getDefaultField($data['storehouse_id'] ?? null)
        ));

        return $nomenclatureOperation;
    }

    public function destroy(int $id)
    {
        $nomenclatureOperation = NomenclatureOperation::findOrFail($id);

        $nomenclatureOperation->delete();

        return $nomenclatureOperation;
    }
}
