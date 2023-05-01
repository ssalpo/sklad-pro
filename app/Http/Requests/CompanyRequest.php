<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'name' => 'required|min:3|max:255',
            'email_show' => 'nullable|boolean',
            'email_required' => 'nullable|required',
            'phone_show' => 'nullable|required',
            'phone_required' => 'nullable|required',
            'phone_required_review_gte_than' => 'required|integer|min:0|max:5',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:1000'
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'user_id' => auth()->id()
        ]);
    }
}
