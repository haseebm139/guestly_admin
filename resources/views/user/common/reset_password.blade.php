    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">
        <link
            href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@600;800&family=Poppins:wght@400;500&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            /* Consistent CSS */
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

            .container.blur-background {
                filter: blur(5px);
                transition: filter 0.3s ease-in-out;
                pointer-events: none;
                /* Taake user blurred background par click na kar sake */
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
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .form-group {
                position: relative;
                flex: 1;
            }

            .form-group label {
                position: absolute;
                top: 7px;
                left: 13px;
                font-size: 12px;
                color: #5E8082;
                pointer-events: none;
            }

            .form-group input {
                width: 100%;
                padding: 26px 12px 8px 12px;
                border: 1px solid #5E8082;
                border-radius: 8px;
                font-size: 15px;
                box-sizing: border-box;
                background: none;
                outline: none;
                font-family: 'Poppins', sans-serif;
                color: #333;
                transition: border-color 0.2s ease;
            }

            .form-group input::placeholder {
                color: #adb5bd;
            }

            .form-group input:focus {
                border-color: #014122;
                box-shadow: 0 0 0 2px rgba(1, 65, 34, 0.15);
            }

            .toggle-password {
                position: absolute;
                top: 55%;
                right: 12px;
                transform: translateY(-50%);
                cursor: pointer;
                color: #6c757d;
                font-size: 16px;
            }

            .continue-btn {
                width: 100%;
                padding: 18px;
                background: #014122;
                color: white;
                border: none;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: 10px;
            }

            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                    align-items: center;
                }

                .right {
                    max-width: 95%;
                }
            }

            /* ✅ MODAL CSS FROM YOUR REFERENCE FILE */
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
            input.error {
                border: 1px solid red !important;
                /* red border */
            }

            label.error {
                color: red;
                font-size: 10px;
                margin-top: auto;
                display: block;
                width: 100%;
                /* label ka width input ke barabar */
                text-align: center;
                /* text center align */
            }

            /* Style for the input fields when they have an error */
            input.error,
            select.error {
                border: 1px solid red !important;
            }

            /* Style for the entire group container when there is an error */
            .input-group-connected.error-group {
                border: 1px solid red !important;
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
                <h2>{{ __('set_password_heading') }}</h2>
                <p class="instruction-text">
                    {{ __('set_password_message') }}
                </p>



                @if ($errors->has('password'))
                    <div style="color:red; text-align:center; margin-bottom:10px;">
                        {{ $errors->first('password') }}
                    </div>
                @endif

                <form method="POST" id="resetForm" action="{{ route('reset_password_submit') }}">
                    @csrf

                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <input type="hidden" name="role" value="{{ request('role', 'artist') }}">

                    <div class="form-group">
                        <label>{{ __('new_password') }}</label>
                        <input type="password" name="password" id="new-password" placeholder="{{ __('enter_new_password') }}" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="new-password"></i>
                    </div>

                    <div class="form-group">
                        <label>{{ __('confirm_password') }}</label>
                        <input type="password" name="password_confirmation" id="confirm-password"
                               placeholder="{{ __('confirm_new_password') }}" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="confirm-password"></i>
                    </div>

                    <button type="submit" class="continue-btn">{{ __('updated_password_button') }}</button>
                </form>

            </div>
        </div>

        <!-- ✅ SUCCESS MODAL HTML FROM YOUR REFERENCE FILE -->
        <div class="modal-overlay" id="success-modal">
            <div class="modal-content success-modal-content">
                <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">
                <!-- Changed heading and text for this context -->
                <h2>{{ __('modal_password_updated') }}</h2>
                <p>{{ __('modal_password_message') }}</p>
                <button class="success-modal-btn" id="done-btn">{{ __('modal_password_login') }}</button>
            </div>
        </div>

        <script>
            // Initial page load fade
            window.addEventListener('load', () => {
                document.body.style.opacity = 1;
            });



        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function () {
                // ✅ Toggle eye icon
                $('.toggle-password').on('click', function () {
                    let target = $('#' + $(this).data('target'));
                    if (target.attr('type') === 'password') {
                        target.attr('type', 'text');
                        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        target.attr('type', 'password');
                        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

                // ✅ Password validation
                $('#resetForm').validate({
                    rules: {
                        password: {
                            required: true,
                            minlength: 8
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: "#new-password"
                        }
                    },
                    messages: {
                        password: {
                            required: "Please enter a new password",
                            minlength: "Password must be at least 6 characters"
                        },
                        password_confirmation: {
                            required: "Please confirm your new password",
                            equalTo: "Passwords do not match"
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element);
                    }
                });
            });
        </script>
    </body>

    </html>
