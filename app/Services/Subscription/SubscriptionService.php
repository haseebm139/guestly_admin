<?php

namespace App\Services\Subscription;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Repositories\API\SubscriptionRepositoryInterface;

class SubscriptionService extends BaseController
{
    protected $repo;

    public function __construct(SubscriptionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function listPlans()
    {

        $plans = $this->repo->getActivePlans();
        $plans = $this->repo->getActivePlans();
        return $this->sendResponse($plans, 'Plans fetched successfully.');
    }

    public function subscribeUser(array $data, $planId, $user)
    {
        $duration_days = 0;
        $plan = $this->repo->findPlanById($planId);
        if (!$plan) {
            return $this->sendError('Plan not found.');
        }

        $existing = $this->repo->getExistingSubscription($user->id, $planId);

        if ($existing && Carbon::now()->lt($existing->end_date)) {
            return $this->sendResponse([], 'You are already subscribed to this plan and it has not expired yet.');
        }

        if (isset($data['validity_unit']) && $data['validity_unit'] == 'years') {
            $duration_days = 365;
        }else if (isset($data['validity_unit']) && $data['validity_unit'] == 'months') {
            $duration_days = 30;
        }else{
            $duration_days = 3;
        }

        $start = Carbon::now();
        $end = $start->copy()->addDays( $duration_days);

        DB::beginTransaction();
        try {
            $subscription = $this->repo->createSubscription([
                'user_id' => $user->id,
                'plan_id' => $planId,
                'start_date' => $start,
                'end_date' => $end,
                'transaction_id' => $data['payment_id'] ?? null,
            ]);

            DB::commit();
            return $this->sendResponse($subscription, 'Plan purchased successfully.', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('An error occurred while processing your subscription.');
        }
    }
}
