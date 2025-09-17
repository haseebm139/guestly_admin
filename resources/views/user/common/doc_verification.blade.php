<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --bg-color: #e6f4f0;
            --primary-green: #0b3d27;
            --secondary-green-btn: #8ba89d;
            --text-primary: #0b3d27;
            --text-secondary: #5d7a70;
            --border-active: #0b3d27;
            --border-inactive: #e0e7e5;
            --card-bg: #ffffff;
            --card-bg-active: #eaf5ef;
        }

        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
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

        .verification-flow-container {
            background: var(--card-bg);
            border-radius: 24px;
            width: 100%;
            max-width: 720px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 0;
            transition: max-width 0.3s cubic-bezier(0.25, 0.1, 0.25, 1), height 0.3s cubic-bezier(0.25, 0.1, 0.25, 1), filter 0.3s ease;
        }

        .verification-flow-container.narrow {
            max-width: 480px;
        }

        .verification-flow-container.blur-background {
            filter: blur(5px);
            pointer-events: none;
        }

        .form-slider-track {
            position: relative;
        }

        .form-step {
            width: 100%;
            padding: 40px;
            opacity: 0;
            visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s;
        }

        .form-step.active {
            opacity: 1;
            visibility: visible;
            position: relative;
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
            /* Increase height for active step */
            margin-top: -3px;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .verification-option {
            display: flex;
            align-items: center;
            text-align: left;
            padding: 15px;
            border: 2px solid var(--border-inactive);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .verification-option.active {
            border-color: #5E8082;
            background-color: var(--card-bg-active);
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

        .verification-option .icon {
            width: 52px;
            height: auto;
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

        .option-text span {
            font-size: 13px;
            color: #333333;
            font-family: 'Actor', sans-serif
        }

        .verification-option.active .option-text strong {
            color: #014122;
        }

        .checkmark {
            font-size: 24px;
            color: var(--primary-green);
            font-weight: bold;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .verification-option .tick {
            margin-left: auto;
            /* push to right side */
            display: flex;
            visibility: hidden;
            /* hide by default */
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            /* space between text and icon */
        }

        .verification-option .tick svg {
            width: 36px;
            /* increase icon size as needed */
            height: 36px;
        }

        .verification-option.active .tick {
            visibility: visible;
            opacity: 1;
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

        .back-btn:disabled {
            opacity: 1.5;
            color: #eaf1f1;
            background-color: #5E8082
        }

        .next-btn {
            background-color: #014122;
            color: white;
            border-color: var(--primary-green);
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 100;
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
            background: var(--card-bg);
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
        }

        .success-modal-content p {
            font-size: 13px;
            margin-left: auto;
            margin-right: auto;
            max-width: 350px;
            color: #292c2b;
        }

        .success-modal-btn {
            background-color: var(--primary-green);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="verification-flow-container narrow">
        <div class="form-slider-track">

            <!-- STEP 1: Document Selection -->
            <div class="form-step active" data-step="0">
                <h2>{{ __('doc_verify_heading') }}</h2>
                <p>{{ __('doc_verify_message') }}</p>
                <div class="progress-indicator" id="progress-step-0">
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                    <div class="progress-step"></div>
                </div>
                <div class="options-list">
                    <div class="verification-option active" data-value="id">
                        <div class="icon-container"><img src="{{ asset('assets/web/id_card_icon.png') }}" class="icon"
                                alt="ID Card Icon"></div>
                        <div class="option-text">
                            <strong>{{ __('id_card_heading') }}</strong><span>{{ __('id_card_message') }}</span>
                        </div>
                        {{--                    <div class="checkmark">✓</div> --}}
                        <div class="tick">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                    fill="#014122" stroke="#014122" />
                            </svg>
                        </div>
                    </div>
                    <div class="verification-option" data-value="passport">
                        <div class="icon-container"><img src="{{ asset('assets/web/passport_icon.png') }}" class="icon"
                                alt="Passport Icon"></div>
                        <div class="option-text">
                            <strong>{{ __('passport_heading') }}</strong><span>{{ __('passport_message') }}</span>
                        </div>
                        {{--                    <div class="checkmark">✓</div> --}}
                        <div class="tick">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                    fill="#014122" stroke="#014122" />
                            </svg>
                        </div>
                    </div>
                    <div class="verification-option" data-value="license">
                        <div class="icon-container"><img src=" {{ asset('assets/web/tatto_license_icon.png') }}" class="icon"
                                alt="License Icon"></div>
                        <div class="option-text">
                            <strong>{{ __('tattoo_heading') }}</strong><span>{{ __('tattoo_message') }}</span>
                        </div>
                        {{--                    <div class="checkmark">✓</div> --}}
                        <div class="tick">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                    fill="#014122" stroke="#014122" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="button-group">
                    <button class="nav-btn back-btn" disabled>{{ __('back_button') }}</button>
                    <button class="nav-btn next-btn">{{ __('next_button') }}</button>
                </div>
            </div>

            <!-- STEP 2: Front / Single Image Upload -->
            <div class="form-step" data-step="1">
                <h2 id="step-2-title">{{ __('front_id_verify_heading') }}</h2>
                <p id="step-2-desc">{{ __('front_id_verify_message') }}</p>
                <div class="progress-indicator" id="progress-step-1">
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                </div>
                <label for="front-id-input" class="upload-area" id="front-upload-area">
                    <div class="upload-content">
                        <img id="step-2-placeholder-img" src="{{ asset('assets/web/id_card.png') }}" class="id-frame-overlay"
                            alt="ID Card Placeholder">
                    </div>
                </label>
                <input type="file" id="front-id-input" accept="image/*">
                <div class="button-group">
                    <button class="nav-btn back-btn">{{ __('back_button') }}</button>
                    <button class="nav-btn next-btn" disabled>{{ __('next_button') }}</button>
                </div>
            </div>

            <!-- STEP 3: Back Image Upload (Only for ID Card) -->
            <div class="form-step" data-step="2">
                <h2 id="step-3-title">{{ __('back_id_verify_heading') }}</h2>
                <p id="step-3-desc">{{ __('back_id_verify_message') }}</p>
                <div class="progress-indicator" id="progress-step-2">
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                    <div class="progress-step active"></div>
                </div>
                <label for="back-id-input" class="upload-area" id="back-upload-area">
                    <div class="upload-content">
                        <img src="{{ asset('assets/web/id_card.png') }}" class="id-frame-overlay" alt="ID Card Placeholder">
                    </div>
                </label>
                <input type="file" id="back-id-input" accept="image/*">
                <div class="button-group">
                    <button class="nav-btn back-btn">{{ __('back_button') }}</button>
                    <button class="nav-btn next-btn" disabled>{{ __('next_button') }}</button>
                </div>
            </div>

            <!-- STEP 4: Confirmation -->
            <div class="form-step" data-step="3">
                <h2 id="confirmation-title">{{ __('confirm_verify_heading') }}</h2>
                <div class="confirmation-previews" id="confirmation-previews">
                    <div class="preview-container" id="front-preview-container">
                        <div class="preview-label" id="front-preview-label">{{ __('front') }}</div>
                        <div class="preview-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                        </div>
                        <img id="front-preview-img" src="{{ asset('assets/web/id_card.png') }}" alt="Front ID Preview">
                    </div>
                    <div class="preview-container" id="back-preview-container">
                        <div class="preview-label">{{ __('back') }}</div>
                        <div class="preview-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                        </div>
                        <img id="back-preview-img" src="{{ asset('assets/web/id_card.png') }}" alt="Back ID Preview">
                    </div>
                </div>
                <div class="button-group">
                    <button class="nav-btn back-btn">{{ __('back') }}</button>
                    <button class="nav-btn next-btn">{{ __('confirm_button') }}</button>
                </div>
            </div>

        </div>
    </div>

    <!-- SUCCESS MODAL HTML -->
    <div class="modal-overlay" id="success-modal">
        <div class="modal-content success-modal-content">
            <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">
            <h2>{{ __('verify_success_heading') }}</h2>
            <p>{{ __('verify_success_message') }}</p>
            <button class="success-modal-btn" id="done-btn">{{ __('left_continue') }}</button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.verification-flow-container');
            const nextBtns = document.querySelectorAll('.next-btn');
            const backBtns = document.querySelectorAll('.back-btn');
            const options = document.querySelectorAll('.verification-option');
            const steps = document.querySelectorAll('.form-step');
            const successModal = document.getElementById('success-modal');
            const doneBtn = document.getElementById('done-btn');

            const totalSteps = 4;
            let currentStep = 0;
            let selectedDocType = 'id';

            let idCardUrl = "{{ asset('assets/web/id_card.png') }}";
            let frontIdDataUrl = idCardUrl;
            let backIdDataUrl = idCardUrl;







            const updateDynamicContent = () => {
                const step2Title = document.getElementById('step-2-title');
                const step2Desc = document.getElementById('step-2-desc');
                const step2Placeholder = document.getElementById('step-2-placeholder-img');
                const confirmationTitle = document.getElementById('confirmation-title');
                const backPreviewContainer = document.getElementById('back-preview-container');
                const frontPreviewLabel = document.getElementById('front-preview-label');
                const confirmationPreviews = document.getElementById('confirmation-previews');

                const progressStep0 = document.getElementById('progress-step-0');
                const progressStep1 = document.getElementById('progress-step-1');
                const progressStep2 = document.getElementById('progress-step-2');

                const three_steps_1_active =
                    '<div class="progress-step active"></div><div class="progress-step"></div><div class="progress-step"></div>';
                const three_steps_2_active =
                    '<div class="progress-step active"></div><div class="progress-step active"></div><div class="progress-step"></div>';
                const three_steps_3_active =
                    '<div class="progress-step active"></div><div class="progress-step active"></div><div class="progress-step active"></div>';

                const two_steps_1_active =
                    '<div class="progress-step active"></div><div class="progress-step"></div>';
                const two_steps_2_active =
                    '<div class="progress-step active"></div><div class="progress-step active"></div>';

                if (selectedDocType === 'id') {
                    step2Title.textContent = '{{ __('front_id_verify_heading') }}';
                    step2Desc.textContent = '{{ __('front_id_verify_message') }}';
                    step2Placeholder.src = "{{ asset('assets/web/id_card.png') }}";
                    confirmationTitle.textContent = '{{ __('confirm_verify_heading') }}';
                    frontPreviewLabel.textContent = '{{ __('front') }}';
                    backPreviewContainer.style.display = '';
                    confirmationPreviews.classList.remove('single');

                    progressStep0.innerHTML = three_steps_1_active;
                    progressStep1.innerHTML = three_steps_2_active;
                    progressStep2.innerHTML = three_steps_3_active;

                } else if (selectedDocType === 'passport') {
                    step2Title.textContent = '{{ __('passport_verify_heading') }}';
                    step2Desc.textContent = '{{ __('passport_verify_message') }}';
                    step2Placeholder.src = "{{ asset('assets/web/passport_icon.png') }}";
                    confirmationTitle.textContent = '{{ __('passport_confirm_heading') }}';
                    frontPreviewLabel.textContent = '{{ __('passport_image') }}';
                    backPreviewContainer.style.display = 'none';
                    confirmationPreviews.classList.add('single');

                    progressStep0.innerHTML = two_steps_1_active;
                    progressStep1.innerHTML = two_steps_2_active;

                } else if (selectedDocType === 'license') {
                    step2Title.textContent = '{{ __('tattoo_verify_heading') }}';
                    step2Desc.textContent = '{{ __('tattoo_verify_message') }}';
                    step2Placeholder.src = "{{ asset('assets/web/tatto_license_icon.png') }}";
                    confirmationTitle.textContent = '{{ __('tattoo_confirm_heading') }}';
                    frontPreviewLabel.textContent = '{{ __('tattoo_image') }}';
                    backPreviewContainer.style.display = 'none';
                    confirmationPreviews.classList.add('single');

                    progressStep0.innerHTML = two_steps_1_active;
                    progressStep1.innerHTML = two_steps_2_active;
                }
            };


            const adjustContainerHeight = () => {
                const activeStepElement = document.querySelector('.form-step.active');
                if (activeStepElement) {
                    container.style.height = activeStepElement.scrollHeight + 'px';
                }
            };

            const goToStep = (step) => {
                const previousStep = currentStep;
                currentStep = Math.max(0, Math.min(step, totalSteps - 1));

                steps.forEach((stepEl) => {
                    stepEl.classList.remove('active');
                });
                const newActiveStep = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                if (newActiveStep) newActiveStep.classList.add('active');


                const isGoingToWideStep = (currentStep === 3);
                container.classList.toggle('narrow', !isGoingToWideStep);

                updateDynamicContent();

                const delay = (isGoingToWideStep && previousStep !== currentStep) ? 300 : 0;
                setTimeout(adjustContainerHeight, delay);
            };

            setTimeout(adjustContainerHeight, 100);

            nextBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    let nextStep = currentStep + 1;

                    if (currentStep === 1 && (selectedDocType === 'passport' || selectedDocType ===
                            'license')) {
                        nextStep = 3;
                    }

                    if (currentStep === 2) {
                        document.getElementById('front-preview-img').src = frontIdDataUrl;
                        document.getElementById('back-preview-img').src = backIdDataUrl;
                    }

                    if (currentStep === 1 && (selectedDocType === 'passport' || selectedDocType ===
                            'license')) {
                        document.getElementById('front-preview-img').src = frontIdDataUrl;
                    }

                    if (currentStep === 3) {
                        container.classList.add('blur-background');
                        successModal.classList.add('active');
                        return;
                    }

                    if (currentStep < totalSteps - 1) {
                        goToStep(nextStep);
                    }
                });
            });

            backBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    let prevStep = currentStep - 1;

                    if (currentStep === 3 && (selectedDocType === 'passport' || selectedDocType ===
                            'license')) {
                        prevStep = 1;
                    }

                    if (currentStep > 0) {
                        goToStep(prevStep);
                    }
                });
            });

            doneBtn.addEventListener('click', () => {
                window.location.href = 'dashboard/explore';
            });

            options.forEach(option => {
                option.addEventListener('click', () => {
                    options.forEach(opt => opt.classList.remove('active'));
                    option.classList.add('active');
                    selectedDocType = option.getAttribute('data-value');
                    updateDynamicContent();
                    setTimeout(adjustContainerHeight, 0);
                });
            });

            const setupUpload = (inputId, areaId, nextButtonSelector) => {
                const input = document.getElementById(inputId);
                const area = document.getElementById(areaId);
                const nextBtn = area.closest('.form-step').querySelector(nextButtonSelector);

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            const dataUrl = event.target.result;
                            area.style.backgroundImage = `url('${dataUrl}')`;
                            area.classList.add('has-image');
                            if (nextBtn) nextBtn.disabled = false;

                            if (inputId === 'front-id-input') {
                                frontIdDataUrl = dataUrl;
                            } else if (inputId === 'back-id-input') {
                                backIdDataUrl = dataUrl;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            };

            setupUpload('front-id-input', 'front-upload-area', '.next-btn');
            setupUpload('back-id-input', 'back-upload-area', '.next-btn');

            window.addEventListener('resize', adjustContainerHeight);
        });

        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>

</body>

</html>
