<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('guestly_favicon.png') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary-green: #0b3d27;
            --bg-color: #e6f4f0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            overflow-y: hidden
        }

        .font-arial-rounded {
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .custom-card {
            border-radius: 35px;
            border: none;
            max-width: 650px;
            width: 100%;
        }

        .btn-primary-green {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary-green:hover {
            background-color: #062a1a;
            border-color: #062a1a;
            color: white;
        }

        .form-scroll-area {
            max-height: 45vh;
            overflow-y: auto;
            padding-right: 15px;
        }

        .form-control:focus,
        .form-select:focus,
        .select2-container--bootstrap-5 .select2-selection {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 0.25rem rgba(11, 61, 39, 0.25) !important;
        }

        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: .625rem;
        }

        .form-label-select2 {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>


<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="container py-4">

        <!-- Status Header -->
        <div class="text-center mb-4">
            @if ($booking->status === 'pending')
                <h4 class="text-warning"><i class="bi bi-hourglass-split"></i> Appointment Pending</h4>
                <p class="text-muted">Waiting for artist/studio to approve your request</p>
            @elseif ($booking->status === 'approve')
                <h4 class="text-success"><i class="bi bi-check-circle"></i> Appointment Approved</h4>
                <p class="text-muted">Your booking is confirmed</p>
            @elseif ($booking->status === 'decline')
                <h4 class="text-danger"><i class="bi bi-x-circle"></i> Appointment Declined</h4>
                <p class="text-muted">This booking has been declined</p>
            @endif
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="bookingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="appointment-tab" data-bs-toggle="tab" data-bs-target="#appointment"
                    type="button" role="tab">
                    <i class="bi bi-calendar-check"></i> Appointment
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages"
                    type="button" role="tab">
                    <i class="bi bi-chat-dots"></i> Messages
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="bookingTabsContent">

            <!-- Appointment Tab -->
            <div class="tab-pane fade show active" id="appointment" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Booking Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Studio</label>
                            <input type="text" class="form-control" value="{{ $booking->studio->name ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Booking Date</label>
                            <input type="date" class="form-control" value="{{ $booking->booking_date }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Booking Time</label>
                            <input type="time" class="form-control" value="{{ $booking->booking_time }}" readonly>
                        </div>

                        <hr>

                        <form method="POST" action="{{ route('client.booking.submit', $booking->shared_code) }}">
                            @csrf
                            @foreach ($booking->customForm->fields as $field)
                                <div class="mb-3">
                                    <label class="form-label">{{ $field->label }}</label>
                                    {!! renderField($field, $booking->responses->firstWhere('field_id', $field->id)->value ?? null) !!}
                                </div>
                            @endforeach

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Messages Tab -->
            <div class="tab-pane fade" id="messages" role="tabpanel">
                <div class="card shadow-sm h-100 d-flex flex-column">
                    <div class="card-header">
                        <h5 class="mb-0">Messages</h5>
                    </div>
                    <div class="card-body flex-grow-1 overflow-auto" style="max-height: 400px;">
                        @foreach ($messages as $msg)
                            <div class="mb-2">
                                <strong>{{ $msg->sender->name }}:</strong>
                                <p class="mb-0">{{ $msg->message }}</p>
                                <small class="text-muted">{{ $msg->created_at->format('d M, h:i A') }}</small>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <form method="POST" 
                        {{-- action="{{ route('client.booking.message', $booking->id) }}"--}} 
                        > 
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control"
                                    placeholder="Type a message...">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery, Bootstrap & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
            });
        });
    </script>

</body>

</html>
