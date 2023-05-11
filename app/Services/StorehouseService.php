<?php

namespace App\Services;

use App\Models\Storehouse;
use Illuminate\Support\Facades\DB;

class StorehouseService
{
    public function store(array $data): Storehouse
    {
        return DB::transaction(function () use ($data) {
            if (Storehouse::count() === 1) {
                Storehouse::latest()
                    ->update(['is_default' => false]);
            }

            return Storehouse::create($data);
        });
    }

    public function update(int $id, array $data): Storehouse
    {
        $storehouse = Storehouse::findOrFail($id);

        $storehouse->update($data);

        return $storehouse;
    }

    public function delete(int $id)
    {
        $storehouse = Storehouse::notDefault()->findOrFail($id);

        DB::transaction(function () use ($storehouse, $id) {
            if (Storehouse::count() === 2) {
                Storehouse::whereNot('id', $id)
                    ->latest()
                    ->update(['is_default' => true]);
            }

            $storehouse->delete();
        });

        return $storehouse;
    }

    public static function getDefaultField(?int $storehouseId): null|array
    {
        if ($storehouseId) {
            return [];
        }

        return ['storehouse_id' => Storehouse::getDefault()->id];
    }
}
