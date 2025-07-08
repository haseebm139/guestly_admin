<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Subscription\SubscriptionService;
use App\Http\Requests\BuyPlanRequest;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {

        return $this->subscriptionService->listPlans();
    }

    public function buyPlan(BuyPlanRequest $request, $planId)
    {
        return $this->subscriptionService->subscribeUser($request->all(), $planId, Auth::user());
    }
}
