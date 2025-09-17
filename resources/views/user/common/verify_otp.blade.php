    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            /* Base CSS from your other pages for consistency */
            body {
                margin: 0;
                padding: 0;
                background-color: #e6f4f0;
                font-family: 'Poppins', sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                opacity: 0;
                transition: opacity 0.8s ease;
            }

            @font-face {
                font-family: 'Arial Rounded MT Bold';
                src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            .container {
                display: flex;
                max-width: 1000px;
                width: 100%;
                box-sizing: border-box;
            }

            .left {
                flex: 1;
                text-align: center;
                padding: 40px;
                color: #32423b;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .left img {
                width: 190px;
                margin-left: -300px;
            }

            .subtitle {
                font-size: 28px;
                margin-top: 30px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                font-weight: 500;
                margin-left: -300px;
            }

            .left p {
                font-size: 14px;
                max-width: 470px;
                margin-top: 8px;
                line-height: 1.5;
                margin-left: -300px;
                font-family: 'Vector', sans-serif;
            }

            .right {
                background: white;
                padding: 40px 30px;
                border-radius: 25px;
                flex: 1;
                max-width: 480px;
                display: flex;
                flex-direction: column;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                margin-right: -150px;
            }

            .right h2 {
                text-align: center;
                font-size: 28px;
                color: #014122;
                margin-bottom: 0;
                font-weight: 500;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: -5px;
            }

            .instruction-text {
                font-size: 14px;
                color: #333333;
                text-align: center;
                line-height: 1.5;
                margin-bottom: 30px;
                /*max-width: 370px;*/
                margin-left: auto;
                margin-right: auto;
                font-family: 'Actor', sans-serif;
            }

            form {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* === NEW OTP STYLES FROM YOUR REFERENCE CODE === */
            .otp-inputs {
                display: flex;
                justify-content: center;
                gap: 10px;
                /* Adjusted gap slightly for better fit */
                margin-bottom: 25px;
                width: 100%;
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
                color: #333333;
                font-family: 'Poppins', sans-serif;
                /* Keep consistent font */
            }

            .otp-inputs input.filled {
                border-color: #336a44;
                /* Green border when filled */
            }

            .otp-inputs input:focus {
                background: #E5F8F2;
                /* Light mint background on focus */
                border-color: #0b3d27;
                /* Dark green border on focus */
                color: #014122;
            }

            /* ================================================= */

            .continue-btn {
                width: 100%;
                padding: 16px;
                background: #014122;
                color: white;
                border: none;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            .resend-otp {
                font-size: 13px;
                text-align: center;
                color: #6c757d;
                margin-top: 25px;
            }

            .resend-otp a {
                color: #014122;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;
            }

            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                    align-items: center;
                }

                .right {
                    max-width: 95%;
                }

                .otp-inputs input {
                    width: 60px;
                    height: 75px;
                }

                /* Adjust for smaller screens */
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="left">
                <img src="{{ asset('assets/web/guestly-logo.png') }}" alt="Guestly Logo">
                <div class="subtitle">{{ __('left_heading') }}</div>
                <p>{{ __('left_description') }}</p>
            </div>
            <div class="right">
                <h2>{{ __('otp_heading') }}</h2>
                <p class="instruction-text">
                    {{ __('otp_message') }}
                </p>
                <form>
                    <div class="otp-inputs">
                        <input type="text" maxlength="1" required>
                        <input type="text" maxlength="1" required>
                        <input type="text" maxlength="1" required>
                        <input type="text" maxlength="1" required>
                    </div>
                    <button type="submit"
                        onclick="window.location.href='{{ route('reset_password', ['role' => request('role', 'artist')]) }}'"
                        class="continue-btn">{{ __('confirm_button') }}</button>
                </form>
                <p class="resend-otp">{{ __('otp_not_receive') }} <a>{{ __('otp_resend') }}</a></p>
            </div>
        </div>
        <script>
            window.addEventListener('load', () => {
                document.body.style.opacity = 1;
            });

            // Updated JS to handle the .filled class
            const otpInputs = document.querySelectorAll('.otp-inputs input');
            if (otpInputs.length > 0) {
                otpInputs[0].focus(); // Automatically focus on the first box
            }

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    // Only allow numbers
                    input.value = input.value.replace(/[^0-9]/g, '');

                    // Add or remove the 'filled' class
                    if (input.value) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }

                    // Move to the next input
                    if (input.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                        // Remove filled class from the previous input before focusing
                        otpInputs[index - 1].classList.remove('filled');
                        otpInputs[index - 1].focus();
                    }
                });
            });
        </script>
    </body>

    </html>
