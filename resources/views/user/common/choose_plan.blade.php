<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">

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
            src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
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
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            transition: filter 0.3s ease;
        }

        #studio-plans-container {
            max-width: 1200px;
        }

        .blur-background {
            filter: blur(5px);
            pointer-events: none;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 45px;
            font-weight: 500;
            margin: 0;
            color: #014122
        }

        .header p {
            font-size: 22px;
            color: #333333;
            margin-top: 10px;
            font-family: 'Actor', sans-serif
        }

        /* TOGGLE SWITCH */
        .billing-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            font-size: 16px;
            user-select: none;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 500;
        }

        .billing-toggle span {
            transition: color 0.4s ease, font-weight 0.4s ease;
            cursor: pointer;
        }

        .billing-toggle span:first-of-type {
            color: #014122;
            font-weight: 500;
        }

        .billing-toggle span:last-of-type {
            color: #828282;
            font-weight: 500;
        }

        .billing-toggle:has(input:checked) span:first-of-type {
            color: #828282;
            font-weight: 500;
        }

        .billing-toggle:has(input:checked) span:last-of-type {
            color: var(--text-primary);
            font-weight: 500;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 6px;
            left: 5px;
            right: 5px;
            bottom: 6px;
            background-color: var(--primary-green);
            transition: .4s;
            border-radius: 10px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 30px;
            width: 30px;
            left: -5px;
            bottom: -6px;
            background-color: #e6f4f0;
            border: 3px solid var(--primary-green);
            box-sizing: border-box;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .pricing-container {
            display: flex;
            width: 100%;
            justify-content: center;
            gap: 30px;
        }

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

        .plan-card.active h3 {
            color: #014122;
        }

        .plan-card hr {
            border: 0;
            height: 1px;
            background-color: #b0c4c4;
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

        .plan-card.active .plan-button {
            background-color: #014122;
        }

        .plan-card:not(.active) .plan-button {
            background-color: var(--secondary-green);
        }

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
            background: var(--modal-bg);
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

        .modal-content h2 {
            text-align: center;
            font-size: 30px;
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 500;
            color: #014122
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .method-card {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            border: 2px solid var(--border-inactive);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .method-card.active {
            border-color: var(--border-active);
            background-color: #eaf5ef;
        }

        .method-card img {
            height: 20px;
            max-width: 50px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group label {
            position: absolute;
            top: 8px;
            left: 15px;
            font-size: 12px;
            color: var(--text-secondary);
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            padding: 25px 15px 8px 15px;
            border: 1px solid var(--border-inactive);
            border-radius: 12px;
            font-size: 16px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus {
            border-color: var(--border-active);
        }

        .modal-content hr {
            border: 0;
            height: 1px;
            background-color: var(--border-inactive);
            margin: 10px 0 20px 0;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-footer .price {
            font-size: 25px;
            font-weight: 500;
            color: #014122
        }

        .modal-footer .pay-now-btn {
            background-color: var(--primary-green);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 60px;
            font-size: 17px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 500;
            cursor: pointer;
        }

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
            max-height: 100px;
            opacity: 1;
            margin-top: 15px;
        }

        .coupon-input-wrapper .form-group {
            margin-bottom: 0;
        }

        .coupon-input-wrapper .form-group input {
            padding-right: 95px;
        }

        .apply-btn {
            position: absolute;
            top: 50%;
            right: 8px;
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
            font-size: 28px;
            margin-bottom: 15px;
            color: #014122;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 100;
        }

        .success-modal-content p {
            font-size: 16px;
            margin-bottom: 30px;
            margin-left: auto;
            margin-right: auto;
            color: #333333;
            font-family: 'Actor', sans-serif;
        }

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
        }

        .pay-now-btn, .continue-btn {
            position: relative;
            transition: background-color 0.3s, color 0.3s;
        }

        .pay-now-btn.button--loading,
        .continue-btn.button--loading {
            cursor: not-allowed;
            background-color: var(--secondary-green);
        }

        .pay-now-btn.button--loading::after,
        .continue-btn.button--loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid rgba(255, 255, 255, 0.5);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .button__text {
            transition: visibility 0s, opacity 0.2s linear;
        }

        .pay-now-btn.button--loading .button__text,
        .continue-btn.button--loading .button__text {
            visibility: hidden;
            opacity: 0;
        }

        @keyframes spin {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
        /* RESPONSIVE STYLES */
        @media (max-width: 1200px) {
            #studio-plans-container .pricing-container {
                flex-wrap: wrap;
            }

            .plan-card {
                margin-bottom: 40px;
            }
        }

        @media (max-width: 650px) {
            .header h1 {
                font-size: 28px;
            }

            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <!-- STUDIO PLANS CONTAINER -->
    <div id="studio-plans-container" class="main-container">
        <div class="header">
            <h1>{{ __('choose_plan_heading') }}</h1>
            <p>{{ __('choose_plan_message') }}</p>
        </div>
        <div class="billing-toggle">
            <span>{{ __('monthly_toggle') }}</span>
            <label class="switch">
                <input type="checkbox" class="billing-cycle-toggle">
                <span class="slider"></span>
            </label>
            <span>{{ __('yearly_toggle') }}</span>
        </div>
        <!-- Pricing cards will be dynamically inserted here by JavaScript -->
        <div class="pricing-container"></div>
        <button class="continue-btn">
            <span class="button__text">{{ __('left_continue') }}</span>
        </button>
    </div>


    <!-- MODALS -->
    <div class="modal-overlay" id="payment-modal">
        <div class="modal-content">
            <form id="payment-form">
                <h2>Buy Subscription</h2>
                <div class="payment-methods">
                    <div class="method-card" data-brand="visa"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa"></div>
                    <div class="method-card" data-brand="mastercard"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" alt="Mastercard"></div>
                    <div class="method-card" data-brand="unionpay"><img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/UnionPay_logo.svg" alt="UnionPay"></div>
                </div>
                <div class="form-group">
                    <label for="card-name">Name on card</label>
                    <input type="text" id="card-name" value="{{ auth()->user()->name ?? '' }}">
                </div>

                <!-- Stripe Element placeholder -->
                <div class="form-group">
                    <label for="card-element"></label>
                    <div id="card-element" style="padding:12px; border:1px solid var(--border-inactive); border-radius:12px;"></div>
                    <div id="card-errors" role="alert" style="color:#d9534f; margin-top:8px;"></div>
                </div>

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

                <hr>
                <div class="modal-footer">
                    <span class="price"></span>
                    <button type="submit" class="pay-now-btn" id="pay-now-btn">
                        <span class="button__text">Pay Now</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <div class="modal-overlay" id="success-modal">
        <div class="modal-content success-modal-content">
            <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">
            <h2 id="success-heading">{{ __('you_subscribed') }}</h2>
            <p id="success-paragraph">Your subscription is now active.</p>
            <button class="start-verification-btn_studio">{{ __('start_verification') }}</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const plansFromBackend = @json($plans);
        const userRole = @json($role_type);

        function renderPlans(plans) {
            const container = document.querySelector('#studio-plans-container .pricing-container');
            if (!container) return;
            let plansHTML = '';
            plans.forEach((plan, index) => {
                const isActive = index === 0 ? 'active' : '';
                const monthlyPriceText = parseFloat(plan.m_price) === 0 ? 'Free' : `$${plan.m_price}/month`;
                const yearlyPriceText = parseFloat(plan.y_price) === 0 ? 'Free' : `$${plan.y_price}/year`;
                const featuresHTML = (plan.features || []).map(feature => `
                <li>
                    <img src="{{ asset('assets/web/extra/vector.png') }}" alt="tick" class="tick-icon">
                    ${feature.name}
                </li>`).join('');
                plansHTML += `
            <div class="plan-card ${isActive}" data-plan-id="${plan.id}" data-plan-name="${plan.name}" data-price-monthly="${monthlyPriceText}" data-price-yearly="${yearlyPriceText}" data-m-price="${plan.m_price}" data-y-price="${plan.y_price}">
                <h3>${plan.name}</h3> <hr>
                <ul class="features-list">${featuresHTML}</ul>
                <button class="plan-button">${monthlyPriceText}</button>
            </div>`;
            });
            container.innerHTML = plansHTML;
        }

        function initializePricingPage(container) {
            if (!container) return;
            const openModalBtn = container.querySelector('.continue-btn'); // "Continue" button
            const billingToggle = container.querySelector('.billing-cycle-toggle');
            const paymentModal = document.getElementById('payment-modal');
            const successModal = document.getElementById('success-modal');
            const modalPrice = paymentModal.querySelector('.modal-footer .price');
            const updatePrices = () => {
                const isYearly = billingToggle.checked;
                container.querySelectorAll('.plan-card').forEach(card => {
                    const price = isYearly ? card.dataset.priceYearly : card.dataset.priceMonthly;
                    const button = card.querySelector('.plan-button');
                    if (button) button.innerText = price;
                });
            };
            billingToggle.addEventListener('change', updatePrices);
            container.addEventListener('click', (e) => {
                const clickedCard = e.target.closest('.plan-card');
                if (clickedCard) {
                    container.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
                    clickedCard.classList.add('active');
                }
            });
            openModalBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                const activePlanCard = container.querySelector('.plan-card.active');
                if (!activePlanCard) return;
                const isYearly = billingToggle.checked;
                const price = isYearly ? activePlanCard.dataset.priceYearly : activePlanCard.dataset.priceMonthly;
                const planId = activePlanCard.dataset.planId;
                const billingCycle = isYearly ? 'yearly' : 'monthly';
                if (price === 'Free') {
                    // Start loading animation for "Continue" button
                    openModalBtn.disabled = true;
                    openModalBtn.classList.add('button--loading');
                    try {
                        await saveFreeSubscription(planId, billingCycle);
                        successModal.classList.add('active');
                        container.classList.add('blur-background');
                        // No need to stop loading here, as button will be hidden
                    } catch (err) {
                        console.error('Free subscription save failed:', err);
                        Swal.fire({
                            title: 'Error',
                            text: 'Could not save your free subscription. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#014122'
                        });
                        // Stop loading on error
                        openModalBtn.disabled = false;
                        openModalBtn.classList.remove('button--loading');
                    }
                } else {
                    modalPrice.innerText = price;
                    paymentModal.classList.add('active');
                    container.classList.add('blur-background');
                }
                paymentModal.dataset.selectedPlanId = planId;
                paymentModal.dataset.billingCycle = billingCycle;
            });
            const closeModal = (modal) => {
                modal.classList.remove('active');
                container.classList.remove('blur-background');
            };
            paymentModal.addEventListener('click', (e) => {
                if (e.target === paymentModal) closeModal(paymentModal);
            });
            updatePrices();
        }

        // Global helper function for free plans
        async function saveFreeSubscription(planId, billingCycle) {
            try {
                const resp = await fetch('/stripe/confirm-payment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        payment_intent_id: 'free_plan_' + planId + '_' + Date.now(),
                        plan_id: planId,
                        billing_cycle: billingCycle,
                    })
                });
                const d = await resp.json();
                if (!resp.ok) throw new Error(d.error || 'Unable to save free subscription');
                return d;
            } catch (e) {
                console.error(e);
                throw e;
            }
        }

        function initStripeFlow() {
            const stripePublicKey = "{{ config('services.stripe.key') }}";
            if (!stripePublicKey) {
                console.error('Stripe public key missing. Set STRIPE_KEY in .env');
                return;
            }
            const stripe = Stripe(stripePublicKey);
            const elements = stripe.elements();
            const style = {
                base: { fontSize: '16px', color: '#32325d', '::placeholder': { color: '#aab7c4' } },
            };
            const card = elements.create('card', { style, hidePostalCode: true });
            card.mount('#card-element');
            const cardErrors = document.getElementById('card-errors');
            const paymentMethodCards = document.querySelectorAll('.payment-methods .method-card');
            let isCardComplete = false;
            card.on('change', (event) => {
                if (event.error) {
                    cardErrors.textContent = event.error.message;
                } else {
                    cardErrors.textContent = '';
                }
                isCardComplete = event.complete;
                const brand = event.brand;
                paymentMethodCards.forEach(cardDiv => cardDiv.classList.remove('active'));
                if (brand) {
                    const activeCardDiv = document.querySelector(`.method-card[data-brand="${brand}"]`);
                    if (activeCardDiv) activeCardDiv.classList.add('active');
                }
            });
            const paymentForm = document.getElementById('payment-form');
            const payNowBtn = document.getElementById('pay-now-btn');
            const startLoading = () => {
                payNowBtn.disabled = true;
                payNowBtn.classList.add('button--loading');
            };
            const stopLoading = () => {
                payNowBtn.disabled = false;
                payNowBtn.classList.remove('button--loading');
            };
            paymentForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                startLoading();
                const nameInput = document.getElementById('card-name');
                const name = nameInput.value.trim();
                if (!name) {
                    Swal.fire({ title: 'Missing Information', text: 'Please enter the name on your card.', icon: 'warning', confirmButtonColor: '#014122' });
                    stopLoading();
                    nameInput.focus();
                    return;
                }
                if (!isCardComplete) {
                    Swal.fire({ title: 'Incomplete Card Details', text: 'Please enter your full card number, expiry date, and CVC.', icon: 'warning', confirmButtonColor: '#014122' });
                    stopLoading();
                    return;
                }
                const modal = document.getElementById('payment-modal');
                const planId = parseInt(modal.dataset.selectedPlanId || 0);
                const billingCycle = modal.dataset.billingCycle || 'monthly';
                try {
                    const response = await fetch('/stripe/create-payment-intent', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ plan_id: planId, billing_cycle: billingCycle })
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.error || 'Unable to create payment intent');
                    const result = await stripe.confirmCardPayment(data.client_secret, {
                        payment_method: { card: card, billing_details: { name: name } }
                    });
                    if (result.error) {
                        Swal.fire({ title: 'Payment Failed', text: result.error.message, icon: 'error', confirmButtonColor: '#014122' });
                        stopLoading();
                        return;
                    }
                    if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                        const confirmResp = await fetch('/stripe/confirm-payment', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({
                                payment_intent_id: data.payment_intent_id,
                                plan_id: planId,
                                billing_cycle: billingCycle,
                                payment_method_id: result.paymentIntent.payment_method
                            })
                        });
                        const confirmData = await confirmResp.json();
                        if (!confirmData.success) throw new Error(confirmData.error || 'Unable to finalize subscription on server');
                        document.getElementById('payment-modal').classList.remove('active');
                        document.getElementById('studio-plans-container').classList.remove('blur-background');
                        document.getElementById('success-modal').classList.add('active');
                        stopLoading();
                    } else {
                        Swal.fire({ title: 'Payment not completed', text: 'Payment could not be completed. Please try again.', icon: 'warning', confirmButtonColor: '#014122' });
                        stopLoading();
                    }
                } catch (err) {
                    console.error(err);
                    Swal.fire({ title: 'Error', text: err.message || 'An error occurred', icon: 'error', confirmButtonColor: '#014122' });
                    stopLoading();
                }
            });
        }

        window.onload = () => {
            const studioContainer = document.getElementById('studio-plans-container');
            renderPlans(plansFromBackend);
            document.body.style.opacity = 1;
            initializePricingPage(studioContainer);
            initStripeFlow();
            const verificationButton = document.querySelector('.start-verification-btn_studio');
            verificationButton.addEventListener('click', () => {
                let redirectUrl = '';
                if (userRole === 'artist') {
                    redirectUrl = '{{ url('user_identification') }}';
                } else if (userRole === 'studio') {
                    redirectUrl = '{{ url('studio_step_form') }}';
                }
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    console.error('Could not determine redirect URL for role:', userRole);
                }
            });
        };
    </script>
</body>

</html>
