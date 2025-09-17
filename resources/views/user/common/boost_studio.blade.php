    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guestly</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --bg-color: #e6f4f0;
                --primary-green: #0b3d27;
                --secondary-green-btn: #5e8082;
                --text-primary: #0b3d27;
                --text-secondary: #5d7a70;
                --card-bg: #ffffff;
                --border-color: #e5e7eb;
                --slider-track-color: #e0e7e5;
                --payment-border-color: #c5d5d0;
                /* More accurate greenish border */
            }

            @font-face {
                font-family: 'Arial Rounded MT Bold';
                src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            * {
                box-sizing: border-box;
                margin: -4px;
                padding: 0;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg-color);
                color: var(--text-primary);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 20px;
                overflow: hidden;
                /* ✅ Scroll disable karta hai */
                opacity: 0;
                transition: opacity 0.8s ease;

            }

            .boost-container {
                background-color: var(--card-bg);
                padding: 35px 30px;
                border-radius: 24px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
                max-width: 500px;
                width: 100%;
            }

            /* --- Intro View Styles --- */
            .boost-intro-view {
                text-align: center;
            }

            .boost-icon {
                width: 150px;
                height: auto;
                margin-bottom: 25px;
            }

            .boost-intro-view h2 {
                font-size: 24px;
                font-weight: 500;
                color: #014122;
                margin-bottom: 15px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            .boost-intro-view p {
                font-size: 15px;
                color: #333333;
                line-height: 1.6;
                margin: 0 auto 30px auto;
                max-width: 80%;
                font-family: 'Actor', sans-serif;
            }

            .modal-button-group {
                display: flex;
                gap: 15px;
            }

            .modal-btn {
                flex: 1;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                padding: 14px 20px;
                border-radius: 50px;
                border: none;
                font-size: 14px;
                font-weight: 500;
                color: white;
                cursor: pointer;
                transition: opacity 0.2s;
            }

            .modal-btn:hover {
                opacity: 0.9;
            }

            .skip-btn {
                background-color: var(--secondary-green-btn);
            }

            .boost-btn {
                background-color: var(--primary-green);
            }

            /* --- Details View Styles --- */
            .boost-details-view {
                display: none;
            }

            .boost-details-view .header {
                text-align: center;
                margin-bottom: 30px;
            }

            .boost-details-view h2 {
                font-size: 20px;
                font-weight: 500;
                margin-bottom: 6px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            .boost-details-view .subtitle {
                font-size: 14px;
                color: #333333;
                font-family: 'Helvetica', sans-serif;
                margin-top: 8px;
            }

            .settings-box {
                border: 1px solid #5E8082;
                border-radius: 12px;
                padding: 10px 25px 25px 25px;
                margin-bottom: 25px;
            }

            .setting-divider {
                border-top: 1px solid #5e8082;
                margin: -17px -25px 12px;
            }

            .setting-item {
                text-align: left;
            }

            .duration-item {
                margin-bottom: 25px;
            }

            .duration-item .label {
                font-size: 17px;
                font-weight: 500;
                margin-bottom: 4px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                color: #333333;
                margin-top: 8px;
            }

            .duration-item .value {
                font-size: 14px;
                color: #5E8082;
                font-weight: 500;
                font-family: 'Helvetica', sans-serif;
                margin-top: 0px
            }

            input[type="range"] {
                -webkit-appearance: none;
                appearance: none;
                width: 102%;
                height: 3px;
                background: var(--slider-track-color);
                border-radius: 5px;
                outline: none;
                margin-top: 15px;
            }

            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 18px;
                height: 18px;
                background: var(--primary-green);
                border-radius: 50%;
                cursor: pointer;
                border: none;
            }

            input[type="range"]::-moz-range-thumb {
                width: 18px;
                height: 18px;
                background: var(--primary-green);
                border-radius: 50%;
                cursor: pointer;
                border: none;
            }

            .budget-item {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                border-top: 0px solid var(--border-color);
                padding-top: 20px;
            }

            .budget-item .label-group .label {
                font-size: 17px;
                font-weight: 500;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: -10px;
                color: #333333;
            }

            .budget-item .label-group .sublabel {
                font-size: 14px;
                color: #5E8082;
                margin-top: 10px;
                font-family: 'Helvetica', sans-serif;
            }

            .budget-item .value-group {
                text-align: right;
            }

            .budget-item .value-group .price {
                font-size: 17px;
                font-weight: 500;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: -10px;
            }

            .budget-item .value-group .sublabel {
                font-size: 14px;
                color: #5E8082;
                font-family: 'Helvetica', sans-serif;
                margin-top: 10px;
            }

            .divider {
                border: none;
                height: 1px;
                background-color: #5e8082;
                margin: 0 0 25px 0;
                margin-top: 35px;
            }

            /* === UPDATED PAYMENT SECTION STYLES === */
            .payment-section h3 {
                font-size: 17px;
                font-weight: 500;
                margin-bottom: 26px;
                margin-left: 2px;
                text-align: left;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: 38px;
            }

            .payment-method-box {
                border: 1px solid #014122;
                border-radius: 12px;
                padding: 18px 20px;
                margin-bottom: 14px;
                text-align: left;
            }

            .payment-method-header {
                font-size: 17px;
                font-weight: 500;
                color: #333333;
                margin-bottom: 25px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-top: -5px;
            }

            .payment-method-details {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .card-info {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .visa-logo {
                width: 35px;
                height: auto;
                flex-shrink: 0;
                margin-left: 5px;
            }

            .card-details {
                display: flex;
                flex-direction: column;
            }

            .card-name {
                font-weight: 500;
                font-size: 15px;
                color: #014122;
                font-family: 'Helvetica', sans-serif;
                margin-left: 10px;
                margin-top: -10px;
            }

            .card-fund {
                font-size: 12px;
                color: #5E8082;
                font-family: 'Actor', sans-serif;
                margin-top: 8px;
                margin-left: 10px;
            }

            .change-link {
                font-weight: 500;
                color: #014122;
                text-decoration: underline;
                text-underline-offset: 3px;
                font-size: 16px;
                margin-right: 0px;
                font-family: 'Arial Rounded MT Bold', sans-serif;
                margin-bottom: 5px;
            }

            /* === END OF UPDATED STYLES === */

            .info-text {
                font-size: 13px;
                color: #333333;
                line-height: 1.6;
                text-align: left;
                margin-bottom: 15px;
                font-family: 'Actor', sans-serif;
            }

            .info-text:last-of-type {
                margin-bottom: 30px;
            }

            .boost-post-btn {
                width: 100%;
                background-color: #014122;
                padding: 16px;
                border-radius: 50px;
                border: none;
                font-size: 16px;
                font-weight: 500;
                color: white;
                cursor: pointer;
                transition: opacity 0.2s;
                font-family: 'Arial Rounded MT Bold', sans-serif;
            }

            .boost-post-btn:hover {
                opacity: 0.9;
            }
        </style>
    </head>

    <body>

        <div class="boost-container">

            <!-- View 1: Initial Boost Prompt -->
            <div class="boost-intro-view">
                <img class="boost-icon" src="{{ asset('assets/web/extra/boost_logo.png') }}"
                    alt="Megaphone icon for boosting visibility">
                <h2>Boost Your Studio Visibility</h2>
                <p>Promote your listing with an ad boost and stand out with a "Now Taking Guests" badge. Whether you're
                    launching, filling last-minute seats, or just want more exposure, boosting helps you get seen.</p>
                <div class="modal-button-group">
                    <button class="modal-btn skip-btn">Skip</button>
                    <button class="modal-btn boost-btn">Boost</button>
                </div>
            </div>

            <!-- View 2: Boost Details Form (Initially Hidden) -->
            <div class="boost-details-view">
                <div class="header">
                    <h2>Boost Your Studio</h2>
                    <p class="subtitle">Put your studio in front of more guests, faster.</p>
                </div>

                {{--        <div class="settings-box"> --}}
                {{--            <div class="setting-item duration-item"> --}}
                {{--                <div class="label">Set Durations</div> --}}
                {{--                <div class="value" id="duration-value">15 Days</div> --}}
                {{--                <input type="range" min="1" max="30" value="15" id="duration-slider"> --}}
                {{--            </div> --}}
                {{--            <div class="setting-item budget-item"> --}}
                {{--                <div class="label-group"> --}}
                {{--                    <div class="label">Add Budget</div> --}}
                {{--                    <div class="sublabel">Estimate Reach</div> --}}
                {{--                </div> --}}
                {{--                <div class="value-group"> --}}
                {{--                    <div class="price">$15</div> --}}
                {{--                    <div class="sublabel">50,000 - 100,000</div> --}}
                {{--                </div> --}}
                {{--            </div> --}}
                {{--        </div> --}}
                <div class="settings-box">
                    <div class="setting-item duration-item">
                        <div class="label">Set Durations</div>
                        <div class="value" id="duration-value">15 Days</div>
                        <input type="range" min="1" max="30" value="15" id="duration-slider">
                    </div>

                    <!-- Separator Line -->
                    <div class="setting-divider"></div>

                    <div class="setting-item budget-item">
                        <div class="label-group">
                            <div class="label">Add Budget</div>
                            <div class="sublabel">Estimate Reach</div>
                        </div>
                        <div class="value-group">
                            <div class="price">$15</div>
                            <div class="sublabel">50,000 - 100,000</div>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <!-- === UPDATED PAYMENT HTML STRUCTURE === -->
                <div class="payment-section">
                    <h3>Add Credit/Debit Cards</h3>
                    <div class="payment-method-box">
                        <div class="payment-method-header">Payment Method</div>
                        <div class="payment-method-details">
                            <div class="card-info">
                                <img class="visa-logo" src="{{ asset('assets/web/extra/visa_logo.png') }}" alt="Visa Card Logo">
                                <div class="card-details">
                                    <span class="card-name">Visa Card</span>
                                    <span class="card-fund">Fund Available $12,256</span>
                                </div>
                            </div>
                            <a href="#" class="change-link">Change</a>
                        </div>
                    </div>
                </div>

                <p class="info-text">We'll deduct funds about once a day when you run ads. If funds run out, your ads
                    will be paused.</p>
                <p class="info-text">Ads are reviewed within 24 hours, although in some cases it may take longer. Once
                    they're running, you can pause spending at any time.</p>

                <button class="boost-post-btn">Boost Post</button>
            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // --- View Switching Logic ---
                const boostBtn = document.querySelector('.boost-btn');
                const introView = document.querySelector('.boost-intro-view');
                const detailsView = document.querySelector('.boost-details-view');

                if (boostBtn && introView && detailsView) {
                    boostBtn.addEventListener('click', () => {
                        introView.style.display = 'none';
                        detailsView.style.display = 'block';
                        updateSliderBackground(document.getElementById('duration-slider'));
                    });
                }

                // --- Dynamic Day Slider Logic ---
                const durationSlider = document.getElementById('duration-slider');
                const durationValue = document.getElementById('duration-value');

                const updateSliderBackground = (slider) => {
                    if (!slider) return;
                    const percentage = (slider.value - slider.min) / (slider.max - slider.min) * 100;
                    const primaryGreen = getComputedStyle(document.documentElement).getPropertyValue(
                        '--primary-green');
                    const sliderTrackColor = getComputedStyle(document.documentElement).getPropertyValue(
                        '--slider-track-color');

                    slider.style.background =
                        `linear-gradient(to right, ${primaryGreen} ${percentage}%, ${sliderTrackColor} ${percentage}%)`;
                }

                if (durationSlider && durationValue) {
                    updateSliderBackground(durationSlider);

                    durationSlider.addEventListener('input', () => {
                        durationValue.textContent = `${durationSlider.value} Days`;
                        updateSliderBackground(durationSlider);
                    });
                }
            });
        </script>
        <script>
            window.addEventListener('load', () => {
                document.body.style.opacity = 1;
            });
        </script>
    </body>

    </html>
