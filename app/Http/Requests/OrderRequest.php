<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'showcase_id' => 'nullable|exists:showcases,id',
            'company_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'orderItems' => 'required|array',
            'orderItems.*.nomenclature_id' => 'required|exists:nomenclatures,id',
            'orderItems.*.quantity' => 'required|integer|gt:0',
            'orderItems.*.price_for_sale' => 'required|regex:/^\d+(\.\d{1,3})?$/',
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'company_id' => auth()->user()->company_id,
            'user_id' => auth()->id()
        ]);
    }
}
