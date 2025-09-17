<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="/guestly_favicon.png">

    <!-- Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


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
            src: url('/fonts/ArialRoundedMTBold.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            /*font-family: 'Poppins', sans-serif;*/

            font-family: 'Arial Rounded MT Bold', sans-serif;
            /*font-family: 'Varela Round', sans-serif;*/

            background-color: var(--bg-color);
            color: var(--text-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 700px;
            padding: 20px;
            transition: filter 0.3s ease;
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

        /* === START: YAHAN SE TOGGLE SWITCH KA NAYA CODE HAI === */

        .billing-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            font-size: 16px;
            user-select: none;
            /* ROKTA HAI TEXT KO SELECT HONE SE */
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: 500;
        }

        /* YEH SPAN (TEXT) KO SMOOTH BANAYEGA */
        .billing-toggle span {
            transition: color 0.4s ease, font-weight 0.4s ease;
            cursor: pointer;
        }

        /* DEFAULT STATE: (MONTHLY ACTIVE) */
        .billing-toggle span:first-of-type {
            color: #014122;
            font-weight: 500;
        }

        .billing-toggle span:last-of-type {
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* CHECKED STATE: (YEARLY ACTIVE) - :has() ka istemal kiya hai */
        .billing-toggle:has(input:checked) span:first-of-type {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .billing-toggle:has(input:checked) span:last-of-type {
            color: var(--text-primary);
            font-weight: 500;
        }

        /* YEH SWITCH KA VISUAL HAI, SAME TO SAME IMAGE JAISA */
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
            /* TRACK KA COLOR */
            transition: .4s;
            border-radius: 10px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 30px;
            /* HANDLE KA SIZE */
            width: 30px;
            /* HANDLE KA SIZE */
            left: -5px;
            bottom: -6px;
            background-color: #e6f4f0;
            /* HANDLE KE ANDAR KA COLOR */
            border: 3px solid var(--primary-green);
            /* BORDER JISSE HOLLOW LOOK AAYEGA */
            box-sizing: border-box;
            /* IMPORTANT: Border ko size me include karne ke liye */
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
            /* SLIDE HONE KA DISTANCE */
        }

        /* === END: TOGGLE SWITCH KA NAYA CODE YAHAN KHATAM HOTA HAI === */

        .pricing-container {
            display: flex;
            gap: 30px;
            width: 100%;
        }

        /*.plan-card { flex: 1; background-color: var(--bg-color); border: 2px solid var(--border-inactive); border-radius: 25px; display: flex; flex-direction: column; cursor: pointer; transition: border-color 0.3s ease, box-shadow 0.3s ease; position: relative; padding: 30px; padding-bottom: 50px; }*/
        /*.plan-card.active { border-color: var(--border-active); box-shadow: 0 0 15px rgba(11, 61, 39, 0.2); transform: scale(1.02); }*/
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
            padding: 30px;
            padding-bottom: 50px;
            box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.1),
                /* light inner shadow */
                0 0 10px rgba(11, 61, 39, 0.05);
            /* light outer shadow */
        }

        .plan-card.active {
            border-color: #014122;
            box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.3),
                /* green inner shadow */
                0 0 15px rgba(11, 61, 39, 0.2);
            /* outer glow shadow */
            transform: scale(1.02);
        }

        .plan-card h3 {
            font-size: 25px;
            font-weight: 500;
            margin: 0 0 15px 0;
            text-align: center;
            color: var(--text-secondary);
            transition: color 0.3s ease;
        }

        .plan-card.active h3 {
            color: #014122;
        }

        /*.plan-card hr { border: 0; height: 1px; background-color: #5E8082; margin: 0 auto 20px auto; width: 100%; }*/
        /*.features-list { list-style: none; padding: 0; margin: 0; color: var(--text-secondary); font-size: 14px; transition: color 0.3s ease; }*/
        /*.plan-card.active .features-list { color: var(--text-primary); }*/
        /*.features-list li { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; line-height: 1.5; }*/
        /*.features-list li .tick-icon { color: var(--primary-green); flex-shrink: 0; margin-top: 3px; }*/
        .plan-card hr {
            border: 0;
            height: 1px;
            background-color: #b0c4c4;
            /* light color for inactive */
            margin: 0 auto 20px auto;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .plan-card.active hr {
            background-color: #5E8082;
            /* dark color for active */
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            color: var(--text-secondary);
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
            /* adjust for your PNG */
            height: 12px;
            flex-shrink: 0;
            margin-top: 6px;
            opacity: 0.5;
            /* default dim */
            transition: opacity 0.3s ease;
        }

        .plan-card.active .tick-icon {
            opacity: 1;
            /* full lightup when active */
        }

        .plan-card {
            cursor: pointer;
        }

        .plan-button {
            position: absolute;
            bottom: -28px;
            left: 50%;
            transform: translateX(-50%);
            width: 55%;
            height: 55px;
            padding: 17px;
            border: none;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 50px;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .plan-card.active .plan-button {
            background-color: #014122;
            color: white;
        }

        .plan-card:not(.active) .plan-button {
            background-color: var(--secondary-green);
            color: white;
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

        .start-verification-btn {
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

        @media (max-width: 650px) {
            .pricing-container {
                flex-direction: column;
            }

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

    <div class="main-container">
        <!-- Plan selection page HTML -->
        {{--    <div class="header"><h1>Choose your plan</h1><p>Upgrade and downgrade at anytime</p></div><div class="billing-toggle"><span>Monthly</span><label class="switch"><input type="checkbox" id="billing-cycle-toggle"><span class="slider"></span></label><span>Yearly</span></div><div class="pricing-container"><div class="plan-card active"><h3>Free Tier</h3><hr><ul class="features-list"><li><span class="tick-icon">✓</span> 1 active studio request at a time.</li><li><span class="tick-icon">✓</span> Basic guest artist profile.</li><li><span class="tick-icon">✓</span> Messaging with studios (limited).</li><li><span class="tick-icon">✓</span> Studio calendar viewing (read-only).</li><li><span class="tick-icon">✓</span> Studio seat availability view.</li></ul><button class="plan-button">Free</button></div><div class="plan-card"><h3>Pro Tier</h3><hr><ul class="features-list"><li><span class="tick-icon">✓</span> Unlimited studio requests.</li><li><span class="tick-icon">✓</span> Full booking management tools.</li><li><span class="tick-icon">✓</span> Advanced guest artist profile.</li><li><span class="tick-icon">✓</span> Priority messaging and real-time chat.</li><li><span class="tick-icon">✓</span> Direct calendar integration.</li><li><span class="tick-icon">✓</span> Preferred studio tagging.</li><li><span class="tick-icon">✓</span> And Much More</li></ul><button class="plan-button" id="pro-tier-price">$19/month</button></div></div> --}}
        <div class="header">
            <h1>Choose your plan</h1>
            <p>Upgrade and downgrade at anytime</p>
        </div>

        <div class="billing-toggle">
            <span>Monthly</span>
            <label class="switch">
                <input type="checkbox" id="billing-cycle-toggle">
                <span class="slider"></span>
            </label>
            <span>Yearly</span>
        </div>

        <div class="pricing-container">
            <div class="plan-card active">
                <h3>Free Tier</h3>
                <hr>
                <ul class="features-list">
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> 1 active studio request at a
                        time.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Basic guest artist profile.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Messaging with studios (limited).
                    </li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Studio calendar viewing
                        (read-only).</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Studio seat availability view.
                    </li>
                </ul>
                <button class="plan-button">Free</button>
            </div>

            <div class="plan-card">
                <h3>Pro Tier</h3>
                <hr>
                <ul class="features-list">
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Unlimited studio requests.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Full booking management tools.
                    </li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Advanced guest artist profile.
                    </li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Priority messaging and real-time
                        chat.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Direct calendar integration.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> Preferred studio tagging.</li>
                    <li><img src="/extra/vector.png" alt="tick" class="tick-icon"> And Much More</li>
                </ul>
                <button class="plan-button" id="pro-tier-price">$19/month</button>
            </div>
        </div>
        <button class="continue-btn" id="open-modal-btn">Continue</button>
    </div>

    <!-- PAYMENT MODAL HTML -->
    <div class="modal-overlay" id="payment-modal">
        <div class="modal-content">
            <form>
                <h2>Buy Subscription</h2>
                <div class="payment-methods">
                    <div class="method-card active">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg"
                            alt="Visa">
                    </div>
                    <div class="method-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg"
                            alt="Mastercard">
                    </div>
                    <div class="method-card"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                            alt="PayPal">
                    </div>
                </div>
                <div class="form-group">
                    <label for="card-name">Name on card</label>
                    <input type="text" id="card-name" value="John doe">
                </div>
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" placeholder="Enter Your Card Number">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry-date">Expiry Date</label>
                        <input type="text" id="expiry-date" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label for="cvc">Security Code</label>
                        <input type="text" id="cvc" placeholder="CVC">
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <span class="price">$19/month</span>
                    <button class="pay-now-btn">Pay Now</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SUCCESS MODAL HTML -->
    <div class="modal-overlay" id="success-modal">
        <div class="modal-content success-modal-content">

            <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Success Thumbs Up">

            <h2>You're Subscribed!</h2>
            <p>Your Free subscription is now active. You're all set to start requesting studio spots, managing your
                bookings, and showcasing your profile like a pro.</p>
            <button class="start-verification-btn" onclick="window.location.href='user_identification'">Start
                Verification</button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainContainer = document.querySelector('.main-container');
            const planCards = document.querySelectorAll('.plan-card');
            const openModalBtn = document.getElementById('open-modal-btn');
            const paymentModal = document.getElementById('payment-modal');
            const successModal = document.getElementById('success-modal');
            const payNowBtn = document.querySelector('.pay-now-btn');
            const billingToggle = document.getElementById('billing-cycle-toggle');

            const proTierPriceBtn = document.getElementById('pro-tier-price');
            const modalPrice = document.querySelector('.modal-footer .price');

            const successHeading = successModal.querySelector('h2');
            const successParagraph = successModal.querySelector('p');

            // Monthly and yearly prices
            const monthlyPrice = "$19/month";
            const yearlyPrice = "$199/year";

            // Function to update price based on toggle
            const updatePrice = () => {
                const isYearly = billingToggle.checked;
                const price = isYearly ? yearlyPrice : monthlyPrice;

                // Update button and modal price
                proTierPriceBtn.innerText = price;
                modalPrice.innerText = price;
            };

            billingToggle.addEventListener('change', updatePrice);

            planCards.forEach(card => {
                card.addEventListener('click', () => {
                    planCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');
                });
            });

            openModalBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const activePlan = document.querySelector('.plan-card.active h3').innerText.trim();

                if (activePlan === 'Free Tier') {
                    successHeading.innerText = "You're Subscribed!";
                    successParagraph.innerText =
                        "Your Free Tier subscription is now active. You can start requesting studio spots with limited features. Upgrade anytime to unlock full booking management tools.";
                    successModal.classList.add('active');
                    mainContainer.classList.add('blur-background');
                } else {
                    updatePrice(); // ensure modal shows correct price
                    paymentModal.classList.add('active');
                    mainContainer.classList.add('blur-background');
                }
            });

            payNowBtn.addEventListener('click', (e) => {
                e.preventDefault();
                paymentModal.classList.remove('active');

                successHeading.innerText = "You're Subscribed!";
                successParagraph.innerText =
                    "Your Pro Tier subscription is now active. You're all set to start requesting studio spots, managing your bookings, and showcasing your profile like a pro.";

                successModal.classList.add('active');
            });

            paymentModal.addEventListener('click', (e) => {
                if (e.target === paymentModal) {
                    paymentModal.classList.remove('active');
                    mainContainer.classList.remove('blur-background');
                }
            });

            successModal.addEventListener('click', (e) => {
                if (e.target === successModal) {
                    successModal.classList.remove('active');
                    mainContainer.classList.remove('blur-background');
                }
            });

            // Initialize price on load
            updatePrice();
        });

        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>

</body>

</html>
