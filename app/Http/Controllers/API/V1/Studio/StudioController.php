<?php

namespace App\Http\Controllers\API\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Studio\StudioProfileService;
use App\Http\Controllers\API\BaseController as BaseController;


class StudioController extends BaseController
{
    protected $service;

    public function __construct(StudioProfileService  $service)
    {
        $this->service = $service;
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'studio_name' => 'nullable|string|max:255',
            'business_email' => 'nullable|email',
            'studio_address' => 'nullable|string',
            'language' => 'nullable|string',
            'website_url' => 'nullable|url',
            'phone' => 'nullable|string',
            'guest_spots' => 'nullable|integer',
            'studio_type' => 'nullable|string',
            'require_portfolio' => 'nullable|string',
            'accept_bookings' => 'nullable|string',
            'preferred_duration' => 'nullable|string',
            'commission_percent' => 'nullable|numeric|min:0|max:100',
            'supplies_provided' => 'nullable|array',
            'amenities' => 'nullable|array',
        ]);
        $studio = auth()->user();

        $data = $request->all(); // Apply per-step validation if needed

        $updatedStudio = $this->service->updateProfile($studio->id, $data);

        return $this->sendResponse(
            $updatedStudio,
            'Studio profile updated successfully.'
        );
    }

    public function show()
    {

        $studio = auth()->user();
        $profile = $this->service->getProfile($studio->id);

        return $this->sendResponse(
            $profile,'Studio profile fetched successfully.');
    }
}
