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
    <style>
        /* Consistent CSS across all pages */
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

        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .back-link a {
            color: #014122;
            font-weight: 500;
            text-decoration: none;
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
            <h2>{{ __('forgot_password') }}</h2>
            <p class="instruction-text">
                {{ __('forgot_password_message') }}
            </p>
            <form>
                <div class="form-group">
                    <label>{{ __('email') }}</label>
                    <input type="email" placeholder="{{ __('enter_register_email') }}" required>
                </div>
                <button type="submit"
                    onclick="window.location.href='{{ asset('assets/web/verify_otp') }}?role={{ request('role', 'artist') }}'"
                    class="continue-btn">{{ __('send_code') }}</button>
            </form>
            <p class="back-link">
                {{--            <a href="{{ asset ('form_login_signup') }}">← {{ __('back_to_login') }}</a> --}}
                <a href="{{ url('form_login_signup') }}?role={{ request('role', 'artist') }}">
                    ← {{ __('back_to_login') }}
                </a>
            </p>
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>
</body>

</html>
