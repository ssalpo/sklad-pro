<?php

namespace App\Services;

use App\Models\Nomenclature;
use App\Models\NomenclatureArrival;

class NomenclatureArrivalService
{
    public function store(array $data): NomenclatureArrival
    {
        StorehouseService::attachDefault($data);

        return NomenclatureArrival::create(
            array_merge(
                $data,
                $this->attachNomenclaturePrices($data['nomenclature_id'])
            )
        );
    }

    public function update(int $id, array $data): NomenclatureArrival
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        StorehouseService::attachDefault($data);

        $nomenclatureArrival->update(
            array_merge(
                $data,
                $this->attachNomenclaturePrices($data['nomenclature_id']),
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
