    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset ('guestly_favicon.png')}}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Actor&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        :root {
            --bg-color: #e6f4f0;
            --primary-green: #014122;
            --secondary-green: #8faea6;
            --text-primary: #0b3d27;
            --text-secondary: #5d7a70;
            --border-active: #0b3d27;
            --border-inactive: #cdded8;
            --modal-bg: #ffffff;
        }

        @font-face {
            font-family: 'Arial Rounded MT Bold';
            src: url('{{ asset('fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Arial Rounded MT Bold', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            box-sizing: border-box;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .main-container {
            display: none; /* Initially hidden, JS will show the correct one */
            flex-direction: column;
            align-items: center;
            width: 100%;
            transition: filter 0.3s ease;
        }
        #artist-plans-container { max-width: 700px; }
        #studio-plans-container { max-width: 1200px; }

        .blur-background { filter: blur(5px); pointer-events: none; }

        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { font-size: 45px; font-weight: 500; margin: 0; color: #014122 }
        .header p { font-size: 22px; color: #333333; margin-top: 10px; font-family: 'Actor', sans-serif }

        /* TOGGLE SWITCH - SAME FOR BOTH */
        .billing-toggle { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; font-size: 16px; user-select: none; font-family: 'Arial Rounded MT Bold', sans-serif; font-weight: 500; }
        .billing-toggle span { transition: color 0.4s ease, font-weight 0.4s ease; cursor: pointer; }
        .billing-toggle span:first-of-type { color: #014122; font-weight: 500; }
        .billing-toggle span:last-of-type { color: #828282; font-weight: 500; }
        .billing-toggle:has(input:checked) span:first-of-type { color: #828282; font-weight: 500; }
        .billing-toggle:has(input:checked) span:last-of-type { color: var(--text-primary); font-weight: 500; }
        .switch { position: relative; display: inline-block; width: 52px; height: 30px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 6px; left: 5px; right: 5px; bottom: 6px; background-color: var(--primary-green); transition: .4s; border-radius: 10px; }
        .slider:before { position: absolute; content: ""; height: 30px; width: 30px; left: -5px; bottom: -6px; background-color: #e6f4f0; border: 3px solid var(--primary-green); box-sizing: border-box; transition: .4s; border-radius: 50%; }
        input:checked + .slider:before { transform: translateX(22px); }

        .pricing-container { display: flex; width: 100%; justify-content: center; gap: 30px; }

        /* UNIFIED CARD STYLING */
        .plan-card {
            flex: 1;
            background-color: var(--bg-color);
            border: 2px solid #01412254;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            position: relative;
            padding: 20px;
            padding-bottom: 50px;
            box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.1), 0 0 10px rgba(11, 61, 39, 0.05);
            max-width: 280px;
        }
        .plan-card.active {
            border-color: #014122;
            box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.3), 0 0 15px rgba(11, 61, 39, 0.2);
            transform: scale(1.02);
        }
        .plan-card h3 {
            font-size: 24px;
            font-weight: 500;
            margin: 0 0 15px 0;
            text-align: center;
            color: #89b9a8;
            transition: color 0.3s ease;
        }
        .plan-card.active h3 { color: #014122; }
        .plan-card hr {
            border: 0;
            height: 1px;
            background-color: #b0c4c4; /* light color for inactive */
            margin: 0 auto 20px auto;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #b8c5c0;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        .plan-card.active .features-list {
            color: #333333;
        }
        .features-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 15px;
            line-height: 1.5;
            font-family: 'Actor', sans-serif;
        }

        .features-list li .tick-icon {
            width: 15px;
            height: 12px;
            flex-shrink: 0;
            margin-top: 6px;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }
        .plan-card.active .tick-icon {
            opacity: 1;
        }
        .plan-card.active hr {
            background-color: #5E8082;
        }
        /* UNIFIED BUTTON STYLING */
        .plan-button {
            position: absolute;
            bottom: -28px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 55px;
            padding: 17px;
            border: none;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 50px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            color: white;
        }
        .plan-card.active .plan-button { background-color: #014122; }
        .plan-card:not(.active) .plan-button { background-color: var(--secondary-green); }

        .continue-btn {
            background-color: #014122;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 20px 65px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 60px;
            transition: background-color 0.3s;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        /* MODAL STYLES */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-content { background: var(--modal-bg); padding: 30px; border-radius: 20px; width: 100%; max-width: 420px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transform: scale(0.95); transition: transform 0.3s ease; }
        .modal-overlay.active .modal-content { transform: scale(1); }
        .modal-content h2 { text-align: center; font-size: 30px; margin-top: 0; margin-bottom: 25px; font-weight: 500; color: #014122 }
        .payment-methods { display: flex; gap: 15px; margin-bottom: 25px; }
        .method-card { flex: 1; display: flex; justify-content: center; align-items: center; padding: 15px; border: 2px solid var(--border-inactive); border-radius: 12px; cursor: pointer; transition: all 0.2s ease; }
        .method-card.active { border-color: var(--border-active); background-color: #eaf5ef; }
        .method-card img { height: 20px; max-width: 50px; }
        .form-row { display: flex; gap: 15px; }
        .form-group { position: relative; margin-bottom: 20px; width: 100%; }
        .form-group label { position: absolute; top: 8px; left: 15px; font-size: 12px; color: var(--text-secondary); pointer-events: none; }
        .form-group input { width: 100%; padding: 25px 15px 8px 15px; border: 1px solid var(--border-inactive); border-radius: 12px; font-size: 16px; box-sizing: border-box; outline: none; transition: border-color 0.2s ease; }
        .form-group input:focus { border-color: var(--border-active); }
        .modal-content hr { border: 0; height: 1px; background-color: var(--border-inactive); margin: 10px 0 20px 0; }
        .modal-footer { display: flex; justify-content: space-between; align-items: center; }
        .modal-footer .price { font-size: 25px; font-weight: 500; color: #014122 }
        .modal-footer .pay-now-btn { background-color: var(--primary-green); color: white; border: none; border-radius: 50px; padding: 15px 60px; font-size: 17px; font-family: 'Arial Rounded MT Bold', sans-serif; font-weight: 500; cursor: pointer; }

        /* --- UPDATED COUPON STYLES --- */
        .coupon-section {
            margin-bottom: 20px;
        }
        .coupon-toggle-link {
            color: var(--primary-green);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            transition: color 0.2s ease;
        }
        .coupon-toggle-link:hover {
            color: var(--text-primary);
        }
        .coupon-input-wrapper {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s ease-in-out, opacity 0.4s ease-in-out, margin-top 0.4s ease-in-out;
        }
        .coupon-input-wrapper.open {
            max-height: 100px; /* Should be enough for the input field */
            opacity: 1;
            margin-top: 15px;
        }
        .coupon-input-wrapper .form-group {
            margin-bottom: 0;
        }
        /* --- NEW: Styles for the button inside the input --- */
        .coupon-input-wrapper .form-group input {
            padding-right: 95px; /* Make space for the button */
        }
        .apply-btn {
            position: absolute;
            top: 50%;
            right: 8px; /* Small gap from the edge */
            transform: translateY(-50%);
            padding: 9px 18px;
            border: none;
            background-color: var(--primary-green);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .apply-btn:hover {
            background-color: var(--text-primary);
        }
        /* --- END OF COUPON STYLES --- */

        .success-modal-content { position: relative; text-align: center; padding: 30px; padding-top: 200px; }
        .success-icon { position: absolute; width: 220px; height: auto; top: -50px; left: 50%; transform: translateX(-50%); }
        .success-modal-content h2 { font-size: 28px; margin-bottom: 15px; color: #014122; font-family: 'Arial Rounded MT Bold', sans-serif; font-weight: 100; }
        .success-modal-content p { font-size: 16px; margin-bottom: 30px; margin-left: auto; margin-right: auto; color: #333333; font-family: 'Actor', sans-serif; }

        .start-verification-btn_artist,
        .start-verification-btn_studio {
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
            display: none; /* Hide buttons by default */
        }

        /* RESPONSIVE STYLES */
        @media (max-width: 1200px) {
            #studio-plans-container .pricing-container { flex-wrap: wrap; }
            .plan-card { margin-bottom: 40px; }
        }
        @media (max-width: 750px) {
            #artist-plans-container .pricing-container { flex-direction: column; align-items: center; }
            #artist-plans-container .plan-card { width: 100%; max-width: 350px; }
        }
        @media (max-width: 650px) {
            .header h1 { font-size: 28px; }
            .modal-content { width: 90%; }
        }
    </style>
</head>
<body>

<!-- ARTIST PLANS CONTAINER -->
<div id="artist-plans-container" class="main-container">
    <div class="header"><h1>{{ __('choose_plan_heading') }}</h1><p>{{ __('choose_plan_message') }}</p></div>
    <div class="billing-toggle">
        <span>{{ __('monthly_toggle') }}</span>
        <label class="switch">
            <input type="checkbox" class="billing-cycle-toggle">
            <span class="slider"></span>
        </label>
        <span>{{ __('yearly_toggle') }}</span>
    </div>
    <div class="pricing-container">
        <div class="plan-card active" data-plan-name="Free Tier" data-price-monthly="Free" data-price-yearly="Free">
            <h3>Free Tier</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> 1 active studio request at a time.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Basic guest artist profile.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Messaging with studios (limited).</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Studio calendar viewing (read-only).</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Studio seat availability view.</li>
            </ul>
            <button class="plan-button">Free</button>
        </div>
        <div class="plan-card" data-plan-name="Pro Tier" data-price-monthly="$19.99/month" data-price-yearly="$199/year">
            <h3>Pro Tier</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Unlimited studio requests.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Full booking management tools.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Advanced guest artist profile.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Priority messaging and real-time chat.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Direct calendar integration.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Preferred studio tagging.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> And Much More</li>
            </ul>
            <button class="plan-button">$19.99/month</button>
        </div>
    </div>
    <button class="continue-btn">{{ __('left_continue') }}</button>
</div>

<!-- STUDIO PLANS CONTAINER -->
<div id="studio-plans-container" class="main-container">
    <div class="header"><h1>{{ __('choose_plan_heading') }}</h1><p>{{ __('choose_plan_message') }}</p></div>
    <div class="billing-toggle">
        <span>{{ __('monthly_toggle') }}</span>
        <label class="switch"><input type="checkbox" class="billing-cycle-toggle"><span class="slider"></span></label>
        <span>{{ __('yearly_toggle') }}</span>
    </div>
    <div class="pricing-container">
        <div class="plan-card active" data-plan-name="Free Tier" data-price-monthly="Free" data-price-yearly="Free">
            <h3>Free Tier</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> List 1 seat.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Basic listing and visibility.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Studio appears in search.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Receive booking requests</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Basic studio profile</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Limited messaging</li>
            </ul>
            <button class="plan-button">Free</button>
        </div>
        <div class="plan-card" data-plan-name="Pro Tier" data-price-monthly="$19.99/month" data-price-yearly="$199/year">
            <h3>Pro Tier</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> List up to 3 seats.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Unlimited messaging with guests.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Add studio amenities, branding, and multiple photos.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Access guest workday scheduling tools.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Priority placement in search.</li>
            </ul>
            <button class="plan-button">$19.99/month</button>
        </div>
        <div class="plan-card" data-plan-name="Studio Plus Tier" data-price-monthly="$49.99/month" data-price-yearly="$499/year">
            <h3>Studio Plus Tier</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> List up to 8 seats.</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Private "Studio Notes" section for internal feedback on guests</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Advanced calendar controls (block dates, manage multiple stations)</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Detailed analytics (views, bookings, guest history)</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Add custom guest terms and per-day commission settings</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Option to hide or show reviews</li>
            </ul>
            <button class="plan-button">$49.99/month</button>
        </div>
        <div class="plan-card" data-plan-name="Studio Unlimited" data-price-monthly="$149.99/month" data-price-yearly="$1499/year">
            <h3>Studio Unlimited</h3><hr>
            <ul class="features-list">
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Everything in Pro, plus</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Private "Studio Notes" section for internal feedback on guests</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Advanced calendar controls (block dates, manage multiple stations)</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Detailed analytics (views, bookings, guest history)</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Add custom guest terms and per-day commission settings</li>
                <li><img src="{{ asset ('extra/vector.png') }}" alt="tick" class="tick-icon"> Option to hide or show reviews</li>
            </ul>
            <button class="plan-button">$149.99/month</button>
        </div>
    </div>
    <button class="continue-btn">{{ __('left_continue') }}</button>
</div>


<!-- MODALS (COMMON FOR BOTH) -->
<div class="modal-overlay" id="payment-modal">
    <div class="modal-content">
        <form>
            <h2>Buy Subscription</h2>
            <div class="payment-methods">
                <div class="method-card active"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa"></div>
                <div class="method-card"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" alt="Mastercard"></div>
                <div class="method-card"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"></div>
            </div>
            <div class="form-group"><label for="card-name">Name on card</label><input type="text" id="card-name" value="John doe"></div>
            <div class="form-group"><label for="card-number">Card Number</label><input type="text" id="card-number" placeholder="Enter Your Card Number"></div>
            <div class="form-row">
                <div class="form-group"><label for="expiry-date">Expiry Date</label><input type="text" id="expiry-date" placeholder="MM/YY"></div>
                <div class="form-group"><label for="cvc">Security Code</label><input type="text" id="cvc" placeholder="CVC"></div>
            </div>

            <!-- --- UPDATED COUPON HTML --- -->
            <div class="coupon-section">
                <a href="#" class="coupon-toggle-link" id="coupon-toggle-link">Have a coupon code?</a>
                <div class="coupon-input-wrapper" id="coupon-input-container">
                    <div class="form-group">
                        <label for="coupon-code">Coupon Code</label>
                        <input type="text" id="coupon-code" placeholder="Enter your code">
                        <button type="button" id="apply-coupon-btn" class="apply-btn">Apply</button>
                    </div>
                </div>
            </div>
            <!-- --- END OF COUPON HTML --- -->

            <hr>
            <div class="modal-footer"><span class="price">$19/month</span><button type="submit" class="pay-now-btn">Pay Now</button></div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="success-modal">
    <div class="modal-content success-modal-content">
        <img class="success-icon" src="{{ asset ('thumbs_up.png') }}" alt="Success Thumbs Up">
        <h2 id="success-heading">{{ __('you_subscribed') }}</h2>
        <p id="success-paragraph">Your subscription is now active.</p>
        <!-- These buttons will be shown conditionally by JavaScript -->
        <button class="start-verification-btn_artist" onclick="window.location.href='user_identification'">{{ __('start_verification') }}</button>
        <button class="start-verification-btn_studio" onclick="window.location.href='studio_step_form'">{{ __('start_verification') }}</button>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

// PAGE SWITCHER
    window.onload = () => {
        const urlParams = new URLSearchParams(window.location.search);
        const role = urlParams.get('role'); // This will be 'artist' or 'studio'
        const artistContainer = document.getElementById('artist-plans-container');
        const studioContainer = document.getElementById('studio-plans-container');
        let activeContainer;

        if (role === 'studio') {
            studioContainer.style.display = 'flex';
            activeContainer = studioContainer;
        } else {
            // Default to artist if role is not 'studio' or not present
            artistContainer.style.display = 'flex';
            activeContainer = artistContainer;
        }

        document.body.style.opacity = 1;
        initializePricingPage(activeContainer, role);
    };

    // MAIN PRICING PAGE LOGIC
    function initializePricingPage(container, role) {
        if (!container) return;

        // Select elements
        const planCards = container.querySelectorAll('.plan-card');
        const openModalBtn = container.querySelector('.continue-btn');
        const billingToggle = container.querySelector('.billing-cycle-toggle');
        const paymentModal = document.getElementById('payment-modal');
        const successModal = document.getElementById('success-modal');
        const payNowBtn = paymentModal.querySelector('.pay-now-btn');
        const modalPrice = paymentModal.querySelector('.modal-footer .price');
        const successHeading = document.getElementById('success-heading');
        const successParagraph = document.getElementById('success-paragraph');
        const artistVerificationBtn = document.querySelector('.start-verification-btn_artist');
        const studioVerificationBtn = document.querySelector('.start-verification-btn_studio');

        // --- COUPON SCRIPT ---
        const couponToggleLink = document.getElementById('coupon-toggle-link');
        const couponInputContainer = document.getElementById('coupon-input-container');
        const applyCouponBtn = document.getElementById('apply-coupon-btn'); // NEW: Get the apply button

        couponToggleLink.addEventListener('click', (e) => {
            e.preventDefault();
            couponInputContainer.classList.toggle('open');
        });

        // NEW: Event listener for the Apply button
        applyCouponBtn.addEventListener('click', () => {
            const couponCodeInput = document.getElementById('coupon-code');
            const couponCode = couponCodeInput.value.trim();

            if (couponCode) {
                // Yahan aap apni AJAX call ka code likhenge
                console.log(`Applying coupon code: ${couponCode}`);
                Swal.fire({
                    title: 'Coupon Applied',
                    text: 'Coupon code has been applied successfully.',
                    icon: 'success',
                    background: '#ffffff',
                    color: '#014122',
                    confirmButtonColor: '#014122',
                    confirmButtonText: 'OK',
                    // customClass: {
                    //     popup: 'rounded-lg shadow-lg',
                    //     title: 'font-bold',
                    //     confirmButton: 'px-4 py-2 rounded-full'
                    // }
                });
                // alert(`Backend ko AJAX request bhej rahe hain coupon code ke liye: "${couponCode}"`);
                // Example:
                // fetch('/apply-coupon', {
                //     method: 'POST',
                //     headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                //     body: JSON.stringify({ code: couponCode })
                // }).then(response => response.json()).then(data => {
                //     if(data.success) {
                //         console.log('Coupon applied!', data);
                //         // Update price or show success message
                //     } else {
                //         console.error('Invalid coupon', data.message);
                //         // Show error message
                //     }
                // });
            } else {
                Swal.fire({
                    title: 'Coupon Required',
                    text: 'Please enter a coupon code.',
                    icon: 'warning',
                    background: '#ffffff',
                    color: '#014122',
                    confirmButtonColor: '#014122',
                    confirmButtonText: 'OK',

                    // customClass: {
                    //     popup: 'rounded-lg shadow-lg',
                    //     title: 'font-bold',
                    //     confirmButton: 'px-4 py-2 rounded-full'
                    // }
                });
            }
        });
        // --- END OF COUPON SCRIPT ---


        // Function to show the correct verification button based on role
        const showCorrectVerificationButton = () => {
            if (role === 'studio') {
                studioVerificationBtn.style.display = 'block';
                artistVerificationBtn.style.display = 'none';
            } else {
                artistVerificationBtn.style.display = 'block';
                studioVerificationBtn.style.display = 'none';
            }
        };

        const updatePrices = () => {
            const isYearly = billingToggle.checked;
            planCards.forEach(card => {
                const price = isYearly ? card.dataset.priceYearly : card.dataset.priceMonthly;
                const button = card.querySelector('.plan-button');
                if (button) button.innerText = price;
            });
        };

        billingToggle.addEventListener('change', updatePrices);

        planCards.forEach(card => {
            card.addEventListener('click', () => {
                planCards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');
            });
        });

        openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const activePlanCard = container.querySelector('.plan-card.active');
            if (!activePlanCard) return;

            const planName = activePlanCard.dataset.planName;
            const isYearly = billingToggle.checked;
            const price = isYearly ? activePlanCard.dataset.priceYearly : activePlanCard.dataset.priceMonthly;

            if (planName === 'Free Tier') {
                successHeading.innerText = "{{ __('you_subscribed') }}";
                successParagraph.innerText = `{{ __('you_subscribed_message_free') }}`;
                showCorrectVerificationButton();
                successModal.classList.add('active');
                container.classList.add('blur-background');

            } else {
                modalPrice.innerText = price;
                paymentModal.classList.add('active');
                container.classList.add('blur-background');
            }
        });

        payNowBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const activePlanCard = container.querySelector('.plan-card.active');
            const planName = activePlanCard.dataset.planName;

            paymentModal.classList.remove('active');

            successHeading.innerText = "{{ __('you_subscribed') }}";
            successParagraph.innerText = `{{ __('you_subscribed_message_paid') }}`;

            showCorrectVerificationButton();
            successModal.classList.add('active');
        });

        // Close modal logic
        paymentModal.addEventListener('click', (e) => {
            if (e.target === paymentModal) {
                paymentModal.classList.remove('active');
                container.classList.remove('blur-background');
            }
        });

        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) {
                successModal.classList.remove('active');
                container.classList.remove('blur-background');
            }
        });

        updatePrices();
    }
</script>

</body>
</html>
