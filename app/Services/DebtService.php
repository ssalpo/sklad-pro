<?php

namespace App\Services;

use App\Models\Debt;

class DebtService
{
    public function store(array $data): Debt
    {
        return Debt::create($data);
    }

    public function update(int $id, array $data): Debt
    {
        $debt = Debt::findOrFail($id);

        $debt->update($data);

        return $debt;
    }

    public function delete(int $id)
    {
        $debt = Debt::findOrFail($id);

        $debt->delete();

        return $debt;
    }
}
