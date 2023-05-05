<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NomenclatureArrivalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required',
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'quantity' => 'required|numeric|gt:0',
            'base_price' => 'required|regex:/^\d+(\.\d{1,3})?$/|gt:0',
            'price_for_sale' => 'required|regex:/^\d+(\.\d{1,3})?$/|gt:0',
            'comment' => 'nullable|string',
            'arrival_at' => 'nullable|date_format:Y-m-d H:i'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'company_id' => auth()->user()->company_id,
            'arrival_at' => ($this->arrival_at ? Carbon::parse($this->arrival_at) : now())->format('Y-m-d H:i')
        ]);
    }
}
