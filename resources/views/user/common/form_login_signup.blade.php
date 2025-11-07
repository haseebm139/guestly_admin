    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">

        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@600;800&family=Poppins:wght@400;500&display=swap"
            rel="stylesheet">

        <!-- Font Awesome for eye icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
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
                /* Start hidden */
                transition: opacity 0.8s ease;
                /* Smooth fade-in for initial page load */
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
                padding: 30px;
                border-radius: 25px;
                flex: 1;
                max-width: 480px;
                display: flex;
                flex-direction: column;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                margin-right: -150px;
                /* ===> CHANGE: ADDED TRANSITION FOR SMOOTH FADE <=== */
                transition: opacity 0.4s ease-in-out;
            }

            #login-form-container,
            #signup-form-container {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .right h2 {
                text-align: center;
                font-size: 28px;
                color: #32423b;
                margin-bottom: 22px;
                font-weight: 500;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: -5px;
            }

            .right h2 .guestly-text {
                color: #014122;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .form-row {
                display: flex;
                gap: 15px;
            }

            .form-group {
                position: relative;
                flex: 1;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 26px 12px 8px 12px;
                border: 1px solid #5E8082;
                border-radius: 8px;
                font-size: 15px;
                box-sizing: border-box;
                background: none;
                outline: none;
                font-family: 'Actor', sans-serif;
                color: #333;
                transition: border-color 0.2s ease;
            }

            .form-group input::placeholder {
                color: #adb5bd;
            }

            .form-group label {
                position: absolute;
                top: 7px;
                left: 13px;
                font-size: 12px;
                color: #5E8082;
                pointer-events: none;
                font-family: 'Actor', sans-serif;
            }

            /*.label_phone {*/
            /*    color: red;*/
            /*    top: 50%;*/
            /*    font-size: 12px;*/
            /*    margin-top: 5px;*/
            /*    display: block;*/
            /*    width: 100%;*/
            /*    text-align: center;*/
            /*}*/
            .label_phone {
                position: absolute;
                left: 410px;
                top: 56%;
                /* input ke bilkul neeche */
                color: red;
                font-size: 12px;
                margin-top: 2px;
                /* thoda gap */
                width: 100%;
                text-align: center;
                pointer-events: none;
            }

            .form-group input:focus,
            .form-group select:focus {
                border-color: #014122;
                box-shadow: 0 0 0 2px rgba(1, 65, 34, 0.15);
            }

            .input-group-connected {
                border: 1px solid #5E8082;
                border-radius: 8px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .input-group-connected:focus-within {
                border-color: #014122;
                box-shadow: 0 0 0 2px rgba(1, 65, 34, 0.15);
            }

            .input-group-connected .form-group {
                margin: 0;
            }

            .input-group-connected .form-group input,
            .input-group-connected .form-group select {
                border: none;
                border-radius: 0;
                box-shadow: none;
            }

            .input-group-connected .form-group:first-child {
                border-bottom: 1px solid #5E8082;
            }

            .form-group select {
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 16px 12px;
                cursor: pointer;
            }

            .helper-text {
                font-size: 13px;
                color: #333333;
                text-align: center;
                line-height: 1.4;
                margin: -5px 0 10px;
                font-family: 'Actor', sans-serif;
            }

            .forgot-password {
                text-align: right;
                margin-top: -10px;
                margin-bottom: 15px;
            }

            .forgot-password a {
                color: #014122;
                font-size: 13px;
                text-decoration: none;
                font-weight: 500;
            }

            .forgot-password a:hover {
                text-decoration: underline;
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
            }

            .divider {
                display: flex;
                align-items: center;
                text-align: center;
                color: #333333;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin: 20px 0;
                font-size: 12px;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #D3D3D3;
            }

            .divider:not(:empty)::before {
                margin-right: 2.5em;
            }

            .divider:not(:empty)::after {
                margin-left: 2.5em;
            }

            .social-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                padding: 12px;
                border: 1px solid #0b3d27;
                border-radius: 50px;
                background-color: #E5F8F2;
                color: #32423b;
                font-size: 14px;
                font-weight: 500;
                margin-bottom: 10px;
                cursor: pointer;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            .social-btn img {
                width: 18px;
                height: 18px;
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

            .toggle-form-text {
                text-align: center;
                margin-top: 20px;
                font-size: 14px;
                color: #333;
            }

            .toggle-form-text a {
                color: #014122;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;
            }

            .toggle-form-text a:hover {
                text-decoration: underline;
            }

            select:invalid {
                color: gray;
            }

            select option {
                color: black;
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

            /* Target the container to ensure its text is centered */
            #phone-group-error-container {
                text-align: center;
                width: 100%;
            }
                 /* ✅ Success Message */
             .alert-success {
                 background-color: #d4edda;  /* light green */
                 color: #155724;             /* dark green text */
                 border: 1px solid #c3e6cb;  /* green border */
                 padding: 12px 20px;
                 border-radius: 6px;
                 margin: 10px 0;
                 font-size: 14px;
             }

            /* ✅ Error Message */
            .alert-danger {
                background-color: #f8d7da;  /* light red */
                color: #721c24;             /* dark red text */
                border: 1px solid #f5c6cb;  /* red border */
                padding: 12px 20px;
                border-radius: 6px;
                margin: 10px 0;
                font-size: 14px;
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
                <!-- LOGIN FORM -->
                <div id="login-form-container">
                    <h2>{{ __('right_login_as') }} <span class="guestly-text">{{ __('right_login') }}</span></h2>
                    @if ($errors->any())
                        <div style="color: red; margin-bottom: 10px; text-align: center;">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success flash-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger flash-message">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf {{-- CSRF Token zaroori hai --}}

                        {{-- Hidden input for role --}}
                        <input type="hidden" name="role" value="{{ request('role', 'artist') }}">
                        <input type="hidden" name="latitude" class="latitude">
                        <input type="hidden" name="longitude" class="longitude">
                        <div class="form-group">
                            <label>{{ __('email') }}</label>
                            <input type="email" name="email" placeholder="{{ __('enter_email') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('password') }}</label>
                            <input type="password" id="login-password" name="password"
                                placeholder="{{ __('enter_password') }}" required>
                            <i class="fa-solid fa-eye toggle-password" id="toggle-login-password"></i>
                        </div>
                        <div class="forgot-password">
                            <a href="{{ url('forgot_password') }}?role={{ request('role', 'artist') }}">
                                {{ __('forget_password') }}
                            </a>
                        </div>
                        <button type="submit" class="continue-btn">{{ __('login') }}</button>
                    </form>

                    <div class="divider">{{ __('or') }}</div>
                    <button class="social-btn"><img
                            src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                            alt="Google"> {{ __('Continue_with_google') }}</button>
                    <button class="social-btn"><img
                            src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg"
                            alt="Facebook"> {{ __('Continue_with_facebook') }}</button>
                    <button class="social-btn"><img
                            src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg"
                            alt="Apple"> {{ __('Continue_with_apple') }}</button>
                    <p class="toggle-form-text">{{ __('dont_have_account') }} <a
                            id="show-signup-link">{{ __('signUp') }}</a></p>
                </div>

                <!-- SIGNUP FORM -->
                <div id="signup-form-container" style="display: none;">
                    <h2>{{ __('right_signing_as') }}<span class="guestly-text"> {{ __('right_login') }}</span></h2>

                    <form id="signupForm" method="POST"
                        action="{{ route('signup', ['role' => request('role', 'artist')]) }}">
                        @csrf
                        <input type="hidden" name="latitude" class="latitude">
                        <input type="hidden" name="longitude" class="longitude">

                        <div class="form-row">
                            <div class="form-group">
                                <label>{{ __('first_name') }}</label>
                                <input type="text" name="first_name" placeholder="{{ __('enter_first_name') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('last_name') }}</label>
                                <input type="text" name="last_name" placeholder="{{ __('enter_last_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('email') }}</label>
                            <input type="email" name="email" placeholder="{{ __('enter_email') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('password') }}</label>
                            <input type="password" id="signup-password" name="password"
                                placeholder="{{ __('enter_password') }}">
                            <i class="fa-solid fa-eye toggle-password" id="toggle-signup-password"></i>
                        </div>
                        <div class="input-group-connected">
                            <div class="form-group">
                                <label>{{ __('country_region') }}</label>
                                <select id="country_region" name="country_region">
                                    <option value="" disabled selected style="color: gray;">
                                        {{ __('enter_country_region') }}
                                    </option>
                                    <option value="us" data-code="+1">United States (+1)</option>
                                    <option value="ca" data-code="+1">Canada (+1)</option>
                                    <option value="gb" data-code="+44">United Kingdom (+44)</option>
                                    <option value="pk" data-code="+92">Pakistan (+92)</option>
                                    <option value="in" data-code="+91">India (+91)</option>
                                    <option value="bd" data-code="+880">Bangladesh (+880)</option>
                                    <option value="ae" data-code="+971">United Arab Emirates (+971)</option>
                                    <option value="sa" data-code="+966">Saudi Arabia (+966)</option>
                                    <option value="qa" data-code="+974">Qatar (+974)</option>
                                    <option value="om" data-code="+968">Oman (+968)</option>
                                    <option value="kw" data-code="+965">Kuwait (+965)</option>
                                    <option value="bh" data-code="+973">Bahrain (+973)</option>
                                    <option value="af" data-code="+93">Afghanistan (+93)</option>
                                    <option value="au" data-code="+61">Australia (+61)</option>
                                    <option value="nz" data-code="+64">New Zealand (+64)</option>
                                    <option value="sg" data-code="+65">Singapore (+65)</option>
                                    <option value="my" data-code="+60">Malaysia (+60)</option>
                                    <option value="id" data-code="+62">Indonesia (+62)</option>
                                    <option value="ph" data-code="+63">Philippines (+63)</option>
                                    <option value="cn" data-code="+86">China (+86)</option>
                                    <option value="jp" data-code="+81">Japan (+81)</option>
                                    <option value="kr" data-code="+82">South Korea (+82)</option>
                                    <option value="de" data-code="+49">Germany (+49)</option>
                                    <option value="fr" data-code="+33">France (+33)</option>
                                    <option value="it" data-code="+39">Italy (+39)</option>
                                    <option value="es" data-code="+34">Spain (+34)</option>
                                    <option value="tr" data-code="+90">Turkey (+90)</option>
                                    <option value="za" data-code="+27">South Africa (+27)</option>
                                    <option value="ng" data-code="+234">Nigeria (+234)</option>
                                    <option value="ke" data-code="+254">Kenya (+254)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('phone_number') }}</label>
                                <input type="text" id="phone_number" name="phone_number"
                                       placeholder="{{ __('enter_phone_number') }}">
                            </div>
                        </div>

                        <script>
                            const countrySelect = document.getElementById('country_region');
                            const phoneInput = document.getElementById('phone_number');

                            countrySelect.addEventListener('change', function () {
                                const selected = this.options[this.selectedIndex];
                                const code = selected.getAttribute('data-code');
                                if (code) {
                                    phoneInput.value = code + " "; // code auto-insert
                                    phoneInput.focus();
                                }
                            });
                        </script>

                        <!-- This is the new container for the combined error message -->
                        <div id="phone-group-error-container"></div>

                        <p class="helper-text">{{ __('right_otp_message') }}</p>
                        <button type="submit" class="continue-btn">{{ __('left_continue') }}</button>
                    </form>
                    <p class="toggle-form-text">{{ __('already_have_account') }} <a
                            id="show-login-link">{{ __('login') }}</a></p>
                </div>
            </div>
        </div>

        <script>
            // Fade in body on load
            window.addEventListener('load', () => {
                document.body.style.opacity = 1;
            });

            // ===> UPDATED JAVASCRIPT FOR SMOOTH TOGGLING <===
            const rightContainer = document.querySelector('.right');
            const loginFormContainer = document.getElementById('login-form-container');
            const signupFormContainer = document.getElementById('signup-form-container');
            const showSignupLink = document.getElementById('show-signup-link');
            const showLoginLink = document.getElementById('show-login-link');

            // Reusable function to switch forms with a fade effect
            function switchForms(formToHide, formToShow) {
                // 1. Start the fade-out of the right container
                rightContainer.style.opacity = '0';

                // 2. Wait for the fade-out to finish (400ms matches CSS transition)
                setTimeout(() => {
                    // 3. Switch the visibility of the actual form divs
                    formToHide.style.display = 'none';
                    formToShow.style.display = 'flex';

                    // 4. Start the fade-in for the new form
                    rightContainer.style.opacity = '1';
                }, 250);
            }

            // Event listener for the "Sign up" link
            showSignupLink.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent the link's default behavior
                switchForms(loginFormContainer, signupFormContainer);
            });

            // Event listener for the "Log in" link
            showLoginLink.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent the link's default behavior
                switchForms(signupFormContainer, loginFormContainer);
            });


            // SCRIPT FOR PASSWORD VISIBILITY TOGGLE (Your original code, no changes)
            function setupPasswordToggle(passwordFieldId, toggleIconId) {
                const password = document.getElementById(passwordFieldId);
                const togglePassword = document.getElementById(toggleIconId);

                if (togglePassword) {
                    togglePassword.addEventListener('click', function() {
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                }
            }
            setupPasswordToggle('login-password', 'toggle-login-password');
            setupPasswordToggle('signup-password', 'toggle-signup-password');

            // SCRIPT FOR CONTINUE BUTTON (Your original code, no changes)
            // document.addEventListener("DOMContentLoaded", function () {
            //     const params = new URLSearchParams(window.location.search);
            //     const role = params.get('role');
            //
            //     const continueBtn = document.querySelector('#signup-form-container .continue-btn');
            //     if (continueBtn) {
            //         continueBtn.addEventListener('click', function (e) {
            //             e.preventDefault();
            //             let url = 'choose_plan';
            //             if (role) {
            //                 url += '?role=' + role;
            //             }
            //             window.location.href = url;
            //         });
            //     }
            // });
        </script>
{{--        <script>--}}
{{--            document.addEventListener('DOMContentLoaded', () => {--}}
{{--                if (navigator.geolocation) {--}}
{{--                    navigator.geolocation.getCurrentPosition(--}}
{{--                        function(position) {--}}
{{--                            // Latitude aur Longitude set karein hidden fields mein--}}
{{--                            document.getElementById('latitude').value = position.coords.latitude;--}}
{{--                            document.getElementById('longitude').value = position.coords.longitude;--}}
{{--                        },--}}
{{--                        function(error) {--}}
{{--                            console.error('Error getting location:', error);--}}
{{--                        }--}}
{{--                    );--}}
{{--                } else {--}}
{{--                    console.warn('Geolocation is not supported by this browser.');--}}
{{--                }--}}
{{--            });--}}
{{--        </script>--}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            // Sab latitude fields fill karo
                            document.querySelectorAll('.latitude').forEach(el => {
                                el.value = position.coords.latitude;
                            });
                            // Sab longitude fields fill karo
                            document.querySelectorAll('.longitude').forEach(el => {
                                el.value = position.coords.longitude;
                            });
                        },
                        function(error) {
                            console.error('Error getting location:', error);
                        }
                    );
                } else {
                    console.warn('Geolocation is not supported by this browser.');
                }
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#loginForm').validate({
                    rules: {

                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        }
                    },
                    messages: {

                        email: {
                            required: "Email is required",
                            email: "Enter a valid email"
                        },
                        password: {
                            required: "Password is required",
                            minlength: "Password must be at least 6 characters"
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element); // place error below input
                    },
                    highlight: function(element) {
                        $(element).addClass('error'); // red border on error
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('error'); // remove red border if valid
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {

                $('input[name="phone_number"]').on('keypress', function(e) {
                    var charCode = e.which ? e.which : e.keyCode;
                    if (charCode < 48 || charCode > 57) {
                        e.preventDefault();
                    }
                });

                $('#signupForm').validate({
                    // Define a group for country and phone number
                    groups: {
                        phoneGroup: "country_region phone_number"
                    },
                    rules: {
                        first_name: {
                            required: true
                        },
                        last_name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        },
                        country_region: {
                            required: true
                        },
                        phone_number: {
                            required: true
                        }
                    },
                    messages: {
                        first_name: "First name is required",
                        last_name: "Last name is required",
                        email: "Email is required",
                        password: "Password is required",
                        // The plugin will show only one of these messages for the group
                        country_region: "This field is required",
                        phone_number: "Phone number is required"
                    },
                    // This function now places the single group error in our new container
                    errorPlacement: function(error, element) {
                        if (element.attr("name") === "country_region" || element.attr("name") ===
                            "phone_number") {
                            error.appendTo("#phone-group-error-container");
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        var $element = $(element);
                        $element.addClass(errorClass).removeClass(validClass);
                        // Highlight the entire group container
                        if ($element.closest('.input-group-connected').length) {
                            $element.closest('.input-group-connected').addClass('error-group');
                        }
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        var $element = $(element);
                        $element.removeClass(errorClass).addClass(validClass);
                        // Un-highlight the group container only if both fields are valid
                        if ($element.closest('.input-group-connected').length) {
                            var $group = $element.closest('.input-group-connected');
                            if ($group.find('select.error, input.error').length === 0) {
                                $group.removeClass('error-group');
                            }
                        }
                    }
                });
            });
        </script>
        <script>
            const countrySelect = document.getElementById('country_region');
            const phoneInput = document.getElementById('phone_number');

            countrySelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                const code = selected.getAttribute('data-code');
                if (code) {
                    phoneInput.value = code + " "; // code auto-insert
                    phoneInput.focus();
                }
            });
        </script>
        <script>
            // flash message auto-hide after 3 seconds
            setTimeout(function() {
                document.querySelectorAll('.flash-message').forEach(function(el) {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500); // element remove after fade
                });
            }, 3000); // 3 seconds baad fade out
        </script>

    </body>

    </html>
