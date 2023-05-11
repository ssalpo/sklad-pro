<?php

namespace App\Services;

use App\Models\Nomenclature;
use App\Models\NomenclatureArrival;

class NomenclatureArrivalService
{
    public function store(array $data): NomenclatureArrival
    {
        return NomenclatureArrival::create(
            array_merge(
                $data,
                $this->attachNomenclaturePrices($data['nomenclature_id']),
                StorehouseService::getDefaultField($data['storehouse_id'] ?? null)
            )
        );
    }

    public function update(int $id, array $data): NomenclatureArrival
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        $nomenclatureArrival->update(
            array_merge(
                $data,
                $this->attachNomenclaturePrices($data['nomenclature_id']),
                StorehouseService::getDefaultField($data['storehouse_id'] ?? null)
            )
        );

        return $nomenclatureArrival;
    }

    public function attachNomenclaturePrices(int $nomenclatureId): array
    {
        $nomenclature= Nomenclature::findOrFail($nomenclatureId);

        return [
            'base_price' => $nomenclature->base_price,
            'price_for_sale' => $nomenclature->price_for_sale,
        ];
    }

    public function delete(int $id): NomenclatureArrival
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        $nomenclatureArrival->delete();

        return $nomenclatureArrival;
    }
}
