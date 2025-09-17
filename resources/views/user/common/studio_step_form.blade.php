<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <!-- USER: Yahan apna favicon link dalein -->
    {{--    <link rel="icon" type="image/png" href="{{ asset ('guestly_favicon.png') }}" /> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-color: #e6f4f0;
            --primary-green: #0b3d27;
            --secondary-green-btn: #5e8082;
            --text-primary: #0b3d27;
            --text-secondary: #5d7a70;
            --border-active: #0b3d27;
            --border-inactive: #e0e7e5;
            --card-bg: #ffffff;
            --label-color: #888;
        }

        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .studio-flow-container {
            background: var(--card-bg);
            border-radius: 35px;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: filter 0.3s ease;
            position: relative;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .form-slider-track {
            position: relative;
            overflow: hidden;
            flex: 1;
            display: flex;
        }

        .form-step {
            width: 100%;
            padding: 40px;
            display: none;
            flex-direction: column;
            flex-shrink: 0;
        }

        .form-step.active {
            display: flex;
        }

        .form-step h2 {
            font-size: 29px;
            font-weight: 500;
            margin: 0 0 5px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            color: var(--primary-green);
        }

        .form-step p.subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .progress-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .progress-step {
            width: 100px;
            height: 4px;
            background-color: #dbe3e0;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .progress-step.active {
            background-color: var(--primary-green);
        }

        .form-content-scrollable {
            flex: 1;
            overflow-y: auto;
            padding: 5px 15px 10px 0;
            margin-right: -15px;
        }

        .form-content-scrollable::-webkit-scrollbar {
            width: 8px;
        }

        .form-content-scrollable::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .form-content-scrollable::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        /* --- STYLES FOR STEP 1 & Floating Labels --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            margin-bottom: -10px;
            margin-top: -4px;
        }

        .form-group {
            text-align: left;
            width: 100%;
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .floating-label-group {
            position: relative;
            margin-bottom: 16px;
        }

        .floating-label-group input,
        .floating-label-group select {
            width: 100%;
            padding: 22px 16px 10px 16px;
            font-size: 16px;
            border: 1px solid #92a5a0;
            border-radius: 8px;
            background-color: var(--card-bg);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .floating-label-group.with-icon select {
            padding-left: 50px;
        }

        .floating-label-group label {
            position: absolute;
            top: 18px;
            left: 17px;
            color: var(--label-color);
            font-size: 16px;
            font-weight: 400;
            pointer-events: none;
            transition: all 0.2s ease-out;
            margin-bottom: 0;
        }

        .floating-label-group.with-icon label {
            left: 50px;
        }

        .floating-label-group input:focus+label,
        .floating-label-group input:not(:placeholder-shown)+label,
        .floating-label-group select:focus+label,
        .floating-label-group select:valid+label {
            top: 7px;
            font-size: 12px;
        }

        .floating-label-group select:focus+label,
        .floating-label-group select:valid+label {
            color: var(--text-secondary);
        }

        .floating-label-group input:focus+label {
            color: var(--primary-green);
        }

        .floating-label-group select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 16px center;
            background-repeat: no-repeat;
            background-size: 1.25em;
            padding-right: 40px;
            appearance: none;
        }

        .form-group-social {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border: 1px solid #92a5a0;
            border-radius: 8px;
        }

        .social-icon img {
            width: 32px;
            height: 32px;
            margin-right: 12px;
        }

        .social-text {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left;
        }

        .social-name {
            font-size: 14px;
            color: #555;
        }

        .social-status {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .social-disconnect {
            color: #000;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }

        .input-with-icon .icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: auto;
        }

        /* --- STYLES FOR STEP 2 --- */
        .field-row-bordered {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-inactive);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            text-align: left;
        }

        .field-row-bordered .row-label {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .billing-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            user-select: none;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 500;
        }

        .billing-toggle span {
            font-size: 14px;
            transition: color 0.4s ease;
            cursor: pointer;
        }

        .billing-toggle span:first-of-type {
            color: var(--primary-green);
        }

        .billing-toggle span:last-of-type {
            color: #828282;
        }

        .billing-toggle:has(input:checked) span:first-of-type {
            color: #828282;
        }

        .billing-toggle:has(input:checked) span:last-of-type {
            color: var(--primary-green);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 6px;
            background-color: var(--primary-green);
            transition: .4s;
            border-radius: 10px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: -6px;
            bottom: -4px;
            background-color: #e6f4f0;
            border: 2px solid var(--primary-green);
            box-sizing: border-box;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .field-group-container {
            border: 1px solid var(--border-inactive);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .field-group-container .field-row-bordered {
            margin-bottom: 0;
            border: none;
            border-radius: 0;
            border-bottom: 1px solid var(--border-inactive);
        }

        .field-group-container .field-row-bordered:last-child {
            border-bottom: none;
        }

        .radio-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .radio-container input {
            display: none;
        }

        .radio-visual {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--border-inactive);
            position: relative;
            transition: border-color 0.2s;
        }

        .radio-container input:checked+.radio-visual {
            border-color: #5E8082;
        }

        .radio-visual::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #5E8082;
            transition: transform 0.2s ease-in-out;
        }

        .radio-container input:checked+.radio-visual::after {
            transform: translate(-50%, -50%) scale(1);
        }

        .upload-policy-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-inactive);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .upload-policy-row .placeholder-text {
            font-size: 16px;
            color: var(--label-color);
        }

        .upload-policy-row .upload-link {
            font-weight: 600;
            font-size: 16px;
            color: var(--primary-green);
            text-decoration: underline;
            cursor: pointer;
        }

        /* --- STYLES FOR STEP 3 --- */
        .upload-item-container {
            margin-bottom: 24px;
        }

        .upload-box-dotted {
            border: 2px dotted var(--primary-green);
            border-radius: 12px;
            padding: 45px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s ease;
            position: relative;
            min-height: 80px;
        }

        .upload-box-dotted:hover {
            background-color: #f7f9f8;
        }

        .upload-box-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: opacity 0.3s;
        }

        .upload-box-content .icon {
            color: var(--primary-green);
        }

        .upload-box-content .label {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-green);
        }

        .upload-info-text {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 12px;
            text-align: left;
            padding-left: 5px;
        }

        .upload-info-text .icon {
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .image-preview-inline {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .upload-box-dotted.has-preview .upload-box-content {
            opacity: 0;
        }

        .upload-box-dotted.has-preview .image-preview-inline {
            opacity: 1;
        }

        .image-preview-gallery {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
            min-height: 110px;
        }

        .image-preview-gallery img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .image-preview-gallery::-webkit-scrollbar {
            height: 6px;
        }

        .image-preview-gallery::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 6px;
        }

        .swal2-popup {
            font-family: 'Poppins', sans-serif !important;
        }

        .swal2-confirm {
            background-color: var(--primary-green) !important;
            box-shadow: none !important;
        }

        .swal2-icon.swal2-warning {
            border-color: #f8bb86 !important;
            color: #f8bb86 !important;
        }

        /* --- STYLES FOR STEP 4 --- */
        .supplies-group {
            margin-top: 10px;
            margin-bottom: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .supply-tag {
            background-color: #BBDBC3;
            padding: 13px 15px;
            border-radius: 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 500;
            font-size: 14px;
            min-width: 160px;
            max-width: fit-content;
            gap: 10px;
            font-family: 'Actor', sans-serif
        }

        .supply-tag .cross {
            color: #BBDBC3;
            cursor: pointer;
            font-weight: bold;
            background-color: #014122;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            margin-left: 5px;
            margin-top: -1px;
            position: relative;
            transition: background-color 0.2s;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .amenities-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: left;
            margin-top: 16px;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .amenity-label {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .amenity-checkbox {
            width: 22px;
            height: 22px;
            border: 2px solid var(--border-inactive);
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: border-color 0.2s;
        }

        .amenity-checkbox::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #5E8082;
            transition: transform 0.2s ease-in-out;
        }

        .amenity-checkbox.checked {
            border-color: #5E8082;
        }

        .amenity-checkbox.checked::after {
            transform: translate(-50%, -50%) scale(1);
        }

        /* --- SHARED STYLES --- */
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border-inactive);
        }

        .nav-btn {
            flex: 1;
            border-radius: 50px;
            padding: 15px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s, opacity 0.3s;
            border: none;
            margin: -2px
        }

        .back-btn {
            background-color: var(--secondary-green-btn);
            color: white;
            font-size: 16px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 500;
        }

        .next-btn {
            background-color: var(--primary-green);
            color: white;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 100;
        }

        /* --- MODAL STYLES (UPDATED) --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(94, 128, 130, 0.3);
            /* Semi-transparent background */
            display: none;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: var(--card-bg);
            padding: 40px;
            /* Increased padding for better spacing */
            border-radius: 24px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 90%;
        }

        .success-icon {
            width: 240px;
            /* <<< YAHAN IMAGE SIZE INCREASE KI HAI */
            height: auto;
            margin-bottom: -100px;
            /* Adjusted margin for better spacing */
            margin-top: -90px;
        }

        .modal-content h2 {
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-size: 24px;
            font-weight: 500;
            color: #014122;
            margin: 0 0 15px;
        }

        .modal-content p {
            font-size: 16px;
            font-family: 'Actor', sans-serif;
            color: #333333;
            line-height: 1.2;
            margin: 0 auto 30px auto;
            max-width: 90%;

        }

        .modal-continue-btn {
            width: 100%;
            background-color: #014122;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            transition: background-color 0.2s;
            margin-left: -8px;
            margin-top: -15px;
        }

        .modal-continue-btn:hover {
            background-color: #083120;
            /* A slightly darker green for hover */
        }
    </style>
</head>

<body>

    <div class="studio-flow-container">
        <div class="form-slider-track">

            <!-- STEP 1 -->
            <div class="form-step" data-step="0">
                <h2>List Your Studio</h2>
                <p class="subtitle">Fill Out Your Information</p>
                <div class="progress-indicator">
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                    <div class="progress-step"></div>
                    <div class="progress-step"></div>
                </div>
                <div class="form-content-scrollable">
                    <div class="form-grid">
                        <div class="form-group floating-label-group"><input type="text" id="studio-name" required
                                placeholder=" "><label for="studio-name">Studio Name</label></div>
                        <div class="form-group floating-label-group"><input type="email" id="business-email" required
                                placeholder=" "><label for="business-email">Business Email</label></div>
                        <div class="form-group full-width floating-label-group"><input type="text"
                                id="studio-address" required placeholder=" "><label for="studio-address">Studio
                                Address</label></div>
                        <div class="form-group full-width floating-label-group with-icon input-with-icon"><img
                                src="https://flagcdn.com/gb.svg" alt="UK Flag" class="icon"><select id="languages"
                                required>
                                <option value="" disabled selected hidden></option>
                                <option value="English">English</option>
                                <option value="Spanish">Spanish</option>
                            </select><label for="languages">Languages</label></div>
                        <div class="form-group full-width floating-label-group"><input type="url" id="website-url"
                                required placeholder=" "><label for="website-url">Website URL</label></div>
                        <div class="form-group full-width floating-label-group"><select id="country" required>
                                <option value="" disabled selected hidden></option>
                                <option value="US">United States (+1)</option>
                                <option value="UK">United Kingdom (+44)</option>
                            </select><label for="country">Country/Region</label></div>
                        <div class="form-group full-width floating-label-group"><input type="tel" id="phone-number"
                                value="+1 " required placeholder=" "><label for="phone-number">Phone number</label>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group-social">
                            <div class="social-icon"><img
                                    src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png"
                                    alt="Instagram Logo"></div>
                            <div class="social-text"><span class="social-name">Instagram</span><span
                                    class="social-status">Connected</span></div><a href="#"
                                class="social-disconnect">Disconnect</a>
                        </div>
                    </div>
                </div>
                <div class="button-group"><button class="nav-btn next-btn">Next</button></div>
            </div>

            <!-- STEP 2 -->
            <div class="form-step" data-step="1">
                <h2>List Your Studio</h2>
                <p class="subtitle">Fill out the Basic Information</p>
                <div class="progress-indicator">
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                    <div class="progress-step"></div>
                </div>
                <div class="form-content-scrollable">
                    <div class="floating-label-group"><select required>
                            <option value="6" selected>6</option>
                            <option value="1">1</option>
                        </select><label>Total Guest Stations Available</label></div>
                    <div class="floating-label-group"><select required>
                            <option value="Private Studio" selected>Private Studio</option>
                            <option value="Public Studio">Public Studio</option>
                        </select><label>Studio Type</label></div>
                    <div class="field-row-bordered"><span class="row-label">Require Portfolio</span>
                        <div class="billing-toggle"><span>No</span><label class="switch"><input type="checkbox"><span
                                    class="slider"></span></label><span>Yes</span></div>
                    </div>
                    <div class="field-row-bordered"><span class="row-label">Accept Bookings Now</span>
                        <div class="billing-toggle"><span>No</span><label class="switch"><input type="checkbox"><span
                                    class="slider"></span></label><span>Yes</span></div>
                    </div>
                    <div class="floating-label-group"><select required>
                            <option value="No Preference" selected>No Preference</option>
                            <option value="Full Day">Full Day</option>
                        </select><label>Preferred Guest Duration</label></div>
                    <div class="floating-label-group"><select required>
                            <option value="" disabled selected hidden></option>
                            <option value="Percentage">Percentage</option>
                            <option value="Fixed Rate">Fixed Rate</option>
                        </select><label>Commission Options</label></div>
                    <div class="field-group-container">
                        <div class="field-row-bordered"><span class="row-label">% of Earnings</span><label
                                class="radio-container"><input type="radio" name="commission_type" checked><span
                                    class="radio-visual"></span></label></div>
                        <div class="field-row-bordered"><span class="row-label">Fixed Daily Fee</span><label
                                class="radio-container"><input type="radio" name="commission_type"><span
                                    class="radio-visual"></span></label></div>
                        <div class="field-row-bordered"><span class="row-label">Custom</span><label
                                class="radio-container"><input type="radio" name="commission_type"><span
                                    class="radio-visual"></span></label></div>
                    </div>
                    <div class="field-row-bordered"><span class="row-label">Allow Guest to Choose</span>
                        <div class="billing-toggle"><span>No</span><label class="switch"><input type="checkbox"><span
                                    class="slider"></span></label><span>Yes</span></div>
                    </div>
                    <div class="upload-policy-row"><span class="placeholder-text">Upload Guest Policy</span><a
                            class="upload-link">Upload</a></div>
                </div>
                <div class="button-group"><button class="nav-btn back-btn">Back</button><button
                        class="nav-btn next-btn">Next</button></div>
            </div>

            <!-- STEP 3 -->
            <div class="form-step" data-step="2">
                <h2>List Your Studio</h2>
                <p class="subtitle">Upload Studio Photos</p>
                <div class="progress-indicator">
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                </div>
                <div class="form-content-scrollable">
                    <div class="upload-item-container">
                        <div class="upload-box-dotted" id="logo-upload-box">
                            <div class="upload-box-content"><span class="icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z" />
                                    </svg></span><span class="label">Studio Logo</span></div>
                            <img id="logo-preview" class="image-preview-inline" src="" alt="Logo Preview">
                        </div>
                        <input type="file" id="logo-file-input" hidden accept="image/*">
                        <p class="upload-info-text"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.064.293.006.399.287.47l.45.083.082.38-2.29.287-.082-.38.45-.083a.39.39 0 0 0 .288-.469l.738-3.468a.39.39 0 0 0-.288-.469l-.45-.083-.082-.38 2.29-.287zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg></span><span>You can upload PDF, JPG, PNG, or ZIP files up to 50MB each.</span>
                        </p>
                    </div>
                    <div class="upload-item-container">
                        <div class="upload-box-dotted" id="cover-upload-box">
                            <div class="upload-box-content"><span class="icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                    </svg></span><span class="label">Studio Cover</span></div>
                            <img id="cover-preview" class="image-preview-inline" src="" alt="Cover Preview">
                        </div>
                        <input type="file" id="cover-file-input" hidden accept="image/*">
                        <p class="upload-info-text"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.064.293.006.399.287.47l.45.083.082.38-2.29.287-.082-.38.45-.083a.39.39 0 0 0 .288-.469l.738-3.468a.39.39 0 0 0-.288-.469l-.45-.083-.082-.38 2.29-.287zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg></span><span>You can upload PDF, JPG, PNG, or ZIP files up to 50MB each.</span>
                        </p>
                    </div>
                    <div class="upload-item-container">
                        <div class="upload-box-dotted" id="gallery-upload-box">
                            <div class="upload-box-content"><span class="icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z" />
                                    </svg></span><span class="label">Upload 1–5 Studio Photos</span></div>
                        </div>
                        <p class="upload-info-text"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.064.293.006.399.287.47l.45.083.082.38-2.29.287-.082-.38.45-.083a.39.39 0 0 0 .288-.469l.738-3.468a.39.39 0 0 0-.288-.469l-.45-.083-.082-.38 2.29-.287zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg></span><span>You can upload PDF, JPG, PNG, or ZIP files up to 50MB each.</span>
                        </p>
                    </div>
                    <input type="file" id="gallery-file-input" multiple hidden accept="image/*">
                    <div class="image-preview-gallery" id="gallery-preview-container"></div>
                </div>
                <div class="button-group"><button class="nav-btn back-btn">Back</button><button
                        class="nav-btn next-btn">Next</button></div>
            </div>

            <!-- STEP 4 -->
            <div class="form-step" data-step="3">
                <h2>List Your Studio</h2>
                <p class="subtitle">Select Supplies & Amenities</p>
                <div class="progress-indicator">
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                </div>
                <div class="form-content-scrollable">
                    <div class="floating-label-group">
                        <select id="supplies-provided" required>
                            <option value="" disabled selected hidden></option>
                            <option value="Ink">Ink</option>
                            <option value="Needle">Needle</option>
                            <option value="Stencil">Stencil</option>
                        </select>
                        <label for="supplies-provided">Supplies Provided</label>
                    </div>
                    <div class="supplies-group" id="selected-supplies"></div>
                    <h4>Select Station Amenities Needs</h4>
                    <div class="amenities-list">
                        <div class="amenity-item">
                            <div class="amenity-label"><span>👩‍💼</span><span>Studio Manager or Assistant On
                                    Site</span></div>
                            <div class="amenity-checkbox checked" data-amenity="manager"></div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-label"><span>🕒</span><span>24/7 Studio Access</span></div>
                            <div class="amenity-checkbox" data-amenity="access"></div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-label"><span>🧹</span><span>Station Set Up and Break Down</span></div>
                            <div class="amenity-checkbox" data-amenity="setup"></div>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-label"><span>📸</span><span>Photo Station</span></div>
                            <div class="amenity-checkbox" data-amenity="photo"></div>
                        </div>
                    </div>
                </div>
                <div class="button-group"><button class="nav-btn back-btn">Back</button><button
                        class="nav-btn next-btn" id="finish-btn">Next</button></div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="success-modal">
        <div class="modal-content">
            <!-- Make sure you have the correct path for this image -->
            <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Thumbs Up">
            <h2>Studio Setup Complete!</h2>
            <p>Your listing is under review. After approval you can start receiving booking requests and managing your
                availability from your dashboard.</p>
            <button class="modal-continue-btn" onclick="window.location.href='boost_studio'"
                id="modal-continue-btn">Continue</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nextBtns = document.querySelectorAll('.next-btn');
            const backBtns = document.querySelectorAll('.back-btn');
            const steps = document.querySelectorAll('.form-step');
            let currentStep = 0;

            function goToStep(stepIndex) {
                const totalSteps = steps.length;
                if (stepIndex >= totalSteps || stepIndex < 0) return;
                steps.forEach((step, index) => step.classList.toggle('active', index === stepIndex));
                currentStep = stepIndex;
                const activeStep = steps[currentStep];
                if (activeStep) {
                    const backBtn = activeStep.querySelector('.back-btn');
                    if (backBtn) backBtn.disabled = currentStep === 0;
                }
                updateProgressBar();
            }

            const updateProgressBar = () => {
                steps.forEach((step) => {
                    const indicator = step.querySelector('.progress-indicator');
                    if (indicator) {
                        const stepIndicators = indicator.querySelectorAll('.progress-step');
                        stepIndicators.forEach((progress, progressIdx) => progress.classList.toggle(
                            'active', progressIdx <= currentStep));
                    }
                });
            };

            nextBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        goToStep(currentStep + 1);
                    }
                });
            });
            backBtns.forEach(btn => btn.addEventListener('click', () => {
                if (currentStep > 0) goToStep(currentStep - 1);
            }));

            window.addEventListener('load', () => document.body.style.opacity = 1);
            goToStep(0);

            // --- Step 3 Logic ---
            function setupSingleUploader(boxId, inputId, previewId) {
                const box = document.getElementById(boxId);
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (box && input && preview) {
                    box.addEventListener('click', () => input.click());
                    input.addEventListener('change', (event) => {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = () => {
                                preview.src = reader.result;
                                box.classList.add('has-preview');
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            }
            setupSingleUploader('logo-upload-box', 'logo-file-input', 'logo-preview');
            setupSingleUploader('cover-upload-box', 'cover-file-input', 'cover-preview');

            const galleryUploadBox = document.getElementById('gallery-upload-box');
            const galleryFileInput = document.getElementById('gallery-file-input');
            const galleryPreviewContainer = document.getElementById('gallery-preview-container');

            if (galleryUploadBox && galleryFileInput && galleryPreviewContainer) {
                galleryUploadBox.addEventListener('click', () => galleryFileInput.click());
                galleryFileInput.addEventListener('change', (event) => {
                    const files = event.target.files;
                    if (files.length > 5) {
                        Swal.fire({
                            title: 'Limit Exceeded!',
                            text: 'You can only upload a maximum of 5 photos.',
                            icon: 'warning',
                            confirmButtonText: 'Got it!',
                            customClass: {
                                popup: 'swal2-popup',
                                confirmButton: 'swal2-confirm'
                            }
                        });
                        galleryFileInput.value = "";
                        return;
                    }

                    galleryPreviewContainer.innerHTML = '';
                    for (const file of files) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = () => {
                                const img = document.createElement('img');
                                img.src = reader.result;
                                galleryPreviewContainer.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });
            }

            // --- Step 4 Logic ---
            const select = document.getElementById('supplies-provided');
            const suppliesContainer = document.getElementById('selected-supplies');
            if (select && suppliesContainer) {
                const selectedValues = new Set();
                select.addEventListener('change', function() {
                    const value = this.value;
                    if (value && !selectedValues.has(value)) {
                        selectedValues.add(value);
                        const tag = document.createElement('div');
                        tag.className = 'supply-tag';
                        tag.innerHTML = `${value} <span class="cross">×</span>`;
                        tag.querySelector('.cross').onclick = () => {
                            selectedValues.delete(value);
                            tag.remove();
                        };
                        suppliesContainer.appendChild(tag);
                    }
                    this.value = "";
                });
            }

            const amenityCheckboxes = document.querySelectorAll('.amenity-checkbox');
            amenityCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', () => checkbox.classList.toggle('checked'));
            });

            // --- NEW MODAL LOGIC ---
            const finishBtn = document.getElementById('finish-btn');
            const successModal = document.getElementById('success-modal');
            const modalContinueBtn = document.getElementById('modal-continue-btn');
            const mainContainer = document.querySelector('.studio-flow-container');

            if (finishBtn && successModal && mainContainer && modalContinueBtn) {
                finishBtn.addEventListener('click', () => {
                    // This check ensures it only fires on the last step
                    if (currentStep === steps.length - 1) {
                        mainContainer.style.filter = 'blur(5px)';
                        successModal.style.display = 'flex';
                    }
                });

                modalContinueBtn.addEventListener('click', () => {
                    // You can define what "Continue" does here.
                    // For now, it will just close the modal and unblur the background.
                    // You could also redirect the user e.g. window.location.href = '/dashboard';
                    mainContainer.style.filter = 'none';
                    successModal.style.display = 'none';
                });
            }
        });
    </script>

</body>

</html>
