<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Services\Studio\StudioService;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Supply;
class HomeController extends BaseController
{

    protected $service;
    public function __construct(StudioService $service)
    {
        $this->service = $service;
    }

    public function lookups()
    {
        try {
            $data = $this->service->lookups();

            return $this->sendResponse($data, 'Lookup tables fetched.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch lookups.', 500);
        }
    }

}
