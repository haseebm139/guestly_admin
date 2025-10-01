<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientBookingForm;
use App\Models\ClientBookingFormResponse;
use App\Models\Payment;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Stripe;

class ClientController extends Controller
{
    public function index($artist_id, $artist_name, $shared_code, $booking_id = null)
    {

        $artist = User::where('user_type', 'artist')->where('name', $artist_name)->where('id', $artist_id)->first();
        if (empty($artist)) {
            dd('artist not found');
        }

        $data = ClientBookingForm::where('shared_code', $shared_code)
            ->where('artist_id', $artist_id)
            ->with(['customForm.fields', 'studio'])
            ->first();

        if (empty($data)) {
            dd('client booking form not found');
        }

        return view('user.pages.client.custom_form', compact('data'));
    }

    public function submitForm(Request $request, $shared_code)
    {

        // Find booking using shared_code
        $booking = ClientBookingForm::where('shared_code', $request->shared_code)->firstOrFail();
        $userEmail = '';
        $name = '';
        $lastName = '';
        $password = Hash::make('haseeb@123');
        // Update booking status
        $booking->status = 'pending';
        $booking->save();
        $user = null;
        foreach ($request->except(['_token', 'shared_code', 'studio_name', 'booking_date', 'booking_time']) as $key => $value) {
            // Split the field name and field ID
            [$fieldName, $fieldId] = explode('|', $key);
            if ($fieldName == 'email') {
                $userEmail = $value;
            }
            if ($fieldName == 'full_name' || $fieldName == 'name' || $fieldName == 'first_name') {
                $name = $value;
            }

            if ($fieldName == 'last_name') {
                $lastName = $value;
            }
            // If multi-select, store as JSON
            if (is_array($value)) {
                $value = json_encode($value);
            }

            // Save response
            ClientBookingFormResponse::updateOrCreate(
                [
                    'client_booking_form_id' => $booking->id,
                    'custom_form_field_id' => $fieldId,
                ],
                ['value' => $value]
            );

            if ($userEmail) {

                $user = User::where('email', $userEmail)->first();

                if (! $user) {
                    // Create new user if not exists
                    $user = User::create([
                        'name' => $name ?? '',
                        'last_name' => $lastName ?? '',
                        'email' => $userEmail ?? '',
                        'user_type' => 'user',
                        'role_id' => 'user',
                        'password' => $password,
                        'profile_link' => Str::uuid(),
                    ]);
                }

                // ✅ Assign role "user" if not already assigned
                if (! $user->hasRole('user')) {
                    $user->assignRole('user');
                }
                if ($user->profile_link == null) {
                    $user->update([
                        'profile_link' => Str::uuid(),
                    ]);
                }
                $booking->update([
                    'client_id' => $user->id,
                ]);
            }

        }
        // dd($request->shared_code, $user->profile_link);
        $profileUrl = route('client.profile', ['shared_code' => $request->shared_code, 'token' => $user->profile_link]);
         
        sendBookingMail($user->name, $user->last_name, $user->email, $profileUrl);

        return redirect()->route('client.done');
    }

    public function thankyouPage(Request $request)
    {
        return view('user.pages.client.thank_you');

    }

    public function profile($shared_code, $token)
    {
        
        $user = User::where('profile_link', $token)->first();
        dd($user);
        // $user = User::first();
        if (empty($user)) {
            dd('user not found');
        }
        $booking = ClientBookingForm::with([
            'studio',
            'artist',
            'client',
            'booking',
            'payment',
            'responses.field', // load fields
        ])->whereIn('status', ['approve'])
        ->where('shared_code', $shared_code)
        ->first();
        //  dd($booking);
        if (empty($booking)) {
            dd('user not found');
        }

        // Fetch bookings if needed
        // dd($booking);
        // $bookings = $user->bookings ?? [];
        $bookings = $booking ?? [];
        $messages = [];

        // dd($booking);
        return view('user.pages.client.profile', compact('user', 'bookings', 'booking', 'messages'));
    }

    public function createPaymentIntent(Request $request, $id)
    {
        $booking = ClientBookingForm::findOrFail($id);
        if (! $booking->deposit) {
            return response()->json(['error' => 'No deposit set for this booking'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $amountInCents = (int) round($booking->deposit * 100);
        $clientEmail = $booking->client->email ?? '';

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'description' => "Tattoo service deposit - Booking #{$booking->id}",
            'receipt_email' => $clientEmail ?: null,
            'transfer_group' => 'booking_'.$booking->id,
            'automatic_payment_methods' => ['enabled' => true], // Payment Element
            'metadata' => [
                'booking_id' => (string) $booking->id,
                'customer_email' => $clientEmail,
                'type' => 'deposit',
            ],
        ]);

        return response()->json(['client_secret' => $paymentIntent->client_secret]);
    }

    public function payDeposit(Request $request, $id)
    {
        $request->validate(['payment_intent_id' => 'required|string']);
        $booking = ClientBookingForm::findOrFail($id);

        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve PI with latest_charge expanded to easily capture the Charge ID
        $pi = \Stripe\PaymentIntent::retrieve([
            'id' => $request->payment_intent_id,
            'expand' => ['latest_charge'],
        ]);

        if (($pi->metadata->booking_id ?? null) !== (string) $booking->id) {
            return response()->json(['error' => 'Payment does not match booking'], 400);
        }

        if ($pi->status !== 'succeeded') {
            return response()->json(['error' => 'Payment not completed', 'status' => $pi->status], 400);
        }

        $chargeId = $pi->latest_charge?->id;

        // Persist the deposit payment
        $payment = Payment::create([
            'client_booking_form_id' => $booking->id,
            'client_id' => $booking->client_id,
            'artist_id' => $booking->artist_id,
            'amount' => $pi->amount_received, // cents
            'currency' => $pi->currency,
            'type' => 'deposit',
            'status' => 'succeeded',
            'stripe_payment_intent_id' => $pi->id,
            'stripe_charge_id' => $chargeId,
            'billing_details' => [
                'name' => $pi->charges->data[0]->billing_details->name ?? null,
                'email' => $pi->charges->data[0]->billing_details->email ?? null,
                'address' => $pi->charges->data[0]->billing_details->address ?? null,
            ],
            'shipping' => $pi->shipping ? [
                'name' => $pi->shipping->name,
                'address' => $pi->shipping->address,
            ] : null,
        ]);

        // Mark booking approved
        $booking->update(['status' => 'approve']);

        return response()->json([
            'success' => true,
            'message' => 'Deposit saved',
            'booking' => $booking,
            'payment_id' => $payment->id,
        ]);
    }
}
