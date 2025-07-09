<?php

namespace App\Http\Controllers\API\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Studio\StudioProfileService;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\API\Studio\StudioUpdateProfileRequest;

class StudioController extends BaseController
{
    protected $service;

    public function __construct(StudioProfileService  $service)
    {
        $this->service = $service;
    }


    public function update(StudioUpdateProfileRequest $request)
    {
        try {
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
}
