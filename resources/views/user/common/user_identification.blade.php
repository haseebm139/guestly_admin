    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Guestly</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>

    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet" />

    <style>
        :root {
            --bg-color: #e6f4f0;
            --primary-green: #0b3d27;
            --text-primary: #0b3d27;
            --text-secondary: #5d7a70;
            --border-active: #0b3d27;
            --border-inactive: #e0e7e5;
            --card-bg: #ffffff;
            --card-bg-active: #eaf5ef;
            --secondary-green-btn: #8ba89d;
        }

        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .stepper-container {
            width: 100%;
            max-width: 720px;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        #step2-doc .form-step {
            display: none;
        }

        #step2-doc .form-step.active {
            display: block;
        }

        /* --- Page 1 Styles --- */
        .verification-container {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: auto;
        }

        .verification-container h2 {
            font-size: 30px;
            color: #014122;
            font-weight: 500;
            margin-top: 0;
            margin-bottom: 10px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .verification-container p {
            font-size: 13px;
            color: #333333;
            margin-bottom: 21px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .verification-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 2px solid var(--border-inactive);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }

        .verification-option:hover {
            border-color: #b8ccc5;
        }

        .verification-option.active {
            border-color: #5E8082;
            background-color: var(--card-bg-active);
            box-shadow: 0 4px 15px rgba(11, 61, 39, 0.1);
        }

        .verification-option .icon {
            width: auto;
            height: 80px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .verification-option .tick {
            margin-left: auto;
            display: flex;
            visibility: hidden;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }

        .verification-option .tick svg {
            width: 36px;
            height: 36px;
        }

        .verification-option.active .tick {
            visibility: visible;
        }

        .option-text {
            flex-grow: 1;
        }

        .option-text strong {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #333333;
        }

        .verification-option.active .option-text strong {
            color: #014122;
        }

        .option-text span {
            font-size: 14px;
            color: #333333;
            font-family: 'Actor', sans-serif;
        }

        /* --- Common Button Styles --- */
        .next-btn,
        .confirm-btn,
        .success-modal-btn,
        .nav-btn {
            background-color: var(--primary-green);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 20px;
            width: 100%;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 30px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            transition: background-color 0.3s ease;
        }

        /* --- Page 2 (Doc) Styles --- */
        .verification-flow-container {
            background: var(--card-bg);
            border-radius: 24px;
            width: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 40px;
            transition: max-width 0.3s ease;
        }

        .verification-flow-container.narrow {
            max-width: 480px;
            margin: auto;
        }

        .form-step h2 {
            font-size: 29px;
            font-weight: 500;
            margin: 0 0 10px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            color: #014122;
        }

        .form-step p {
            font-size: 13px;
            color: #333333;
            margin-bottom: 30px;
            font-family: 'Actor', sans-serif;
        }

        .progress-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .progress-step {
            width: 78px;
            height: 2px;
            background-color: #5E8082;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .progress-step.active {
            background-color: var(--primary-green);
            height: 5px;
            margin-top: -3px;
        }

        .icon-container {
            width: 48px;
            height: 48px;
            background-color: #f0f2f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .verification-option .icon-page2 {
            width: 52px;
            height: auto;
        }

        .upload-area {
            position: relative;
            border-radius: 16px;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f7faf9;
            border: 2px dashed var(--border-inactive);
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .upload-area:hover {
            border-color: var(--secondary-green-btn);
        }

        .upload-area .id-frame-overlay {
            max-width: 250px;
            width: 80%;
            height: auto;
            opacity: 0.5;
        }

        input[type="file"] {
            display: none;
        }

        .upload-area.has-image {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border: 2px solid var(--border-active);
        }

        .upload-area.has-image .upload-content {
            display: none;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .nav-btn {
            flex: 1;
            border-radius: 50px;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, opacity 0.3s;
            border: 2px solid transparent;
            margin-top: 0;
        }

        .nav-btn:disabled {
            background-color: #e9edeb;
            color: #a0b0ab;
            cursor: not-allowed;
            border-color: #e9edeb;
        }

        .back-btn {
            background-color: #5E8082;
            color: #eaf1f1;
            border-color: #e9edeb;
        }

        .confirmation-previews {
            display: flex;
            gap: 20px;
            margin-bottom: 0;
        }

        .preview-container {
            flex: 1;
            position: relative;
            text-align: left;
        }

        .confirmation-previews.single {
            justify-content: center;
        }

        .confirmation-previews.single .preview-container {
            flex: 0 1 70%;
            max-width: 350px;
        }

        .preview-label {
            color: var(--text-secondary);
            font-weight: 500;
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid var(--border-inactive);
        }

        .preview-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e0e7e5;
            background-color: #f0f2f5;
        }

        .preview-icon {
            position: absolute;
            top: 50px;
            left: 15px;
            width: 28px;
            height: 28px;
            background-color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* --- Page 3 (OTP) Styles --- */
        .otp-container {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .otp-container h2 {
            margin-top: 0;
            font-size: 25px;
            color: #014122;
            font-weight: 500;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .otp-container p {
            font-size: 14px;
            color: #333333;
            margin-bottom: 16px;
            font-family: 'Actor', sans-serif;
            max-width: 310px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 0;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-bottom: 20px;
        }

        .otp-inputs input {
            width: 80px;
            height: 95px;
            font-size: 30px;
            text-align: center;
            border: 1px solid #d0e0db;
            border-radius: 14px;
            outline: none;
            background: #f8f8f8;
            transition: all 0.3s;
            font-family: 'Outfit', sans-serif;
            color: #333333;
        }

        .otp-inputs input::-webkit-outer-spin-button,
        .otp-inputs input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .otp-inputs input[type=number] {
            -moz-appearance: textfield;
        }

        .otp-inputs input:focus {
            background: #E5F8F2;
            border-color: var(--primary-green);
            color: #014122;
        }

        .confirm-btn {
            padding: 14px;
            font-size: 16px;
        }

        .otp-container .resend-otp {
            font-size: 13px !important;
            text-align: center !important;
            color: #6c757d !important;
            margin-top: 12px !important;
        }

        .otp-container .resend-otp a {
            color: #014122 !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }

        /* --- Modal Styles --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .success-modal-content {
            position: relative;
            text-align: center;
            padding: 30px;
            padding-top: 200px;
        }

        .success-icon {
            position: absolute;
            width: 220px;
            height: auto;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
        }

        .success-modal-content h2 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #014122;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 100;
        }

        .success-modal-content p {
            font-size: 14px;
            margin-left: auto;
            margin-right: auto;
            max-width: 350px;
            color: #333333;
            font-family: 'Actor', sans-serif;
        }

        .success-modal-btn {
            padding: 15px;
            font-size: 16px;
        }

        .otp-inputs.six-digits {
            gap: 5px;
        }

        .otp-inputs.six-digits input {
            width: 50px;
            height: 65px;
            font-size: 24px;
        }
    </style>
</head>

<body>

<div class="stepper-container">
    <!-- Step 1: Initial Selection -->
    <div id="step1" class="step active">
        <div class="verification-container">
            <h2>{{ __('verify_identity_heading') }}</h2>
            <p>{{ __('verify_identity_message') }}</p>
            <div class="options-list">
                <div class="verification-option active" data-key="document"><img
                        src="{{ asset('assets/web/document.png') }}" alt="Document Icon" class="icon" />
                    <div class="option-text">
                        <strong>{{ __('verify_doc_heading') }}</strong><span>{{ __('verify_doc_message') }}</span>
                    </div>
                    <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                           xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                fill="#014122" stroke="#014122" />
                        </svg></div>
                </div>
                <div class="verification-option" data-key="phone"><img src="{{ asset('assets/web/phone.png') }}"
                                                                       alt="Phone Icon" class="icon" />
                    <div class="option-text">
                        <strong>{{ __('verify_phone_heading') }}</strong><span>{{ __('verify_phone_message') }}</span>
                    </div>
                    <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                           xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                fill="#014122" stroke="#014122" />
                        </svg></div>
                </div>
                <div class="verification-option" data-key="email"><img src="{{ asset('assets/web/email.png') }}"
                                                                       alt="Email Icon" class="icon" />
                    <div class="option-text">
                        <strong>{{ __('verify_email_heading') }}</strong><span>{{ __('verify_email_message') }}</span>
                    </div>
                    <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                           xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                fill="#014122" stroke="#014122" />
                        </svg></div>
                </div>
            </div>
            <button class="next-btn" id="step1-next">{{ __('next_button') }}</button>
        </div>
    </div>

    <!-- Step 2: Document Verification Flow -->
    <div id="step2-doc" class="step">
        <div class="verification-flow-container narrow">
            <form id="doc-verification-form" action="{{ route('verify.documents') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Sub-step 0 -->
                <div class="form-step active" data-step="0">
                    <h2>{{ __('doc_verify_heading') }}</h2>
                    <p>{{ __('doc_verify_message') }}</p>
                    <div class="progress-indicator" id="progress-step-0"></div>
                    <div class="options-list">
                        <div class="verification-option active" data-value="id">
                            <div class="icon-container"><img src="{{ asset('assets/web/id_card_icon.png') }}"
                                                             class="icon-page2" alt="ID Card Icon"></div>
                            <div class="option-text">
                                <strong>{{ __('id_card_heading') }}</strong><span>{{ __('id_card_message') }}</span>
                            </div>
                            <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25"
                                                   fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                        fill="#014122" stroke="#014122" />
                                </svg></div>
                        </div>
                        <div class="verification-option" data-value="passport">
                            <div class="icon-container"><img src="{{ asset('assets/web/passport_icon.png') }}"
                                                             class="icon-page2" alt="Passport Icon"></div>
                            <div class="option-text">
                                <strong>{{ __('passport_heading') }}</strong><span>{{ __('passport_message') }}</span>
                            </div>
                            <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25"
                                                   fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                        fill="#014122" stroke="#014122" />
                                </svg></div>
                        </div>
                        <div class="verification-option" data-value="license">
                            <div class="icon-container"><img src=" {{ asset('assets/web/tatto_license_icon.png') }}"
                                                             class="icon-page2" alt="License Icon"></div>
                            <div class="option-text">
                                <strong>{{ __('tattoo_heading') }}</strong><span>{{ __('tattoo_message') }}</span>
                            </div>
                            <div class="tick"><svg width="24" height="25" viewBox="0 0 24 25"
                                                   fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                        fill="#014122" stroke="#014122" />
                                </svg></div>
                        </div>
                    </div>
                    <div class="button-group"><button type="button"
                                                      class="nav-btn back-btn">{{ __('back_button') }}</button><button type="button"
                                                                                                                       class="nav-btn next-btn">{{ __('next_button') }}</button></div>
                </div>

                <!-- Sub-step 1 -->
                <div class="form-step" data-step="1">
                    <h2 id="step-2-title"></h2>
                    <p id="step-2-desc"></p>
                    <div class="progress-indicator" id="progress-step-1"></div>
                    <label for="front-id-input" class="upload-area" id="front-upload-area">
                        <div class="upload-content"><img id="step-2-placeholder-img" src=""
                                                         class="id-frame-overlay" alt="ID Card Placeholder"></div>
                    </label>
                    <input type="file" name="front_image" id="front-id-input" accept="image/*">
                    <div class="button-group"><button type="button"
                                                      class="nav-btn back-btn">{{ __('back_button') }}</button><button type="button"
                                                                                                                       class="nav-btn next-btn" disabled>{{ __('next_button') }}</button></div>
                </div>

                <!-- Sub-step 2 -->
                <div class="form-step" data-step="2">
                    <h2 id="step-3-title">{{ __('back_id_verify_heading') }}</h2>
                    <p id="step-3-desc">{{ __('back_id_verify_message') }}</p>
                    <div class="progress-indicator" id="progress-step-2"></div>
                    <label for="back-id-input" class="upload-area" id="back-upload-area">
                        <div class="upload-content"><img src="{{ asset('assets/web/id_card.png') }}"
                                                         class="id-frame-overlay" alt="ID Card Placeholder"></div>
                    </label>
                    <input type="file" name="back_image" id="back-id-input" accept="image/*">
                    <div class="button-group"><button type="button"
                                                      class="nav-btn back-btn">{{ __('back_button') }}</button><button type="button"
                                                                                                                       class="nav-btn next-btn" disabled>{{ __('next_button') }}</button></div>
                </div>

                <!-- Sub-step 3 -->
                <div class="form-step" data-step="3">
                    <h2 id="confirmation-title"></h2>
                    <div class="confirmation-previews" id="confirmation-previews">
                        <div class="preview-container" id="front-preview-container">
                            <div class="preview-label" id="front-preview-label"></div>
                            <div class="preview-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                           height="16" fill="currentColor" class="bi bi-person-fill"
                                                           viewBox="0 0 16 16">
                                    <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg></div><img id="front-preview-img" src=""
                                                 alt="Front ID Preview">
                        </div>
                        <div class="preview-container" id="back-preview-container">
                            <div class="preview-label">{{ __('back') }}</div>
                            <div class="preview-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                           height="16" fill="currentColor" class="bi bi-person-fill"
                                                           viewBox="0 0 16 16">
                                    <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg></div><img id="back-preview-img" src="{{ asset('assets/web/id_card.png') }}"
                                                 alt="Back ID Preview">
                        </div>
                    </div>
                    <div class="button-group"><button type="button"
                                                      class="nav-btn back-btn">{{ __('back_button') }}</button><button type="submit"
                                                                                                                       class="nav-btn next-btn" id="confirm-docs">{{ __('confirm_button') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Step 3: OTP Input Screen (Phone/Email) -->
    <div id="step2-otp" class="step">
        <div class="otp-container">
            <form id="otp-verification-form" method="POST">
                @csrf
                <h2>{{ __('otp_heading') }}</h2>
                <p id="otp-text"></p>
                <div class="otp-inputs" id="otp-box-container">
                    <!-- JavaScript will generate input boxes here -->
                </div>
                <button type="submit" class="confirm-btn">{{ __('confirm_button') }}</button>
                <p class="resend-otp">{{ __('otp_not_receive') }} <a href="#" id="resend-otp-link">{{ __('otp_resend') }}</a></p>
                <button type="button" class="nav-btn back-btn mt-3" data-target="step1">Back</button>
            </form>
        </div>
    </div>

    <!-- INVISIBLE RECAPTCHA CONTAINER -->
    <div id="recaptcha-container-invisible"></div>

</div>

<!-- Success Modal -->
<div class="modal-overlay" id="success-modal">
    <div class="modal-content success-modal-content"><img class="success-icon"
                                                          src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">
        <h2>{{ __('verify_success_heading') }}</h2>
        <p>{{ __('verify_success_message') }}</p><button type="button" class="success-modal-btn"
                                                         id="done-btn">{{ __('left_continue') }}</button>
    </div>
</div>
<script>
    const firebaseConfig = {
        apiKey: "AIzaSyDVM3otRXbuWFPvpfmIPMVoTuTUtLYK2zs",
        authDomain: "guestly-8aa9a.firebaseapp.com",
        databaseURL: "https://guestly-8aa9a-default-rtdb.firebaseio.com",
        projectId: "guestly-8aa9a",
        storageBucket: "guestly-8aa9a.appspot.com",
        messagingSenderId: "548981851052",
        appId: "1:548981851052:web:fd64445a7cac155889b009')"
    };
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();

    document.addEventListener("DOMContentLoaded", () => {
        // Global variables
        let selectedDocType = 'id';
        const successModal = document.getElementById('success-modal');
        window.confirmationResult = null;
        window.recaptchaVerifier = null;
        let activeVerificationType = '';

        const showSuccess = (message) => Swal.fire({ icon: 'success', title: 'Success!', text: message, confirmButtonColor: '#0b3d27' });
        const showError = (message) => Swal.fire({ icon: 'error', title: 'Oops...', text: message || 'Something went wrong!', confirmButtonColor: '#0b3d27' });
        const redirectWithSuccess = (message, url) => {
            Swal.fire({
                icon: 'success', title: 'Great!', text: message, timer: 2000,
                showConfirmButton: false, allowOutsideClick: false,
                willClose: () => { window.location.href = url; }
            });
        };

        // --- Navigation & Helper Functions ---
        function goToMainStep(targetId) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById(targetId).classList.add('active');
        }

        function goToDocSubStep(targetIndex) {
            document.querySelectorAll('#step2-doc .form-step').forEach(s => s.classList.remove('active'));
            const targetStep = document.querySelector(`#step2-doc .form-step[data-step="${targetIndex}"]`);
            if (targetStep) targetStep.classList.add('active');
            document.querySelector('.verification-flow-container').classList.toggle('narrow', targetIndex !== 3);
        }

        const handleFetch = (response) => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    if (errorData.redirect_url) {
                        showError(errorData.error || 'You will be redirected.').then(() => { window.location.href = errorData.redirect_url; });
                    }
                    return Promise.reject(errorData);
                });
            }
            return response.json();
        };

        // --- Dynamic OTP box generator ---
        function generateOtpInputs(count) {
            const container = document.getElementById('otp-box-container');
            container.innerHTML = '';
            if (count === 6) {
                container.classList.add('six-digits');
            } else {
                container.classList.remove('six-digits');
            }
            for (let i = 0; i < count; i++) {
                const input = document.createElement('input');
                input.type = 'number';
                input.className = 'otp-input';
                input.maxLength = 1;
                container.appendChild(input);
            }
            addOtpEventListeners();
        }

        function addOtpEventListeners() {
            const otpInputs = document.querySelectorAll('#step2-otp .otp-input');
            otpInputs.forEach((input, index) => {
                input.addEventListener('keyup', (e) => {
                    if (input.value.length > 1) input.value = input.value.slice(0, 1);
                    if (e.key >= 0 && e.key <= 9 && index < otpInputs.length - 1 && input.value) {
                        otpInputs[index + 1].focus();
                    } else if (e.key === 'Backspace' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        }

        // --- Step 1: Initial Selection Logic ---
        document.querySelectorAll("#step1 .verification-option").forEach(opt => {
            opt.addEventListener("click", () => {
                document.querySelectorAll("#step1 .verification-option").forEach(o => o.classList.remove("active"));
                opt.classList.add("active");
            });
        });

        document.getElementById("step1-next").addEventListener("click", function() {
            const key = document.querySelector("#step1 .verification-option.active").dataset.key;
            activeVerificationType = key;
            const confirmBtn = this;

            if (key === "document") { goToMainStep('step2-doc'); }
            else if (key === "phone") {
                generateOtpInputs(6);
                sendFirebaseCode();
            }
            else if (key === "email") {
                generateOtpInputs(4);
                confirmBtn.disabled = true;
                confirmBtn.innerText = 'Please wait...';
                fetch('{{ route("generate.otp") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
                    .then(handleFetch)
                    .then(data => {
                        if (data.success) {
                            document.getElementById('otp-text').innerText = '{{ __("otp_message") }}';
                            goToMainStep('step2-otp');
                        } else { showError(data.message); }
                    })
                    .catch(error => { if (error && error.message) showError(error.message); })
                    .finally(() => {
                        confirmBtn.disabled = false;
                        confirmBtn.innerText = '{{ __("next_button") }}';
                    });
            }
        });

        // --- Firebase Phone Code Bhejne ka Reusable Function ---
        function sendFirebaseCode() {
            const userPhoneNumber = "{{ $user->phone ?? '' }}";
            if (!userPhoneNumber) { return showError('No phone number found in your profile.'); }

            Swal.fire({
                title: 'Preparing Verification...', text: 'Please wait a moment.',
                allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }
            });

            try {
                if (!window.recaptchaVerifier) {
                    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container-invisible', { 'size': 'invisible' });
                }
                const appVerifier = window.recaptchaVerifier;

                appVerifier.verify().then(function (response) {
                    Swal.update({ title: 'Sending Code...', text: 'Sending a verification code to ' + userPhoneNumber,showConfirmButton: false });
                    auth.signInWithPhoneNumber(userPhoneNumber, appVerifier)
                        .then((confirmationResult) => {
                            window.confirmationResult = confirmationResult;
                            Swal.close();
                            showSuccess('Verification code sent to ' + userPhoneNumber);
                            document.getElementById('otp-text').innerText = 'Enter the 6-digit code sent to ' + userPhoneNumber;
                            goToMainStep('step2-otp');
                        }).catch((error) => {
                        Swal.close();
                        showError('Failed to send code: ' + error.message);
                    });
                }).catch(function (error) {
                    Swal.close();
                    showError("reCAPTCHA verification failed. Please try again. " + error.message);
                });
            } catch (error) {
                Swal.close();
                showError("An error occurred while setting up verification. Please refresh the page.");
            }
        }

        // --- Step 2: Document Verification Logic ---
        document.querySelectorAll('#step2-doc .verification-option').forEach(opt => {
            opt.addEventListener("click", () => {
                document.querySelectorAll('#step2-doc .verification-option').forEach(o => o.classList.remove("active"));
                opt.classList.add("active");
                selectedDocType = opt.dataset.value;
                updateDocDynamicContent();
            });
        });

        document.querySelector('#step2-doc').addEventListener('click', function(e) {
            if (!e.target.matches('.next-btn, .back-btn')) return;
            const currentActive = this.querySelector('.form-step.active');
            const currentStepIndex = parseInt(currentActive.dataset.step, 10);
            if (e.target.matches('.next-btn')) {
                let nextStepIndex = currentStepIndex + 1;
                if (currentStepIndex === 1 && (selectedDocType === 'passport' || selectedDocType === 'license')) nextStepIndex = 3;
                goToDocSubStep(nextStepIndex);
            } else if (e.target.matches('.back-btn')) {
                let prevStepIndex = currentStepIndex - 1;
                if (currentStepIndex === 3 && (selectedDocType === 'passport' || selectedDocType === 'license')) prevStepIndex = 1;
                (prevStepIndex < 0) ? goToMainStep('step1'): goToDocSubStep(prevStepIndex);
            }
        });

        function setupUpload(inputId, areaId, previewImgId) {
            const input = document.getElementById(inputId), area = document.getElementById(areaId);
            const nextBtn = area.closest('.form-step').querySelector('.next-btn');
            input.addEventListener('change', e => {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = event => {
                        area.style.backgroundImage = `url('${event.target.result}')`;
                        area.classList.add('has-image');
                        if (document.getElementById(previewImgId)) document.getElementById(previewImgId).src = event.target.result;
                        if (nextBtn) nextBtn.disabled = false;
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
        setupUpload('front-id-input', 'front-upload-area', 'front-preview-img');
        setupUpload('back-id-input', 'back-upload-area', 'back-preview-img');

        document.getElementById('doc-verification-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const docVerificationContainer = document.getElementById('step2-doc');
            docVerificationContainer.style.display = 'none';

            Swal.fire({
                title: 'Uploading Document...', text: 'Please wait while we verify your document.',
                allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }
            });

            fetch(this.action, {
                method: 'POST', body: formData,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            })
                .then(handleFetch)
                .then(data => {
                    if (data.success) {
                        redirectWithSuccess(data.message, data.redirect_url);
                    } else {
                        showError('Upload failed: ' + data.message).then(() => { docVerificationContainer.style.display = 'block'; });
                    }
                })
                .catch(error => {
                    if (error && error.message) { showError(error.message).then(() => { docVerificationContainer.style.display = 'block'; }); }
                });
        });

        // --- OTP Verification Logic ---
        document.getElementById('otp-verification-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const otp_code = Array.from(document.querySelectorAll('#step2-otp .otp-input')).map(input => input.value).join('');
            Swal.fire({ title: 'Verifying...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            if (activeVerificationType === 'phone') {
                if (otp_code.length < 6) { return showError('Please enter the complete 6-digit OTP.'); }
                if (!window.confirmationResult) { return showError('Session expired. Please resend code.'); }
                window.confirmationResult.confirm(otp_code).then((result) => {
                    fetch('{{ route("auth.verify.phone") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        body: JSON.stringify({ phone: result.user.phoneNumber })
                    })
                        .then(handleFetch)
                        .then(data => data.success ? redirectWithSuccess(data.message, data.redirect_url) : showError(data.message))
                        .catch(() => showError('Failed to update your profile.'));
                }).catch(() => showError('Invalid code. Please try again.'));
            }
            else if (activeVerificationType === 'email') {
                if (otp_code.length < 4) { return showError('Please enter the complete 4-digit OTP.'); }
                const formData = new FormData();
                formData.append('otp', otp_code);
                fetch('{{ route("auth.verify.otp") }}', {
                    method: 'POST', body: formData,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                })
                    .then(handleFetch)
                    .then(data => data.success ? redirectWithSuccess(data.message, data.redirect_url) : showError(data.message))
                    .catch(err => { if(err && err.message) showError(err.message); });
            }
        });

        // --- Resend OTP Logic ---
        document.getElementById('resend-otp-link').addEventListener('click', function(e) {
            e.preventDefault();
            const resendLink = this;

            if (activeVerificationType === 'phone') {
                resendLink.style.pointerEvents = 'none';
                resendLink.innerText = 'Sending...';
                sendFirebaseCode();
                setTimeout(() => {
                    resendLink.style.pointerEvents = 'auto';
                    resendLink.innerText = '{{ __("otp_resend") }}';
                }, 5000);
            }
            else if (activeVerificationType === 'email') {
                resendLink.style.pointerEvents = 'none';
                resendLink.innerText = 'Sending...';
                fetch('{{ route("auth.resend.otp") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
                    .then(handleFetch)
                    .then(data => { if (data.success) { showSuccess(data.message); } else { showError('Error: ' + data.message); } })
                    .catch(error => { if (error && error.message) showError(error.message); })
                    .finally(() => {
                        resendLink.innerText = '{{ __("otp_resend") }}';
                        resendLink.style.pointerEvents = 'auto';
                    });
            }
        });

        // --- Other Event Listeners & Initial Calls ---
        document.querySelectorAll('.back-btn[data-target="step1"]').forEach(btn => btn.addEventListener('click', () => goToMainStep('step1')));
        document.getElementById('done-btn')?.addEventListener('click', () => { window.location.href = '{{ route("dashboard.explore") }}'; });

        function updateDocDynamicContent() {
            const progressStep0 = document.getElementById('progress-step-0'),
                progressStep1 = document.getElementById('progress-step-1'),
                progressStep2 = document.getElementById('progress-step-2');
            const frontPreviewLabel = document.getElementById('front-preview-label'),
                confirmationTitle = document.getElementById('confirmation-title');
            const step2Title = document.getElementById('step-2-title'),
                step2Desc = document.getElementById('step-2-desc'),
                step2Placeholder = document.getElementById('step-2-placeholder-img');
            const three_steps_html = '<div class="progress-step active"></div><div class="progress-step"></div><div class="progress-step"></div>';
            const two_steps_html = '<div class="progress-step active"></div><div class="progress-step"></div>';
            document.getElementById('back-preview-container').style.display = (selectedDocType === 'id') ? '' : 'none';
            document.getElementById('confirmation-previews').classList.toggle('single', selectedDocType !== 'id');
            if (selectedDocType === 'id') {
                step2Title.textContent = '{{ __("front_id_verify_heading") }}';
                step2Desc.textContent = '{{ __("front_id_verify_message") }}';
                step2Placeholder.src = "{{ asset('assets/web/id_card.png') }}";
                confirmationTitle.textContent = '{{ __("confirm_verify_heading") }}';
                frontPreviewLabel.textContent = '{{ __("front") }}';
                progressStep0.innerHTML = three_steps_html;
                progressStep1.innerHTML = '<div class="progress-step active"></div><div class="progress-step active"></div><div class="progress-step"></div>';
                progressStep2.innerHTML = '<div class="progress-step active"></div><div class="progress-step active"></div><div class="progress-step active"></div>';
            } else {
                progressStep0.innerHTML = two_steps_html;
                progressStep1.innerHTML = '<div class="progress-step active"></div><div class="progress-step active"></div>';
                progressStep2.innerHTML = '';
                if (selectedDocType === 'passport') {
                    step2Title.textContent = '{{ __("passport_verify_heading") }}';
                    step2Desc.textContent = '{{ __("passport_verify_message") }}';
                    step2Placeholder.src = "{{ asset('assets/web/passport_icon.png') }}";
                    confirmationTitle.textContent = '{{ __("passport_confirm_heading") }}';
                    frontPreviewLabel.textContent = '{{ __("passport_image") }}';
                } else { // License
                    step2Title.textContent = '{{ __("tattoo_verify_heading") }}';
                    step2Desc.textContent = '{{ __("tattoo_verify_message") }}';
                    step2Placeholder.src = "{{ asset('assets/web/tatto_license_icon.png') }}";
                    confirmationTitle.textContent = '{{ __("tattoo_confirm_heading") }}';
                    frontPreviewLabel.textContent = '{{ __("tattoo_image") }}';
                }
            }
        }
        updateDocDynamicContent();
    });
</script>
</body>
</html>
