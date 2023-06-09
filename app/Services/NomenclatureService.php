<?php

namespace App\Services;

use App\Models\Nomenclature;

class NomenclatureService
{
    public function store(array $data)
    {
        return Nomenclature::create($data);
    }

    public function update(int $id, array $data): Nomenclature
    {
        $nomenclature = Nomenclature::findOrFail($id);

        $nomenclature->update($data);

        return $nomenclature;
    }

    public function delete(int $id)
    {
        $nomenclature = Nomenclature::findOrFail($id);

        $nomenclature->delete();

        return $nomenclature;
    }

    public function changeBarcode(int $nomenclatureId, int $code)
    {
        $nomenclature = Nomenclature::findOrFail($nomenclatureId);

        $nomenclature->update(['barcode' => $code]);

        return $nomenclature;
    }

    public function generateRandomBarcode(): int
    {
        do {
            $code = random_int(1000000000, 99999999999);
        } while (Nomenclature::where("barcode", $code)->exists());

        return $code;
    }
}
