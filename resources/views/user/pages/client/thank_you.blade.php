    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/media/logos/favicon.png') }}" />

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Select2 Bootstrap 5 Theme -->
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        <!-- Google Fonts -->
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
                src: url('{{ asset('fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                background: var(--bg-color);
                font-family: "Poppins", sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                overflow: hidden;
                /* Prevent scroll */
            }

            .success-modal-btn {
                background-color: var(--primary-green);
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

            .custom-card {
                border-radius: 35px;
                border: none;
                max-width: 650px;
                width: 100%;
            }

            .btn-primary-green {
                background-color: var(--primary-green);
                border-color: var(--primary-green);
                color: white;
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }

            .btn-primary-green:hover {
                background-color: #062a1a;
                border-color: #062a1a;
                color: white;
            }

            .card-header1 {
                margin-top: 30px;
                text-align: center;
            }

            .img-thumbnail-guestly {
                max-width: 150px;
                height: auto;
                margin-bottom: 20px;
            }

            .card-body {
                text-align: center;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 10px;
                color: var(--text-primary);
            }

            p {
                font-size: 16px;
                color: var(--text-secondary);
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <div class="card custom-card shadow-lg">
            <div class="card-header1">
                <img src="{{ asset('assets/media/logos/default-dark.svg') }}" class="img-fluid" alt="Guestly Logo">
            </div>
            <div class="card-body p-4">
                <img src="{{ asset('assets/web/thumbs_up.png') }}" class="img-thumbnail-guestly" alt="Thumbs Up">
                <h2>Thank you!</h2>
                <p>We’ve shared your profile link with you by email. Please check your inbox (and don’t forget to check your spam folder).</p>
                <button class="success-modal-btn">Back to Booking</button>
            </div>
        </div>
    </body>

    </html>
