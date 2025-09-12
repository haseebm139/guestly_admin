<?php

namespace App\Repositories\API;

interface SubscriptionRepositoryInterface
{
    public function getActivePlans();
    public function findPlanById($planId);
    public function deactivateUserSubscriptions($userId);
    public function getExistingSubscription($userId, $planId);
    public function createSubscription(array $data);
}
