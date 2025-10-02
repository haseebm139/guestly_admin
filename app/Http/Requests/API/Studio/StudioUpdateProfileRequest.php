<?php

namespace App\Http\Requests\API\Studio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'studio_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'business_email' => 'nullable|email',
            'studio_address' => 'nullable|string',
            'address' => 'nullable|string',
            'fcm_token' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'language' => 'nullable|string',
            'website_url' => 'nullable|url',
            'phone' => 'nullable|string',
            'guest_spots' => 'nullable|integer',
            'total_stations' => 'nullable|integer',
            'studio_type' => 'nullable|string',
            'require_portfolio' => 'nullable|boolean',
            'accept_bookings' => 'nullable|boolean',
            'preferred_duration' => 'nullable|string',
            'commission_type' => 'nullable|in:0,1,2', // fixed, percentage, custom
            'commission_value' => 'nullable|numeric|min:0',
            'avatar'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_verified'=>'nullable|boolean',
            'email_verified'=>'nullable|boolean', 
            // Array fields
            'supplies_provided' => 'nullable|array|max:10',
            'supplies_provided.*' => 'integer|exists:supplies,id',

            'amenities' => 'nullable|array|max:10',
            'amenities.*' => 'integer|exists:station_amenities,id',

            // File fields
            'studio_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'studio_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'studio_images' => 'nullable|array|max:5',
            'studio_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',

            /* ✅ NEW: design specialties (exists in `design_specialties` table) */
            'design_specialties'   => 'nullable|array|max:10',
            'design_specialties.*' => 'integer|exists:design_specialties,id',

            /* ✅ NEW: guest-related fields */
            'guest_to_choose' => 'nullable|boolean',
            'guest_policy'    => 'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120',

            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
