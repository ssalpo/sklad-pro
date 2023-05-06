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
}
