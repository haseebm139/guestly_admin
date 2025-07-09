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
        $studio = auth()->user();
        $data = $request->validated();
        $updatedStudio = $this->service->updateProfile($studio->id, $data);
        return $this->sendResponse(
            $updatedStudio,
            'Studio profile updated successfully.'
        );
    }


    public function updateImages(StudioUpdateProfileRequest $request)
    {
        $studio = auth()->user();
        $data = $request->validated();
        $updatedStudio = $this->service->updateProfile($studio->id, $data);
        return $this->sendResponse(
            $updatedStudio,
            'Studio Images updated successfully.'
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
