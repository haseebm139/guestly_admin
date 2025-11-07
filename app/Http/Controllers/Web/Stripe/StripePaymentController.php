<?php

namespace App\Http\Controllers\Web\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
    }

    /**
     * Create PaymentIntent and return client_secret
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|integer',
            'billing_cycle' => 'required|in:monthly,yearly',
            'plan_name' => 'nullable|string'
        ]);

        $planId = $request->input('plan_id');
        $billingCycle = $request->input('billing_cycle');

        $plan = DB::table('plans')->where('id', $planId)->first();

        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }

        $amountDecimal = $billingCycle === 'yearly' ? $plan->y_price : $plan->m_price;
        $amount = (int) round(floatval($amountDecimal) * 100);

        if ($amount <= 0) {
            return response()->json([
                'free' => true,
                'message' => 'Free plan, no payment required'
            ]);
        }

        try {
            $user = Auth::user();

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => 'Payment for ' . $plan->name . ' (' . ucfirst($billingCycle) . ' plan)',
                'metadata' => [
                    'user_id' => $user->id ?? null,
                    'plan_id' => $planId,
                    'billing_cycle' => $billingCycle,
                ],
                'shipping' => [
                    'name' => $user->name ?? 'Guest User',
                    'address' => [
                        'line1' => '123 Market Street',
                        'city' => 'San Francisco',
                        'state' => 'CA',
                        'postal_code' => '94103',
                        'country' => 'US',
                    ],
                ],
                'setup_future_usage' => 'off_session',
            ]);
            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe createPaymentIntent error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Stripe error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Called after client confirms payment successfully.
     * We validate and then create subscription record in DB and save card details.
     */

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'plan_id' => 'required|integer',
            'billing_cycle' => 'required|in:monthly,yearly',
            'payment_method_id' => 'nullable|string',
        ]);

        $paymentIntentId = $request->input('payment_intent_id');
        $planId = $request->input('plan_id');
        $billingCycle = $request->input('billing_cycle');
        $paymentMethodId = $request->input('payment_method_id');
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        if (!str_starts_with($paymentIntentId, 'free_plan_')) {
            try {
                $pi = PaymentIntent::retrieve($paymentIntentId);
            } catch (\Exception $e) {
                Log::error('Stripe error retrieving PaymentIntent: ' . $e->getMessage(), ['payment_intent_id' => $paymentIntentId]);
                return response()->json(['error' => 'Unable to fetch PaymentIntent: ' . $e->getMessage()], 500);
            }

            if ($pi->status !== 'succeeded') {
                Log::warning('PaymentIntent status not succeeded:', ['status' => $pi->status, 'payment_intent_id' => $paymentIntentId]);
                return response()->json(['error' => 'Payment not successful. Status: ' . $pi->status], 400);
            }

            if ($paymentMethodId && $pi->payment_method) {
                try {
                    $paymentMethod = PaymentMethod::retrieve($pi->payment_method);
                    $cardBrand = strtolower($paymentMethod->card->brand);
                    $paymentTypeToSave = 'stripe';
                    if ($cardBrand === 'visa') $paymentTypeToSave = 'visa';
                    elseif ($cardBrand === 'mastercard') $paymentTypeToSave = 'master';

                    $existingCard = Card::where('user_id', $userId)->where('stripe_external_account_id', $paymentMethod->id)->first();
                    if (!$existingCard) {
                        Card::where('user_id', $userId)->update(['is_selected' => false]);
                        Card::create([
                            'user_id' => $userId,
                            'stripe_external_account_id' => $paymentMethod->id,
                            'brand' => $paymentMethod->card->brand,
                            'last4' => $paymentMethod->card->last4,
                            'exp_month' => $paymentMethod->card->exp_month,
                            'exp_year' => $paymentMethod->card->exp_year,
                            'card_holder_name' => $paymentMethod->billing_details->name ?? null,
                            'payment_type' => $paymentTypeToSave,
                            'is_selected' => true,
                        ]);
                    } else {
                        Card::where('user_id', $userId)->update(['is_selected' => false]);
                        $existingCard->update(['is_selected' => true]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to save or update card details for user ' . $userId . ': ' . $e->getMessage());
                }
            }
        }
        $plan = DB::table('plans')->where('id', $planId)->first();
        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }

        $validityDays = $billingCycle === 'yearly' ? ($plan->duration_days_y ?? 365) : ($plan->duration_days_m ?? 30);
        $startDate = Carbon::now();
        $endDate = (clone $startDate)->addDays($validityDays);

        try {
            $subscriptionId = DB::table('subscriptions')->insertGetId([
                'user_id' => $userId,
                'plan_id' => $planId,
                'validity_days' => $validityDays,
                'status' => 'active',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'transaction_id' => $paymentIntentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Auth::user()->update(['verification_status' => '1']);

        } catch (\Exception $e) {
            Log::error('DB error creating subscription: ' . $e->getMessage(), ['user_id' => $userId, 'plan_id' => $planId]);
            return response()->json(['error' => 'DB error: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'subscription_id' => $subscriptionId,
            'message' => 'Subscription created'
        ]);
    }
}
