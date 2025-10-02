<?php

namespace App\Http\Requests\API\Artist;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ArtistUpdateProfileRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'fcm_token' => 'nullable|string',
            'emergency_phone' => 'nullable|string',
            'bio' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'phone_verified'=>'nullable|boolean',
            'email_verified'=>'nullable|boolean',            
            'tattoo_style' => 'nullable|array',
            'avatar'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tattoo_style.*' => 'integer|exists:tattoo_styles,id',
            'is_active' => 'nullable|boolean',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => [],
            ], 422)
        );

    }
}
