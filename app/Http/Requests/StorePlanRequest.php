<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StorePlanRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'validity_value' => 'required|numeric|min:1',
            'validity_unit' => 'required|in:days,weeks,months,years',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->with([
                    'type' => 'error',
                    'message' => $validator->errors()->first(), // just the first error
                ])
        );
    }
}
