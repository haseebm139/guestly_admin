    <x-default-layout>
        @section('title')
            Deposits
        @endsection
        @section('breadcrumbs')
            {{ Breadcrumbs::render('creative-management.supplies.index') }}
        @endsection

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Deposits</h3>
                </div>
                <div class="card-body ">

                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>ID</th>
                                <th>Booking</th>
                                <th>Client</th>
                                <th>Artist</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Transferred At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->id }}</td>
                                    <td>#{{ $deposit->client_booking_form_id }}</td>
                                    <td>{{ optional($deposit->booking?->client)->name }}</td>
                                    <td>{{ optional($deposit->booking?->artist)->name }}</td>
                                    <td>
                                        @php
                                            $amountCents = (int) $deposit->amount;
                                            $amount = number_format($amountCents / 100, 2);
                                        @endphp
                                        {{ strtoupper($deposit->currency) }} {{ $amount }}
                                    </td>
                                    <td>{{ ucfirst($deposit->status) }}</td>
                                    <td>{{ $deposit->transferred_at ? $deposit->transferred_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td>
                                        @if ($deposit->type === 'deposit' && $deposit->status === 'succeeded' && !$deposit->transferred_at)
                                            <form method="POST"
                                                action="{{ route('payments.deposits.transfer', $deposit) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-primary" type="submit">Transfer to
                                                    Artist</button>
                                            </form>
                                        @else
                                            <span class="badge badge-light">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No deposits found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $deposits->links() }}
            </div>
        </div>
        </div>


    </x-default-layout>
