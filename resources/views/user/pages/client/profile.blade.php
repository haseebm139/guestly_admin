<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="guestly_favicon.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary-green: #0b3d27;
            --bg-color: #e6f4f0;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
        }

        .font-arial-rounded {
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .custom-card {
            border-radius: 35px;
            border: none;
            max-width: 650px;
            width: 100%;
            background-color: white;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-pic {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            --bs-nav-tabs-border-width: 0;
            gap: 25px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem 0;
            border-bottom: 3px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-green);
            background-color: transparent;
            border-bottom: 3px solid var(--primary-green);
            font-weight: 600;
        }

        .tab-content {
            padding-top: 1.5rem;
        }

        .detail-list {
            list-style: none;
            padding: 0;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 0.75rem;
        }

        .detail-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .form-control-plaintext-custom {
            background-color: transparent;
            border: none;
            padding: 0;
            text-align: right;
            font-weight: 600;
            color: #212529;
            width: 100%;
        }

        .form-control-plaintext-custom:focus {
            outline: none;
            box-shadow: none;
            background-color: var(--light-gray);
            border-radius: 4px;
            padding: 0 5px;
        }

        .detail-value {
            color: #212529;
            font-weight: 600;
            text-align: right;
        }

        .detail-value.status-verified {
            color: var(--primary-green);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .detail-value.status-verified .bi {
            font-size: 1.2rem;
        }

        .detail-value.status-approved {
            color: #198754;
            font-weight: 600;
        }

        #pay-btn {
            background-color: var(--primary-green);
            color: white;
        }

        .chat-area {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .chat-bubble {
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 75%;
            font-size: 0.9rem;
        }

        .received {
            background-color: var(--light-gray);
            border-top-left-radius: 5px;
            align-self: flex-start;
        }

        .sent {
            background-color: var(--primary-green);
            color: white;
            border-top-right-radius: 5px;
            align-self: flex-end;
        }

        .chat-input-group {
            display: flex;
            align-items: center;
            background-color: var(--light-gray);
            border-radius: 25px;
            padding: 0.25rem 0.5rem;
        }

        .chat-input-group .form-control {
            background: none;
            border: none;
            box-shadow: none;
        }

        .chat-input-group .btn {
            background: none;
            border: none;
            color: var(--primary-green);
            font-size: 1.4rem;
        }

        .img-thumbnail-guestly {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .appointment-summary {
            background: #f9fbfb;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 16px
        }

        .appointment-summary .badge-soft {
            background: #e7f5ef;
            color: var(--primary-green);
            border-radius: 999px;
            padding: .45rem .8rem;
            font-weight: 600
        }

        .appointment-summary .chip {
            background: var(--light-gray);
            border-radius: 999px;
            padding: .5rem .8rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-weight: 600
        }

        .appointment-summary .chip .bi {
            color: var(--primary-green)
        }

        .appointment-divider {
            height: 1px;
            background: #e9ecef;
            margin: 16px 0
        }

        .detail-card {
            border: 1px solid #e9ecef;
            border-radius: 16px;
            background: #fff
        }

        .detail-card .detail-item {
            border: 0;
            border-bottom: 1px solid #f0f2f4;
            margin: 0;
            border-radius: 0;
            padding: 1rem 1.25rem
        }

        .detail-card .detail-item:last-child {
            border-bottom: 0
        }

        .badge-status {
            border-radius: 999px;
            padding: .45rem .8rem;
            font-weight: 600
        }

        .badge-status.approved {
            background: #e7f8ef;
            color: #198754
        }

        .badge-status.pending {
            background: #fff3cd;
            color: #b58100
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    @php
        $paymentSucceeded = isset($booking) && optional($booking->payment)->status === 'succeeded';
        $depositAmount = (float) ($booking->deposit ?? 0);
        $currency = 'USD';
        $currencySymbol = '$';
        $depositFormatted = number_format($depositAmount, 2);
    @endphp

    <div class="card custom-card shadow-lg">
        <div class="card-body p-4 p-md-5">

            <div class="profile-header mb-4">
                <img src="{{ asset('avatar/default.png') }}" alt="Profile Picture" class="profile-pic rounded-circle">
                <div>
                    <h5 class="mb-0 fw-bold">{{ $booking->client->name ?? '' }} {{ $booking->client->last_name ?? '' }}
                    </h5>
                    <small class="text-muted">{{ $booking->client->email ?? '' }}</small>
                </div>
            </div>

            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $paymentSucceeded ? 'active' : '' }}" id="appointment-tab"
                        data-bs-toggle="tab" data-bs-target="#appointment-tab-pane" type="button" role="tab"
                        aria-controls="appointment-tab-pane" aria-selected="true">Appointment</button>
                </li>
                @if (!$paymentSucceeded)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$paymentSucceeded ? 'active' : '' }}" id="payment-tab"
                            data-bs-toggle="tab" data-bs-target="#payment-tab-pane" type="button" role="tab"
                            aria-controls="payment-tab-pane" aria-selected="true">Payment</button>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages-tab-pane"
                        type="button" role="tab" aria-controls="messages-tab-pane"
                        aria-selected="false">Messages</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade {{ $paymentSucceeded ? 'show active' : '' }}" id="appointment-tab-pane"
                    role="tabpanel" aria-labelledby="appointment-tab" tabindex="0">
                    @php
                        $bookingDate = isset($booking->booking_date)
                            ? \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')
                            : '';
                        $bookingTime = isset($booking->booking_time)
                            ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i')
                            : '';
                    @endphp
                    @if (isset($booking))
                        <div class="appointment-summary mb-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge-soft d-inline-flex align-items-center">
                                        <i class="bi bi-person-badge me-2"></i>
                                        Artist
                                        {{ ($booking->artist->phone_verified ?? 0) == 1 || ($booking->artist->email_verified ?? 0) == 1 ? 'Verified' : 'Unverified' }}
                                    </span>
                                    <span
                                        class="badge-status {{ ($booking->status ?? 'pending') === 'approved' || ($booking->status ?? 'pending') === 'approve' ? 'approved' : 'pending' }}">
                                        <i
                                            class="bi {{ ($booking->status ?? 'pending') === 'approved' || ($booking->status ?? 'pending') === 'approve' ? 'bi-check2-circle' : 'bi-hourglass-split' }} me-1"></i>
                                        {{ ucfirst($booking->status ?? 'pending') }}
                                    </span>
                                    @if ($paymentSucceeded)
                                        <span class="badge-status approved">
                                            <i class="bi bi-credit-card-2-front me-1"></i> Payment Confirmed
                                        </span>
                                    @else
                                        <span class="badge-soft d-inline-flex align-items-center">
                                            <i class="bi bi-cash-coin me-2"></i>
                                            Deposit due: {{ $currencySymbol }}{{ $depositFormatted }}
                                            {{ $currency }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-end small text-muted">
                                    Booking #{{ $booking->id }}
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <div class="chip"><i class="bi bi-calendar-event"></i>{{ $bookingDate ?: '—' }}</div>
                                <div class="chip"><i class="bi bi-clock"></i>{{ $bookingTime ?: '—' }}</div>
                                @if (!empty($booking->artist?->name))
                                    <div class="chip"><i class="bi bi-person"></i>{{ $booking->artist->name }}</div>
                                @endif
                                @if (!empty($booking->studio?->name))
                                    <div class="chip"><i class="bi bi-geo-alt"></i>{{ $booking->studio->name }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="detail-card">
                            <ul class="detail-list mb-0">
                                <li class="detail-item">
                                    <span class="detail-label">Artist Identity</span>
                                    @if (($booking->artist->phone_verified ?? 0) == 1 || ($booking->artist->email_verified ?? 0) == 1)
                                        <span class="detail-value status-verified"><i
                                                class="bi bi-patch-check-fill"></i> Verified</span>
                                    @else
                                        <span class="detail-value text-muted">Unverified</span>
                                    @endif
                                </li>
                                <li class="detail-item">
                                    <span class="detail-label">Status</span>
                                    <span
                                        class="detail-value {{ ($booking->status ?? '') === 'approved' || ($booking->status ?? '') === 'approve' ? 'status-approved' : '' }}">
                                        {{ ucfirst($booking->status ?? 'Pending') }}
                                    </span>
                                </li>
                                @if ($paymentSucceeded)
                                    <li class="detail-item">
                                        <span class="detail-label">Payment</span>
                                        <span class="detail-value status-approved">Confirmed</span>
                                    </li>
                                @endif
                                <li class="detail-item">
                                    <div class="row w-100 g-0">
                                        <div class="col-6 pe-3">
                                            <div class="detail-label">Date</div>
                                            <input type="text" disabled
                                                class="form-control-plaintext-custom text-start"
                                                value="{{ $bookingDate }}">
                                        </div>
                                        <div class="col-6 ps-3 border-start">
                                            <div class="detail-label">Time</div>
                                            <input type="text" disabled
                                                class="form-control-plaintext-custom text-start"
                                                value="{{ $bookingTime }}">
                                        </div>
                                    </div>
                                </li>

                                @foreach ($booking->responses as $response)
                                    @php
                                        $field = $response->field ?? '';
                                        $value = $response->value ?? '';
                                    @endphp
                                    {!! renderTableField($field, $value) !!}
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="custom-card">
                            <div
                                class="card-body p-4 text-center d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset('assets/web/client_pending.png') }}"
                                    class="img-thumbnail-guestly mb-3" alt="Thumbs Up">
                                <h2 class="mb-2">Appointment Pending</h2>
                                <p class="mb-0">Once the artist schedules you, you’ll see the appointment details</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade show active" id="payment-tab-pane" role="tabpanel"
                    aria-labelledby="payment-tab" tabindex="0">
                    @if (!$paymentSucceeded)
                        <div class="tab-pane fade show active" id="payment-tab-pane" role="tabpanel"
                            aria-labelledby="payment-tab" tabindex="0">
                            @if (!$paymentSucceeded)
                                <div class="alert alert-info d-flex align-items-center justify-content-between"
                                    role="alert">
                                    <div>
                                        <strong>Deposit due:</strong> {{ $currencySymbol }}{{ $depositFormatted }}
                                        {{ $currency }}
                                    </div>
                                    <span class="text-muted small">This amount will be charged now.</span>
                                </div>
                            @endif
                            <form id="payment-form" class="mt-2">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Cardholder Name</label>
                                        <input id="cardholder-name" type="text" class="form-control"
                                            placeholder="Full name" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Address line 1</label>
                                        <input id="addr-line1" type="text" class="form-control"
                                            placeholder="House/Flat, Street" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Address line 2 (optional)</label>
                                        <input id="addr-line2" type="text" class="form-control"
                                            placeholder="Area, Landmark (optional)">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">City</label>
                                        <input id="addr-city" type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">State/Region</label>
                                        <input id="addr-state" type="text" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Postal Code</label>
                                        <input id="addr-postal" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Country (2-letter code, e.g. US, GB,
                                            IN)</label>
                                        <input id="addr-country" type="text" class="form-control"
                                            placeholder="US" maxlength="2" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold d-flex align-items-center gap-2">
                                            Select a payment method
                                            <span class="text-muted small">(Cards, Link, Wallets, etc.)</span>
                                        </label>
                                        <div id="payment-element" class="form-control p-2"></div>
                                        <small class="text-muted">We support major cards and wallet methods where
                                            available.</small>
                                    </div>

                                    <div class="col-12">
                                        <div id="payment-message" class="fw-bold small"></div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3 mt-3">
                                    <button id="pay-btn" type="submit" class="btn btn-primary mt-3">
                                        Pay Deposit ({{ $currencySymbol }}{{ $depositFormatted }})
                                    </button>
                                    <div id="spinner" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status"></div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>


                <div class="tab-pane fade" id="messages-tab-pane" role="tabpanel" aria-labelledby="messages-tab"
                    tabindex="0" data-client-id="{{ $booking->client_id }}"
                    data-artist-id="{{ $booking->artist_id }}"
                    @if (isset($chatId)) data-chat-id="{{ $chatId }}" @endif
                    data-user-name="{{ auth()->user()->name ?? 'Guest' }}">
                    <div class="chat-area">
                        <div class="chat-bubble received">Hey! I just sent in a booking request for Sept 14th at The
                            Inwell Studio. Let me know if you're available.</div>
                        <div class="chat-bubble sent">Hey Lucas, thanks for booking! I just saw your request - Sept
                            14th works perfectly.</div>
                        <div class="chat-bubble received">Sure thing - I'm thinking of a compass design...</div>
                        <div class="chat-bubble sent">Nice! That's a solid concept.</div>
                    </div>
                    <div class="chat-input-area mt-3">
                        <div class="chat-input-group">
                            <button class="btn attachment-btn" type="button" title="Attach file"><i
                                    class="bi bi-paperclip"></i></button>
                            <input type="text" class="form-control" placeholder="Type your message"
                                aria-label="Type your message">
                            <button class="btn send-btn" type="button" title="Send message"><i
                                    class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const stripe = Stripe("{{ config('services.stripe.key') }}");

            const form = document.getElementById("payment-form");
            if (!form) return;

            const payBtn = document.getElementById("pay-btn");
            const messageEl = document.getElementById("payment-message");
            const spinner = document.getElementById("spinner");

            function setMessage(msg, type = "danger") {
                messageEl.classList.remove("text-danger", "text-success");
                messageEl.classList.add(type === "success" ? "text-success" : "text-danger");
                messageEl.textContent = msg || "";
            }

            function setLoading(loading) {
                payBtn.disabled = loading;
                spinner?.classList.toggle('d-none', !loading);
                payBtn.textContent = loading ? "Processing..." : "Pay Deposit";
            }

            function getNameAddress() {
                return {
                    name: document.getElementById("cardholder-name").value.trim(),
                    address: {
                        line1: document.getElementById("addr-line1").value.trim(),
                        line2: document.getElementById("addr-line2").value.trim(),
                        city: document.getElementById("addr-city").value.trim(),
                        state: document.getElementById("addr-state").value.trim(),
                        postal_code: document.getElementById("addr-postal").value.trim(),
                        country: document.getElementById("addr-country").value.trim().toUpperCase(),
                    },
                };
            }

            let clientSecret;
            let elements;
            let paymentElement;

            // Create PI on load so the Payment Element renders immediately
            try {
                const createRes = await fetch(
                    "{{ route('client.booking.createPaymentIntent', $booking->id) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({}), // no name/address needed to mount element
                    });
                const createJson = await createRes.json();
                if (!createRes.ok || createJson.error) throw new Error(createJson.error ||
                    "Failed to create PaymentIntent");
                clientSecret = createJson.client_secret;

                const appearance = {
                    theme: "stripe",
                    variables: {
                        colorPrimary: "#0b3d27",
                        colorBackground: "#ffffff",
                        colorText: "#212529",
                        borderRadius: "12px"
                    },
                    rules: {
                        ".Label": {
                            fontWeight: "600"
                        },
                        ".Tab, .Input, .Block": {
                            borderRadius: "12px"
                        }
                    },
                };
                elements = stripe.elements({
                    clientSecret,
                    appearance
                });
                paymentElement = elements.create("payment", {
                    layout: "tabs"
                });
                paymentElement.mount("#payment-element");
            } catch (e) {
                setMessage(e.message || "Unable to initialize payment.");
                return;
            }

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                setMessage("");
                setLoading(true);

                try {
                    const {
                        name,
                        address
                    } = getNameAddress();
                    if (!name || !address.line1 || !address.city || !address.country) {
                        throw new Error(
                            "Please fill name, address line 1, city, and country (2-letter).");
                    }

                    // IMPORTANT: billing_details must be nested under payment_method_data
                    const {
                        error,
                        paymentIntent
                    } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            payment_method_data: {
                                billing_details: {
                                    name,
                                    address
                                }
                            },
                            shipping: {
                                name,
                                address
                            },
                            // receipt_email: "{{ $booking->client->email ?? '' }}",
                        },
                        redirect: "if_required",
                    });

                    if (error) throw error;
                    if (!paymentIntent || paymentIntent.status !== "succeeded") {
                        throw new Error(
                            `Payment not completed: ${paymentIntent?.status || "unknown"}`);
                    }

                    const finalizeRes = await fetch(
                        "{{ route('client.booking.payment', $booking->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                payment_intent_id: paymentIntent.id
                            }),
                        });
                    const finalizeJson = await finalizeRes.json();
                    if (!finalizeRes.ok || finalizeJson.error) throw new Error(finalizeJson.error ||
                        "Failed to finalize payment");

                    setMessage("Deposit Paid ✅", "success");
                    setTimeout(() => location.reload(), 900);
                } catch (err) {
                    setMessage(err.message || "Payment failed");
                } finally {
                    setLoading(false);
                }
            });
        });
    </script>
</body>

</html>
