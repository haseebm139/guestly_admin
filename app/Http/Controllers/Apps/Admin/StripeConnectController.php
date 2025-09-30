<?php

namespace App\Http\Controllers\Apps\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StripeConnectController extends Controller
{
    public function start(Request $request, User $user): RedirectResponse
    {
        if ($user->user_type !== 'artist') {
            return back()->with(['type' => 'error', 'message' => 'Only artists can connect Stripe.']);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Create connected account if missing
        if (! $user->stripe_account_id) {
            $account = \Stripe\Account::create([
                'type' => 'express',
                'email' => $user->email,
                'country' => 'US',
                'business_type' => 'individual',
                'capabilities' => [
                    'transfers' => ['requested' => true],
                ],
            ]);
            $user->update(['stripe_account_id' => $account->id]);
        }

        $returnUrl = url('/admin/stripe/connect/return?user='.$user->id);
        $refreshUrl = url('/admin/stripe/connect/refresh?user='.$user->id);

        $accountLink = \Stripe\AccountLink::create([
            'account' => $user->stripe_account_id,
            'refresh_url' => $refreshUrl,
            'return_url' => $returnUrl,
            'type' => 'account_onboarding',
        ]);

        return redirect()->away($accountLink->url);
    }

    public function refresh(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->integer('user'));
        return $this->start($request, $user);
    }

    public function returned(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->integer('user'));

        // Optionally check requirements to confirm onboarding
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $account = \Stripe\Account::retrieve($user->stripe_account_id);
            if (!empty($account->requirements->currently_due)) {
                return redirect()->route('user-management.artists.show', $user)
                    ->with(['type' => 'info', 'message' => 'Stripe onboarding incomplete. Please finish all steps.']);
            }
        } catch (\Throwable $e) {
            // ignore and continue
        }

        return redirect()->route('user-management.artists.show', $user)
            ->with(['type' => 'success', 'message' => 'Stripe account connected.']);
    }
}



