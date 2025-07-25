<?php

namespace App\Http\Controllers\API\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Artist\ArtistProfileService;
use App\Http\Requests\API\Artist\ArtistUpdateProfileRequest;

use App\Http\Controllers\API\BaseController as BaseController;
class ArtistController extends BaseController
{
    protected $service;

    public function __construct(ArtistProfileService  $service)
    {
        $this->service = $service;
    }

    public function update(ArtistUpdateProfileRequest $request)
    {
        $artist = auth()->user();
        $data = $request->validated();
        $updatedArtist = $this->service->updateProfile($artist->id, $data);
        if (!$updatedArtist) {
            return $this->sendError('Artist not found or update failed', 404);
        }

        return $this->sendResponse(
            $updatedArtist,
            'Artist profile updated successfully.'
        );
        try {
        }catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating the profile', 500);

        }
    }

    public function updateImages(ArtistUpdateProfileRequest $request)
    {
        try {
            $artist = auth()->user();
            $data = $request->validated();
            $updatedArtist = $this->service->updateProfile($artist->id, $data);
            if (!$updatedArtist) {
                return $this->sendError('Artist not found or update failed', 404);
            }
            return $this->sendResponse($updatedArtist,'Artist Images updated successfully.');
            //code...
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating artist images', 500);
        }
    }

    public function show()
    {
        try {
            //code...
            $artist = auth()->user();
            $profile = $this->service->getProfile($artist->id);
            if (!$profile) {
                return $this->sendError('Artist profile not found', 404);
            }
            return $this->sendResponse(
                $profile,'Artist profile fetched successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Something went wrong while fetching the profile', 500);

        }
    }


    public function studios(Request $request)
    {

        try {
            $perPage = $request->get('per_page', 10);
            $studios = $this->service->getStudios($perPage);
            return $studios
                ? $this->sendResponse($studios, 'Studios fetched successfully.')
                : $this->sendError('No studios found.',$errorMessages = [], 404);
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch studios.',$errorMessages = [], 500);
        }
    }

    public function studio(int $id)
    {

        try {
            $studio = $this->service->getStudio($id);

            return $studio
                ? $this->sendResponse($studio,
                                    'Studio fetched successfully.')
                : $this->sendError('Studio not found.', 404);

        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch studio.', 500);
        }
    }




}
