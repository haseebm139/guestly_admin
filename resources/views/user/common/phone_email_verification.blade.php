    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
            rel="stylesheet" />
        <style>
            :root {
                --bg-color: #e6f4f0;
                --primary-green: #0b3d27;
                --text-primary: #0b3d27;
                --text-secondary: #5d7a70;
            }

            @font-face {
                font-family: 'Arial Rounded MT Bold';
                src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            body {
                margin: 0;
                background: var(--bg-color);
                font-family: "Poppins", sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                opacity: 0;
                /* ✅ Start hidden */
                transition: opacity 0.8s ease;
                /* ✅ Smooth fade-in */
            }

            .otp-container {
                background: white;
                padding: 30px;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 100%;
                max-width: 400px;
                position: relative;
                z-index: 1;
            }

            .otp-container h2 {
                margin-top: 0;
                font-size: 25px;
                color: #014122;
                font-weight: 500;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                /* ✅ Use custom font */
            }

            .otp-container p {
                font-size: 14px;
                color: #333333;
                margin-bottom: 16px;
                font-family: 'Actor', sans-serif;
                max-width: 310px;
                margin-left: 42px;
                margin-top: -11px;
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

            .otp-inputs input.filled {
                border-color: #336a44;
            }

            .otp-inputs input:focus {
                background: #E5F8F2;
                border-color: var(--primary-green);
                color: #014122;
            }

            .confirm-btn {
                background: #014122;
                color: white;
                border: none;
                border-radius: 50px;
                padding: 14px;
                width: 100%;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.3s;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            /*.confirm-btn:hover {*/
            /*    background: #014122;*/
            /*}*/

            /* ✅ Modal CSS */
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
                background-color: #014122;
                color: white;
                border: none;
                border-radius: 50px;
                padding: 15px;
                width: 100%;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                font-family: 'Arial Rounded MT Bold', sans-serif;
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
        </style>
    </head>

    <body>

        <div class="otp-container">
            <h2>{{ __('otp_heading') }}</h2>
            <p id="otp-text">Please enter the four digit OTP code we sent to your registered phone number ***</p>

            <div class="otp-inputs">
                <input type="text" maxlength="1" />
                <input type="text" maxlength="1" />
                <input type="text" maxlength="1" />
                <input type="text" maxlength="1" />
            </div>

            <button class="confirm-btn" id="confirmBtn">{{ __('confirm_button') }}</button>
            <p class="resend-otp">{{ __('otp_not_receive') }} <a>{{ __('otp_resend') }}</a></p>

        </div>

        <!-- ✅ SUCCESS MODAL HTML -->
        <div class="modal-overlay" id="success-modal">
            <div class="modal-content success-modal-content">
                <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">
                <h2>{{ __('verify_success_heading') }}</h2>
                <p>{{ __('verify_success_message') }}</p>
                <button class="success-modal-btn" id="done-btn">{{ __('left_continue') }}</button>
            </div>
        </div>

        <script>
            // ✅ URL se query parameter nikaalna
            const urlParams = new URLSearchParams(window.location.search);
            const verificationType = urlParams.get("type"); // phone | email

            const otpText = document.getElementById('otp-text');
            const confirmBtn = document.getElementById('confirmBtn');
            const successModal = document.getElementById('success-modal');
            const doneBtn = document.getElementById('done-btn');

            if (verificationType === 'phone') {
                otpText.innerText = '{{ __('phone_otp_message') }}';
            } else if (verificationType === 'email') {
                otpText.innerText = '{{ __('otp_message') }}';
            } else {
                otpText.innerText = 'Please enter the OTP code we sent to your registered contact.';
            }

            const inputs = document.querySelectorAll('.otp-inputs input');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^0-9]/g, '');
                    if (input.value.length === 1) {
                        input.classList.add('filled');
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    } else {
                        input.classList.remove('filled');
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (input.value === '') {
                            input.classList.remove('filled');
                            if (index > 0) {
                                inputs[index - 1].focus();
                            }
                        } else {
                            input.value = '';
                            input.classList.remove('filled');
                        }
                        e.preventDefault();
                    } else if (!e.key.match(/[0-9]/) && !['Tab', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                        e.preventDefault();
                    }
                });
            });

            // ✅ Confirm button shows modal
            confirmBtn.addEventListener('click', () => {
                document.querySelector('.otp-container').classList.add('blur-background');
                successModal.classList.add('active');
            });

            doneBtn.addEventListener('click', () => {
                window.location.href = 'dashboard/explore'; // replace with your redirect page
            });
        </script>

        <script>
            window.addEventListener("load", () => {
                document.body.style.opacity = 1;
            });
        </script>

    </body>

    </html>
