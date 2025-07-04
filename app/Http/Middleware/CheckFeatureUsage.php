<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Feature;
use App\Models\UserFeature;
use App\Models\Subscription;
class CheckFeatureUsage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $subscription = $user->subscriptions()->latest()->first();

        // Ensure the user has a valid subscription
        if (!$subscription || !$subscription->isValid()) {
            return response()->json(['error' => 'Your subscription is expired or invalid.'], 403);
        }

        // Get the feature
        $feature = Feature::where('name', $featureName)->first();

        // Ensure the feature exists and belongs to the user's plan
        if (!$feature || !$subscription->plan->features->contains($feature)) {
            return response()->json(['error' => 'You do not have access to this feature.'], 403);
        }

        // Get the usage count for this feature
        $userFeature = UserFeature::firstOrCreate([
            'user_id' => $user->id,
            'feature_id' => $feature->id,
        ]);

        // Check if the feature is limited and if the user has exceeded the limit
        $limit = $this->getFeatureLimit($subscription, $feature);
        if ($userFeature->usage_count >= $limit) {
            return response()->json(['error' => "You have exceeded your usage limit for this feature."], 403);
        }

        return $next($request);
    }

    protected function getFeatureLimit(Subscription $subscription, Feature $feature)
    {
        // Define limits based on the feature name
        switch ($feature->name) {
            case 'Messaging':
                return $subscription->plan->name == 'Basic' ? 4 : ($subscription->plan->name == 'Pro' ? 10 : PHP_INT_MAX);
            // Add more feature limits here based on other features
            default:
                return PHP_INT_MAX; // No limit for other features
        }
    }
}
