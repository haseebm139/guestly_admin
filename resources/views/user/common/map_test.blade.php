<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly - Client View</title>
    <link rel="icon" type="image/png" href="guestly_favicon.png" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for Checkmark and Send -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
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

        /* --- MODIFICATION: Centered Tabs --- */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            --bs-nav-tabs-border-width: 0;
            gap: 25px; /* Adds space between tabs */
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem 0; /* Adjusted padding */
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
            padding: 0.75rem 1rem; /* Adjusted padding */
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 0.75rem;
        }
        .detail-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* --- MODIFICATION: Plaintext, Typable Input Styling --- */
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
            background-color: var(--light-gray); /* Subtle focus indicator */
            border-radius: 4px;
            padding: 0 5px; /* Add slight padding on focus */
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
        
        /* --- MODIFICATION: Chat Input with Attachment Button --- */
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
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

<div class="card custom-card shadow-lg">
    <div class="card-body p-4 p-md-5">

        <div class="profile-header mb-4">
            <img src="https://i.pravatar.cc/150?u=lucas" alt="Profile Picture" class="profile-pic rounded-circle">
            <div>
                <h5 class="mb-0 fw-bold">Lucas Raymond</h5>
                <small class="text-muted">chris@gmail.com</small>
            </div>
        </div>

        <!-- MODIFICATION: justify-content-center added for centered tabs -->
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="appointment-tab" data-bs-toggle="tab" data-bs-target="#appointment-tab-pane" type="button" role="tab" aria-controls="appointment-tab-pane" aria-selected="true">Appointment</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages-tab-pane" type="button" role="tab" aria-controls="messages-tab-pane" aria-selected="false">Messages</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <!-- APPOINTMENT Tab Pane -->
            <div class="tab-pane fade show active" id="appointment-tab-pane" role="tabpanel" aria-labelledby="appointment-tab" tabindex="0">
                
                <ul class="detail-list">
                    <li class="detail-item">
                        <span class="detail-label">Artist Identity</span>
                        <span class="detail-value status-verified"><i class="bi bi-patch-check-fill"></i> Verified</span>
                    </li>
                    <li class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value status-approved">Approved</span>
                    </li>
                    <li class="detail-item">
                        <div class="row w-100 g-0">
                            <div class="col-6 pe-3">
                                <div class="detail-label">Date</div>
                                <input type="text" class="form-control-plaintext-custom text-start" value="March 2023">
                            </div>
                            <div class="col-6 ps-3 border-start">
                                <div class="detail-label">Time</div>
                                <input type="text" class="form-control-plaintext-custom text-start" value="8:00 PM">
                            </div>
                        </div>
                    </li>
                    <li class="detail-item">
                        <span class="detail-label">Legal Name</span>
                        <input type="text" class="form-control-plaintext-custom" value="Chris Johnson">
                    </li>
                    <li class="detail-item">
                        <span class="detail-label">Email Address</span>
                        <input type="email" class="form-control-plaintext-custom" value="chris@gmail.com">
                    </li>
                    <li class="detail-item">
                        <span class="detail-label">Country/Region</span>
                        <input type="text" class="form-control-plaintext-custom" value="United States">
                    </li>
                    <li class="detail-item">
                        <span class="detail-label">Phone number</span>
                        <input type="tel" class="form-control-plaintext-custom" value="+1 123 456 789">
                    </li>
                </ul>
            </div>

            <!-- MESSAGES Tab Pane -->
            <div class="tab-pane fade" id="messages-tab-pane" role="tabpanel" aria-labelledby="messages-tab" tabindex="0">
                <div class="chat-area">
                     <div class="chat-bubble received">Hey! I just sent in a booking request for Sept 14th at The Inwell Studio. Let me know if you're available.</div>
                     <div class="chat-bubble sent">Hey Lucas, thanks for booking! I just saw your request - Sept 14th works perfectly.</div>
                     <div class="chat-bubble received">Sure thing - I'm thinking of a compass design with mountain lines inside the circle. I want it on my inner forearm, black & grey, kind of minimal and clean.</div>
                     <div class="chat-bubble sent">Nice! That's a solid concept.</div>
                </div>
                <div class="chat-input-area mt-3">
                     <!-- MODIFICATION: New input group structure with attachment button -->
                     <div class="chat-input-group">
                        <button class="btn attachment-btn" type="button" title="Attach file">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="text" class="form-control" placeholder="Type your message" aria-label="Type your message">
                        <button class="btn send-btn" type="button" title="Send message">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>