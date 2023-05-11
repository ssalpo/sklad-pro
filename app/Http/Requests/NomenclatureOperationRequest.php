<?php

namespace App\Http\Requests;

use App\Models\NomenclatureOperation;
use App\Models\Storehouse;
use Illuminate\Foundation\Http\FormRequest;

class NomenclatureOperationRequest extends FormRequest
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
        $rules = [
            'company_id' => 'required',
            'storehouse_id' => 'nullable|exists:storehouses,id',
            'type' => 'required|in:' . implode(',', array_keys(NomenclatureOperation::OPERATION_LABELS)),
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'quantity' => 'required|numeric|gt:0',
            'comment' => 'nullable|string'
        ];

        if(Storehouse::count() > 1) {
            $rules['storehouse_id'] = 'required|exists:storehouses,id';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'company_id' => auth()->user()?->company_id
        ]);
    }
}
