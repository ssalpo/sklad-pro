<?php

namespace App\Services;

use App\Models\NomenclatureArrival;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class NomenclatureArrivalService
{
    public function store(array $data): NomenclatureArrival
    {
        return NomenclatureArrival::create($data);
    }

    public function update(int $id, array $data): NomenclatureArrival
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        $nomenclatureArrival->update($data);

        return $nomenclatureArrival;
    }

    public function delete(int $id): NomenclatureArrival
    {
        $nomenclatureArrival = NomenclatureArrival::findOrFail($id);

        $nomenclatureArrival->delete();

        return $nomenclatureArrival;
    }

    public function getNomenclatureGroupedByPrice(string $searchQuery = null): Collection|array
    {
        return NomenclatureArrival::selectRaw('nomenclature_arrivals.nomenclature_id, nomenclatures.name, nomenclature_arrivals.price_for_sale')
            ->join(
                'nomenclatures', fn($q) => $q->on('nomenclatures.id', '=', 'nomenclature_arrivals.nomenclature_id')
            )
            ->where('nomenclature_arrivals.company_id', auth()->user()?->company_id)
            ->when(
                $searchQuery,
                fn($q, $v) => $q->where('nomenclature_arrivals.price_for_sale', 'like', '%' . $v . '%')
                    ->orWhere('nomenclatures.name', 'like', '%' . $v . '%')
            )
            ->groupBy(DB::raw('nomenclature_arrivals.nomenclature_id, nomenclature_arrivals.price_for_sale'))
            ->get();
    }
}
