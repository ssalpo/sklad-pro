<?php

namespace App\Services;

use App\Models\Debt;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DebtService
{
    public function store(array $data): Debt
    {
        $order = Order::findOrFail($data['order_id']);

        $this->validateCorrectClientForOrder($order, $data);

        $this->validateCorrectDebtAmount($order, $data);

        return Debt::create($data);
    }

    public function update(int $id, array $data): Debt
    {
        $debt = Debt::withSum('payments', 'amount')->findOrFail($id);

        $order = Order::findOrFail($data['order_id']);

        $this->validateCorrectDebtAmount($order, $data);

        $this->validateCorrectClientForOrder($order, $data);

        if ($data['amount'] < $debt->payments_sum_amount) {
            throw ValidationException::withMessages([
                'amount' => sprintf(
                    'Сумма долга не может быть ниже %s сом., так как у вас уже имеется погашение на данную сумму.',
                    $debt->payments_sum_amount
                )
            ]);
        }

        if ($data['amount'] > $debt->payments_sum_amount) {
            $data['is_paid'] = false;
        }

        $debt->update($data);

        return $debt;
    }

    public function delete(int $id)
    {
        $debt = Debt::findOrFail($id);

        DB::transaction(function () use ($debt) {
            $debt->payments()->delete();

            $debt->delete();
        });

        return $debt;
    }

    public function getTotalDebts()
    {
        return Debt::sum('amount');
    }

    private function validateCorrectDebtAmount(Order $order, array $data): void
    {
        if ($order->amount < $data['amount']) {
            throw ValidationException::withMessages([
                'amount' => sprintf('Сумма долга должно быть меньше или равно сумме заказа (%s c.)', $order->amount)
            ]);
        }
    }

    private function validateCorrectClientForOrder(Order $order, array $data): void
    {
        if ($order->client_id && $order->client_id !== $data['client_id']) {
            throw ValidationException::withMessages([
                'client_id' => 'Некорректный id клиента передан'
            ]);
        }
    }
}
