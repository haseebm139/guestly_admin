<?php

namespace App\Http\Requests\API\Artist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => 'nullable|string|max:255',
            'fields' => 'nullable|array|min:1',
            'fields.*.label' => 'nullable|string|max:255',
            'fields.*.type' => 'nullable|in:text,textarea,dropdown,multi_select',
            'fields.*.options' => 'nullable|array',
            'fields.*.is_required' => 'nullable|integer|in:0,1',
            'fields.*.order' => 'nullable|integer',
        ];
    }
}
