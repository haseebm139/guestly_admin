<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Subscription;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BuyPlanRequest; // Import the BuyPlanRequest
class SubscriptionController extends BaseController
{


    /**
     * Handle buying a plan and subscribing the user.
     *
     * @param  BuyPlanRequest  $request
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public function buyPlan(BuyPlanRequest $request,$planId )
    {



    }
    /**
     * Calculate the subscription end date based on the plan's validity.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \App\Models\Plan  $plan
     * @return \Carbon\Carbon
     */
    protected function calculateEndDate($startDate, $plan)
    {
        // Add the validity value to the start date based on the validity unit
        switch ($plan->validity_unit) {
            case 'days':
                return $startDate->copy()->addDays($plan->duration_days);
            case 'weeks':
                return $startDate->copy()->addDays($plan->duration_days);
            case 'months':
                return $startDate->copy()->addDays($plan->duration_days);
            case 'years':
                return $startDate->copy()->addDays($plan->duration_days);
            default:
                return $startDate;  // Default to no change if the unit is invalid
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $plans = Plan::select('id', 'name', 'price', 'validity_value', 'validity_unit','duration_days','status')
            ->where('status', '1')
            ->with(['features' => function ($query) {
            $query->select('features.id', 'features.name', 'features.code', 'features.status')
                ->where('status', '1');  // Filter features to include only those with status = 1
        }])
            ->get();
        return $this->sendResponse($plans, 'Plans fetched successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(BuyPlanRequest $request,$planId)
    {
        // $planId = $request->input('plan_id');
        $user = Auth::user();  // Get the authenticated user
        $plan = Plan::find($planId);

        if (!$plan) {
            return $this->sendError('Plan not found.');
        }

        // Check if the user is already subscribed to this plan
        $existingSubscription = Subscription::where('user_id', $user->id)
                                            ->where('plan_id', $planId)
                                            ->first();

        if ($existingSubscription) {
            if (Carbon::now()->lessThan($existingSubscription->end_date)) {
                return $this->sendResponse([], 'You are already subscribed to this plan and it has not expired yet.');
            }
            return $this->sendResponse([], 'You are already subscribed to this plan.');
        }

        $paymentId = $request->input('payment_id');

        $startDate = Carbon::now();
        $endDate = $this->calculateEndDate($startDate, $plan);

        \DB::beginTransaction();
        try {
            // Create the subscription for the user
            $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $planId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'transaction_id' => $paymentId,  // Store the payment transaction ID
                ]);

            \DB::commit();
            return $this->sendResponse($subscription, 'Plan purchased successfully.', 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            \DB::rollBack();
            return $this->sendError('An error occurred while processing your subscription.', [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
