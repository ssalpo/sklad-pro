<?php

namespace App\Services;

use App\Models\Storehouse;

class storehouseService
{
    public function store(array $data): Storehouse
    {
        return Storehouse::create($data);
    }

    public function update(int $id, array $data): Storehouse
    {
        $storehouse = Storehouse::findOrFail($id);

        $storehouse->update($data);

        return $storehouse;
    }

    public function delete(int $id)
    {
        $storehouse = Storehouse::findOrFail($id);

        $storehouse->delete();

        return $storehouse;
    }
}
