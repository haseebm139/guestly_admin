<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Studio\StudioProfileService;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\API\Studio\StudioUpdateProfileRequest;
use App\Models\FlashTattoo;
use App\Models\User;
use App\Models\Gallery;

class StudioController extends BaseController
{
    protected $service;

    public function __construct(StudioProfileService  $service)
    {
        $this->service = $service;
    }


    public function update(StudioUpdateProfileRequest $request)
    {
        
        $studio = auth()->user();
        $data = $request->validated();

        $updatedStudio = $this->service->updateProfile($studio->id, $data);
        if (!$updatedStudio) {
            return $this->sendError('Studio not found or update failed', 404);
        }
        return $this->sendResponse(
            $updatedStudio,
            'Studio profile updated successfully.'
        );
        try {
        }catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating the profile', 500);

        }
    }


    public function updateImages(StudioUpdateProfileRequest $request)
    {
        try {
            //code...
            $studio = auth()->user();
            $data = $request->validated();
            $updatedStudio = $this->service->updateProfile($studio->id, $data);
            if (!$updatedStudio) {
                return $this->sendError('Studio not found or update failed', 404);
            }
            return $this->sendResponse(
                $updatedStudio,
                'Studio Images updated successfully.'
            );
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating studio images', 500);
        }
    }


    public function show()
    {
        try {
            //code...
            $studio = auth()->user();
            $profile = $this->service->getProfile($studio->id);
            if (!$profile) {
                return $this->sendError('Studio profile not found', 404);
            }
            return $this->sendResponse(
                $profile,'Studio profile fetched successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Something went wrong while fetching the profile', 500);

        }
    }



    public function getGuests(Request $request)
    {
        $studio = auth()->user();
        $range = $request->query('range', 'today'); // default to today
        if (!in_array($range, ['today', 'week', '15days', 'month'])) {
            return $this->sendError('Invalid date range.');
        }
        $perPage = $request->query('per_page', 20);
        $guests = $this->service->getGuests($studio->id, $range, $perPage);
        return $this->sendResponse($guests, 'Today guests fetched successfully.');
        try {
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong while fetching today guests', 500);
        }
    }
    public function upcommingGuests(Request $request)
    {
        try {
            $studio = $request->user(); // Authenticated studio user
            $perPage = $request->query('per_page', 20);

            $data = $this->service->getUpcomingGuests($studio->id, $perPage);

            return $this->sendResponse($data, 'Upcoming guests retrieved.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong while fetching upcoming guests', 500);
        }
    }

    public function requestGuests(Request $request)
    {
        $studio = $request->user(); // Assuming studio is logged in
        $status = $request->query('status', 'pending'); // default to pending
        $perPage = $request->query('per_page', 10);

        $data = $this->service->getGuestRequests($studio->id, $status, $perPage);

        return $this->sendResponse($data, 'Guest artist requests retrieved successfully.');
    }

    public function artist(Request $request)
    {

        $filters = $request->only([
            'search',
            'name',
            'tattoo_style',
            'email',
            'city',
            'country',
            'language',
            'latitude',
            'longitude',
            'radius',
            'per_page'
        ]);

        $artist = $this->service->getArtist($filters);
        return $this->sendResponse($artist, 'Artist profile fetched successfully.');
    }

    /**
     * Get complete detailed artist profile
     * 
     * @param int $artistId
     * @return \Illuminate\Http\JsonResponse
     */
    public function artistProfile($artistId)
    {
        try {
            $artist = User::where('id', $artistId)
                ->where('user_type', 'artist')
                ->firstOrFail();

            // $artist = $artist->load(['supplies', 'stationAmenities', 'studioImages', 'designSpecialties', 'tattooStyles', 'activeSubscription.plan']);
            $artist = $artist->load(['tattooStyles']);

            // Get flash tattoos
            $flashTattoos = FlashTattoo::where('artist_id', $artistId)
                ->with('options')
                ->orderBy('created_at', 'desc')
                ->get();

            // Add flash tattoos to the artist object
            $artist->flash_tattoos = $flashTattoos;

            return $this->sendResponse($artist, 'Artist profile fetched successfully.');
            
        } catch (\Throwable $th) {
            \Log::error('Error fetching artist profile: ' . $th->getMessage());
            return $this->sendError('Something went wrong while fetching the artist profile', [], 500);
        }
    }
}
