<?php

namespace App\Repositories\API;

use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\API\SubscriptionRepositoryInterface;
class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getActivePlans()
    {
        $user_type = auth()->user()->user_type ?? 'user';
         
        return Plan::select('id', 'name', 'user_type','m_price', 'y_price', 'status')->where('status', '1')
            ->with(['features' => function ($q) {
                $q->select('features.id', 'features.name', 'features.code', 'features.status')
                    ->where('status', '1');
            }])
            ->where('user_type', $user_type)
            ->get();
    }

    public function findPlanById($planId)
    {
        return Plan::find($planId);
    }

    public function getExistingSubscription($userId, $planId)
    {
        return Subscription::where('user_id', $userId)
            ->where('plan_id', $planId)
            ->first();
    }

    public function createSubscription(array $data)
    {
        return Subscription::create($data);
    }

    public function deactivateUserSubscriptions($userId)
    {
        return Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);
    }
}
