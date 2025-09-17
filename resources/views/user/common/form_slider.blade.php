<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">


    <!-- ✅ Preload font for faster load -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;700&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;700&display=swap"
            rel="stylesheet">
    </noscript>

    <style>
        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #e6f4f0;
            /*font-family: 'Actor', sans-serif;*/
            font-family: 'Arial Rounded MT Bold', sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
            opacity: 0;
            /* ✅ Start hidden */
            transition: opacity 0.8s ease;
            /* ✅ Smooth fade-in */
        }

        .container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            height: 600px;
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
            background-color: transparent;
        }

        .left img {
            width: 190px;
            margin-left: -300px;
            /*height: auto;*/
            /*margin-bottom: 20px;*/
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
            padding: 55px;
            border-radius: 25px;
            flex: 1;
            max-width: 445px;
            max-height: 415px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-right: -170px;
        }

        .right h2 {
            margin-top: -25px;
            color: #333333;
            text-align: center;
            font-size: 32px;
            font-weight: 550;
        }

        .right p {
            font-size: 16px;
            color: #333333;
            text-align: center;
            margin-bottom: 20px;
            margin-top: -10px;
            font-family: 'Actor', sans-serif;
        }

        .language-option input[type="radio"] {
            display: none;
        }

        .language-option label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #978b8b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            height: 45px;
            width: 480px;
            margin-left: -28px;

        }

        .language-option input[type="radio"]:checked+label .lang-info strong {
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-size: 17px;
            /*font-weight: 500;*/
        }

        .language-option input[type="radio"]:checked+label {
            border: 1px solid #0b3d27;
            background: #eaf5ef;
            color: #0b3d27;
            font-weight: bold;
            /* add this line */
        }

        .lang-info {
            display: flex;
            align-items: center;
            font-family: 'Vector', sans-serif;
            font-weight: 100;
        }

        .lang-info img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border-radius: 50%;
            object-fit: cover;
        }

        .main-lang {
            margin-left: 10px;
        }

        .lang-small {
            display: inline-block;
            margin-top: 10px;
            /* adjust value as needed */
            font-family: 'Actor', sans-serif;
        }

        label small {
            color: #888;
            font-size: 12px;
        }

        .tick {
            font-size: 18px;
            color: #0b3d27;
            visibility: hidden;
            margin-right: 15px;
        }

        input[type="radio"]:checked+label .tick {
            visibility: visible;
        }

        .continue-btn {
            width: 112%;
            padding: 22px;
            margin-left: -26px;
            background: #0b3d27;
            color: white;
            border: none;
            border-radius: 50px;
            /* More rounded pill shape */
            font-size: 18px;
            margin-top: 145px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        /* Hover effect */
        .continue-btn:hover {
            background-color: #085b3a;
            /* slightly lighter or darker shade for hover */
        }

        /* ✅ Responsive styles */
        @media (max-width: 768px) {
            body {
                height: auto;
                padding: 20px 0;
                overflow-x: hidden;
            }

            .container {
                flex-direction: column;
                height: auto;
                width: 100%;
            }

            .left,
            .right {
                max-width: 100%;
                width: 100%;
                padding: 20px;
                box-sizing: border-box;
            }

            .left img {
                width: 180px;
            }

            .subtitle {
                font-size: 25px;
            }

            .left p {
                font-size: 12px;
            }

            .right h2 {
                font-size: 20px;
            }

            .continue-btn {
                font-size: 16px;
                padding: 12px;
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
            <h2>{{ __('select_language') }}</h2>
            <p>{{ __('select_language_description') }}</p>

            <!-- ✅ Language Option 1 -->
            {{--        <div class="language-option"> --}}
            {{--            <input type="radio" id="lang-en" name="language" checked> --}}
            {{--            <label for="lang-en"> --}}
            {{--                <div class="lang-info"> --}}
            {{--                    <img src="https://flagcdn.com/gb.svg" alt="English"> --}}
            {{--                    <div> --}}
            {{--                        <strong>English</strong><br> --}}
            {{--                        <small>English</small> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--                <div class="tick">✔️</div> --}}
            {{--            </label> --}}
            {{--        </div> --}}
            <div class="language-option">
                <input type="radio" id="lang-en" name="language" value="en"
                    {{ session('locale', 'en') == 'en' ? 'checked' : '' }}>
                <label for="lang-en">
                    <div class="lang-info">
                        <img src="https://flagcdn.com/gb.svg" alt="English">
                        <div class="main-lang">
                            <strong>USA</strong><br>
                            <small class="lang-small">English</small>
                        </div>
                    </div>
                    <div class="tick">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                fill="#014122" stroke="#014122" />
                        </svg>
                    </div>
                </label>
            </div>
            <div class="language-option">
                <input type="radio" id="lang-ko" name="language" value="ko"
                    {{ session('locale') == 'ko' ? 'checked' : '' }}>

                <label for="lang-ko">
                    <div class="lang-info">
                        <img src="https://flagcdn.com/kr.svg" alt="Korean (South Korea)">
                        <div class="main-lang">
                            <strong>South Korea</strong><br>
                            <small class="lang-small">한국어</small>
                        </div>
                    </div>
                    <div class="tick">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 7.81817L9 19.8182L3.5 14.3182L4.91 12.9082L9 16.9882L19.59 6.40817L21 7.81817Z"
                                fill="#014122" stroke="#014122" />
                        </svg>
                    </div>
                </label>
            </div>






            {{--        <button class="continue-btn">Continue</button> --}}
            <button class="continue-btn"
                onclick="window.location.href='form_slider_two'">{{ __('left_continue') }}</button>

        </div>
    </div>

    <!-- ✅ Fade-in script -->
    <script>
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('input[name="language"]').on('change', function() {
            let lang = $(this).val();

            $.post("{{ route('lang.ajaxSwitch') }}", {
                _token: "{{ csrf_token() }}",
                lang: lang
            }, function(data) {
                if (data.status === 'success') {
                    location.reload();
                }
            });
        });
    </script>



</body>

</html>
