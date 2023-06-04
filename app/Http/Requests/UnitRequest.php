<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
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
            'company_id' => 'required|integer',
            'name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('units', 'name')
                    ->ignore($this->unit)
                    ->where(fn($q) => $q->whereCompanyId(auth()->user()?->company_id))
            ],
            // 'required|min:1|max:255|unique:units,name,' . $this->unit
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'company_id' => auth()->user()->company_id
        ]);
    }
}
