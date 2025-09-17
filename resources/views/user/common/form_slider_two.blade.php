<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">

    {{-- Google Fonts (Poppins) - Yeh font design se kaafi milta julta hai --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Styles - Sab kuch yahin hai */
        :root {
            --background-color: #e6f4f0;
            --primary-text-color: #0f3d2a;
            --secondary-text-color: #5d7a70;
            --primary-green: #006434;
            --border-color-active: #006434;
            --border-color-inactive: #cdded8;
            --card-background: #e6f4f0;
        }

        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--primary-text-color);
            opacity: 0;
            /* ✅ Start hidden */
            transition: opacity 0.8s ease;
            /* ✅ Smooth fade-in */
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .heading {
            font-size: 38px;
            font-weight: 500;
            margin: 0;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            color: #014122;
        }

        .subheading {
            font-size: 16px;
            color: #333333;
            margin-top: 8px;
            margin-bottom: 40px;
            font-family: 'Vector', sans-serif;
            font-weight: 100;
        }

        .options-container {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .option-card {
            background-color: var(--card-background);
            border: 2px solid var(--border-color-inactive);
            border-radius: 24px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
            /* Fixed width for consistency */
        }

        .option-card.active {
            border-color: var(--border-color-active);
            box-shadow: 0 4px 12px rgba(0, 100, 52, 0.1);
        }

        .option-card img {
            max-width: 100%;
            height: 300px;
            /* Fixed height for image area */
            object-fit: contain;
            margin-bottom: -30px;
        }

        .option-card .label {
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-size: 24px;
            font-weight: 500;
            color: #333333;
        }

        .option-card.active .label {
            color: #014122;
        }

        /*.continue-btn {*/
        /*    background-color: var(--primary-green);*/
        /*    color: white;*/
        /*    border: none;*/
        /*    border-radius: 50px; !* Pill shape *!*/
        /*    padding: 14px 40px;*/
        /*    font-size: 16px;*/
        /*    font-weight: 500;*/
        /*    cursor: pointer;*/
        /*    margin-top: 40px;*/
        /*    transition: background-color 0.3s ease;*/
        /*}*/
        .continue-btn {
            background: #014122;
            color: white;
            border: none;
            border-radius: 50px;
            /* Pill shape */
            padding: 20px 62px;
            font-size: 16px;
            font-weight: 500;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            cursor: pointer;
            margin-top: 40px;
            transition: background-color 0.3s ease;
        }

        .continue-btn:hover {
            background-color: #004d29;
            /* Darker shade on hover */
        }

        .option-card:active {
            box-shadow: 0 0 5px 4px rgba(0, 100, 52, 0.4);
        }

        /* Responsive design for mobile screens */
        @media (max-width: 500px) {
            .options-container {
                flex-direction: column;
            }

            .option-card {
                width: 70vw;
                /* Adjust width for smaller screens */
            }

            .heading {
                font-size: 28px;
            }
        }
    </style>
</head>

<body class="role-selection-page">

    <div class="main-container">
        <h1 class="heading">{{ __('slider_two_heading') }}</h1>
        <p class="subheading">{{ __('slider_two_description') }}</p> {{-- Image me yahi likha tha --}}

        <div class="options-container">
            {{-- Guest Artist Card --}}
            <div class="option-card active" id="guestArtistCard" data-role="artist">
                {{-- APNI IMAGE KA PATH YAHA DAALEIN --}}
                <img src="{{ asset('assets/web/tatto_man.png') }}" alt="Guest Artist Illustration">
                <div class="label">{{ __('role_artist') }}</div>
            </div>

            {{-- Studio Card --}}
            <div class="option-card" id="studioCard" data-role="studio">
                {{-- APNI IMAGE KA PATH YAHA DAALEIN --}}
                <img src="{{ asset('assets/web/tatto_studio.png') }}" alt="Tattoo Studio Illustration">
                <div class="label">{{ __('role_studio') }}</div>
            </div>
        </div>
        {{--    <button class="continue-btn" onclick="window.location.href='form_login_signup?role={{$role??''}}'">Continue</button> --}}

        <button class="continue-btn">{{ __('left_continue') }}</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let selectedRole = 'artist'; // default role

            $('.option-card').click(function() {
                $('.option-card').removeClass('active');
                $(this).addClass('active');
                selectedRole = $(this).data('role');
                console.log("Selected role: " + selectedRole); // for debugging
            });

            $('.continue-btn').click(function() {
                const url = 'form_login_signup?role=' + selectedRole;
                console.log("Redirecting to: " + url); // debug
                window.location.href = url;
            });
        });
    </script>
    <script>
        // JavaScript for click functionality
        const guestArtistCard = document.getElementById('guestArtistCard');
        const studioCard = document.getElementById('studioCard');
        const allCards = document.querySelectorAll('.option-card');

        guestArtistCard.addEventListener('click', () => {
            // Remove 'active' class from all cards
            allCards.forEach(card => card.classList.remove('active'));
            // Add 'active' class to the clicked card
            guestArtistCard.classList.add('active');
        });

        studioCard.addEventListener('click', () => {
            // Remove 'active' class from all cards
            allCards.forEach(card => card.classList.remove('active'));
            // Add 'active' class to the clicked card
            studioCard.classList.add('active');
        });
    </script>
    <!-- ✅ Fade-in script -->
    <script>
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>
</body>

</html>
