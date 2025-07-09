<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return $this->only([
            'id',
            'name',
            'last_name',
            'studio_name',
            'email',
            'profile_photo_path',
            'business_email',
            'country',
            'city',
            'address',
            'bio',
            'language',
            'website_url',
            'phone',
            'emergency_phone',
            'front_doc',
            'back_doc',
            'google_id',
            'facebook_id',
            'apple_id',
            'verification_type',
            'avatar',
            'document_front',
            'document_back',
            'studio_logo',
            'studio_cover',
            'guest_spots',
            'studio_type',
            'otp',
            'email_verified',
            'role_id',
            'user_type',
            'gender',
            'verification_status',
            'require_portfolio',
            'accept_bookings',
            'preferred_duration',
            'longitude',
            'latitude',
            'date_of_birth',
            'email_verified_at',
            'created_at',
            'updated_at',
            'last_login_at',
            'last_login_ip',
        ])
        ->merge([
            'tattoo_styles' => $this->whenLoaded('tattooStyles', fn () => $this->tattooStyles ?? []),
            'supplies' => $this->whenLoaded('supplies', fn () => $this->supplies ?? []),
            'stationAmenities' => $this->whenLoaded('stationAmenities', fn () => $this->stationAmenities ?? []),
            'studioImages' => $this->whenLoaded('studioImages', fn () => $this->studioImages ?? []),
        ]);
    }
}
