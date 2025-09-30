<div class="table-responsive">
    <table class="table table-sm table-borderless">
        <tr>
            <th class="w-200px">Deposit ID</th>
            <td>{{ $payment->id }}</td>
        </tr>
        <tr>
            <th>Booking ID</th>
            <td>#{{ $payment->client_booking_form_id }}</td>
        </tr>
        <tr>
            <th>Client</th>
            <td>{{ optional($payment->booking?->client)->name }} ({{ optional($payment->booking?->client)->email }})
            </td>
        </tr>
        <tr>
            <th>Artist</th>
            <td>{{ optional($payment->booking?->artist)->name }} ({{ optional($payment->booking?->artist)->email }})
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>
                @php
                    $amountCents = (int) $payment->amount;
                    $amount = number_format($amountCents / 100, 2);
                @endphp
                {{ strtoupper($payment->currency) }} {{ $amount }}
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($payment->status) }}</td>
        </tr>
        <tr>
            <th>Payment Intent</th>
            <td>{{ $payment->stripe_payment_intent_id }}</td>
        </tr>
        <tr>
            <th>Charge ID</th>
            <td>{{ $payment->stripe_charge_id }}</td>
        </tr>
        <tr>
            <th>Transfer ID</th>
            <td>{{ $payment->stripe_transfer_id ?: '-' }}</td>
        </tr>
        <tr>
            <th>Transferred At</th>
            <td>{{ $payment->transferred_at ? $payment->transferred_at->format('Y-m-d H:i') : '-' }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        <tr>
            <th>Billing Details</th>
            <td>
                <pre class="mb-0">{{ json_encode($payment->billing_details, JSON_PRETTY_PRINT) }}</pre>
            </td>
        </tr>
        @if ($payment->shipping)
            <tr>
                <th>Shipping</th>
                <td>
                    <pre class="mb-0">{{ json_encode($payment->shipping, JSON_PRETTY_PRINT) }}</pre>
                </td>
            </tr>
        @endif
    </table>
</div>
