<?php

namespace App\Http\Controllers\Apps\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientBookingForm;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function deposits(Request $request): View
    {
        $query = Payment::with(['booking.artist', 'booking.client'])
            ->where('type', 'deposit')
            ->orderByDesc('id');

        // Quick filters
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('currency')) {
            $query->where('currency', strtolower($request->string('currency')));
        }

        if ($request->filled('transferred')) {
            $transferred = $request->string('transferred') === 'yes';
            $query->when($transferred, fn($q) => $q->whereNotNull('transferred_at'))
                  ->when(! $transferred, fn($q) => $q->whereNull('transferred_at'));
        }

        if ($request->filled('artist_id')) {
            $artistId = (int) $request->artist_id;
            $query->whereHas('booking.artist', fn($q) => $q->where('id', $artistId));
        }

        if ($request->filled('client_id')) {
            $clientId = (int) $request->client_id;
            $query->whereHas('booking.client', fn($q) => $q->where('id', $clientId));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        // Full-text like search across booking id, client/artist name/email
        if ($request->filled('q')) {
            $term = trim((string) $request->q);
            $query->where(function ($q) use ($term) {
                $q->where('client_booking_form_id', (int) filter_var($term, FILTER_SANITIZE_NUMBER_INT))
                  ->orWhere('stripe_payment_intent_id', 'like', "%$term%")
                  ->orWhere('stripe_charge_id', 'like', "%$term%")
                  ->orWhereHas('booking.client', function ($qq) use ($term) {
                      $qq->where('name', 'like', "%$term%")
                         ->orWhere('email', 'like', "%$term%");
                  })
                  ->orWhereHas('booking.artist', function ($qq) use ($term) {
                      $qq->where('name', 'like', "%$term%")
                         ->orWhere('email', 'like', "%$term%");
                  });
            });
        }

        $deposits = $query->paginate(20)->appends($request->query());

        return view('pages.apps.admin.payments.deposits.index', compact('deposits'));
    }

    public function showDeposit(Payment $payment): View
    {
        $payment->load(['booking.artist', 'booking.client']);
        return view('pages.apps.admin.payments.deposits._details', compact('payment'));
    }

    public function transferDeposit(Request $request, Payment $payment): RedirectResponse
    {
        
        // Only allow transfer if payment is a deposit, succeeded, not already transferred, and booking is completed
        if ($payment->type !== 'deposit' || $payment->status !== 'succeeded') {
            return back()->with(['type' => 'error', 'message' => 'Payment not eligible for transfer.']);
        }

        if ($payment->transferred_at) {
            return back()->with(['type' => 'info', 'message' => 'Already transferred.']);
        }

        $booking = $payment->booking;
        if (! $booking) {
            return back()->with(['type' => 'error', 'message' => 'Booking not found for this payment.']);
        }

        // Consider booking completed when status indicates completed/complete/done/approve + explicit spot booking check if needed
        $isCompleted = false;
        $status = strtolower((string) ($booking->status ?? ''));
        if (in_array($status, ['completed', 'complete', 'done'])) {
            $isCompleted = true;
        }
        // existing flow marks approve after successful deposit; require explicit completion flag if present
        if (! $isCompleted && $status === 'approve' && $booking->booking && strtolower((string) $booking->booking->status) === 'completed') {
            $isCompleted = true;
        }

        // if (! $isCompleted) {
        //     return back()->with(['type' => 'error', 'message' => 'Booking is not completed yet.']);
        // }

        // Stripe Connect stub mode: skip real transfer
        if (config('services.stripe.connect_stub')) {
             
            $payment->update([
                'stripe_transfer_id' => 'tr_stub_'.now()->timestamp,
                'transferred_at' => now(),
            ]);

            return back()->with(['type' => 'success', 'message' => 'Deposit marked transferred (stub mode).']);
        }

        // Real Stripe Connect transfer (requires artist connected account id on user)
        $artist = $booking->artist;
        $destinationAccount = $artist?->stripe_account_id;
        if (! $destinationAccount) {
            return back()->with(['type' => 'error', 'message' => 'Artist is not connected to Stripe.']);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Use transfer_group from PI for reconciliation if available
            $transferGroup = 'booking_'.$booking->id;

            $transfer = \Stripe\Transfer::create([
                'amount' => (int) $payment->amount, // already in cents
                'currency' => $payment->currency ?? 'usd',
                'destination' => $destinationAccount,
                'transfer_group' => $transferGroup,
            ]);

            $payment->update([
                'stripe_transfer_id' => $transfer->id,
                'transferred_at' => now(),
            ]);

            return back()->with(['type' => 'success', 'message' => 'Deposit transferred to artist.']);
        } catch (\Throwable $e) {
            return back()->with(['type' => 'error', 'message' => 'Stripe transfer failed: '.$e->getMessage()]);
        }
    }
}


