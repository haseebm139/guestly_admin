<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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

            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'nullable|in:artist,studio',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'fcm_token' => 'nullable|string'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required'    => 'Please provide your email address.',
            'email.email'       => 'The email address format is invalid.',
            'password.required' => 'Please enter your password.',

            'user_type.required' => 'User type is required.',
            'user_type.in'       => 'User type must be either artist or studio.',

            'latitude.numeric'   => 'Latitude must be a number.',
            'latitude.between'   => 'Latitude must be between -90 and 90 degrees.',

            'longitude.numeric'  => 'Longitude must be a number.',
            'longitude.between'  => 'Longitude must be between -180 and 180 degrees.',
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
