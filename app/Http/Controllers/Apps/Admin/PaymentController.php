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

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $deposits = $query->paginate(20);

        return view('pages.apps.admin.payments.deposits.index', compact('deposits'));
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
                // Optionally link to the charge that funded the transfer
                // 'source_transaction' => $payment->stripe_charge_id,
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


