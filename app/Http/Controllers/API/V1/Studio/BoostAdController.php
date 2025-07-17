<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Repositories\API\Studio\BoostAdRepositoryInterface;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class BoostAdController extends BaseController
{
     protected $repo;

    public function __construct(BoostAdRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'duration_days' => 'required|integer|min:1',
            'budget' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
        }


        try {

            $data = $validator->validated();
            $data['user_id'] = Auth::user()->id;
            $ad = $this->repo->create($data);

            return $this->sendResponse($ad, 'Ad created successfully.', 201);

        } catch (\Throwable $th) {
            return $this->sendError('Failed to create ad',$errorMessages = [], 500);
        }
    }

    public function list()
    {
        try {
            $ads = $this->repo->getByStudio(Auth::user()->id);
            return $this->sendResponse($ads, 'Ads fetched successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch ads',$errorMessages = [], 500);
        }
    }

    public function stop($id)
    {
        try {
            $ad = $this->repo->stop($id, Auth::user()->id);

            if (!$ad) {
                return $this->sendError('Ad not found or already completed.',$errorMessages = [], 404);
            }

            return $this->sendResponse($ad, 'Ad stopped successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Error stopping ad',$errorMessages = [], 500);
        }
    }

    public function boostAgain($id)
    {
        try {
            $ad = $this->repo->boostAgain($id, Auth::user()->id);

            if (!$ad) {
                return $this->sendError('Original ad not found or not completed.',$errorMessages = [], 404);
            }

            return $this->sendResponse($ad, 'Ad boosted again successfully.', 201);
        } catch (\Throwable $th) {
            return $this->sendError('Failed to boost ad again',$errorMessages = [], 500);
        }
    }

    public function boosts()
    {
        try {
            $data['active'] = $this->repo->getActiveBoostAd(Auth::user()->id);
            $data['expired'] = $this->repo->getUnactiveBoostAd(Auth::user()->id);
            return $this->sendResponse($data, 'Boosts fetched successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch boosts',$errorMessages = [], 500);
        }
    }
}
