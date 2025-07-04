<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyPlanRequest extends FormRequest
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
            'payment_id' => 'required|string',  // Payment ID is required and should be a string

        ];
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'payment_id.required' => 'The payment ID is required.',
            'payment_id.string' => 'The payment ID must be a valid string.',
            'plan_id.required' => 'The plan ID is required.',
            'plan_id.exists' => 'The selected plan is invalid.',
        ];
    }
}
