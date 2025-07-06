<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
     public function rules(): array
    {
         return [
            'social_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ];
    }

    public function failedValidation(Validator $validator)
    {


        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'data' => [],
        ], 422));
    }
}
