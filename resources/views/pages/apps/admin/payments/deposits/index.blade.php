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
                    <div class="card-toolbar">
                        <form method="GET" action="" class="d-flex gap-3">
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control form-control-sm" placeholder="Search (name/email/ids)">
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="form-control form-control-sm">
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="form-control form-control-sm">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Status</option>
                                <option value="succeeded" {{ request('status') === 'succeeded' ? 'selected' : '' }}>
                                    Succeeded
                                </option>
                                <option value="requires_action"
                                    {{ request('status') === 'requires_action' ? 'selected' : '' }}>Requires Action
                                </option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed
                                </option>
                            </select>
                            <select name="transferred" class="form-select form-select-sm">
                                <option value="">Transferred?</option>
                                <option value="yes" {{ request('transferred') === 'yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="no" {{ request('transferred') === 'no' ? 'selected' : '' }}>No
                                </option>
                            </select>
                            <select name="currency" class="form-select form-select-sm">
                                <option value="">Currency</option>
                                <option value="usd" {{ request('currency') === 'usd' ? 'selected' : '' }}>USD
                                </option>
                            </select>
                            <button class="btn btn-sm btn-light-primary" type="submit">Filter</button>
                            <a href="{{ route('payments.deposits.index') }}" class="btn btn-sm btn-light">Reset</a>
                        </form>
                    </div>
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
                                    <td>
                                        <a href="javascript:void(0)" class="link-primary js-view-deposit"
                                            data-id="{{ $deposit->id }}">#{{ $deposit->client_booking_form_id }}</a>
                                    </td>
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
                <!-- Deposit details modal -->
                <div class="modal fade" id="depositDetailsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Deposit Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="deposit-details-content" class="py-2">
                                    Loading...
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {{ $deposits->links() }}
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const detailsModal = new bootstrap.Modal(document.getElementById('depositDetailsModal'));
                    document.querySelectorAll('.js-view-deposit').forEach(function(el) {
                        el.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const container = document.getElementById('deposit-details-content');
                            container.innerHTML = 'Loading...';
                            fetch(`{{ url('/admin/payments/deposits') }}/${id}`)
                                .then(r => r.text())
                                .then(html => {
                                    container.innerHTML = html;
                                    detailsModal.show();
                                })
                                .catch(() => {
                                    container.innerHTML = 'Failed to load details.';
                                    detailsModal.show();
                                });
                        });
                    });
                });
            </script>
        @endpush
        </div>


    </x-default-layout>
