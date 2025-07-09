<?php

namespace App\Http\Requests\API\Studio;

use Illuminate\Foundation\Http\FormRequest;

class StudioUpdateProfileRequest extends FormRequest
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
            'studio_name' => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . auth()->id(),
            'country'     => 'required|string|max:500',
            'city'        => 'required|string|max:500',
            'address'     => 'required|string|max:500',
            'language'    => 'required|string',
            'website_url' => 'nullable|url',
            'phone'       => 'required|string|max:20',

            'guest_spots'         => 'required|integer|min:1',
            'studio_type'         => 'required|string|in:Private Studio,Public Studio,Other',
            'require_portfolio'   => 'required|boolean',
            'accept_bookings'     => 'required|boolean',
            'preferred_duration'  => 'nullable|string',
            'commission_percent'  => 'required|numeric|min:0|max:100',


            'logo'     => 'required|file|mimes:jpg,png,pdf,zip|max:51200',
            'cover'    => 'required|file|mimes:jpg,png,pdf,zip|max:51200',
            'photos'   => 'required|array|min:1|max:5',
            'photos.*' => 'file|mimes:jpg,png,pdf,zip|max:51200',

            'supplies_provided' => 'required|array|min:1',
            'amenities' => 'required|array|min:1',
        ];
    }
}
