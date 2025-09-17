@extends('layouts.master')

{{-- @section('styles') --}}
{{-- Main page font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

{{-- Font for the Modal --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* This font needs to be in your public/fonts folder */
    @font-face {
        font-family: 'Arial Rounded MT Bold';
        src: url('{{ asset('assets/web/fonts/ArialRoundedMTBold.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    :root {
        --page-bg: #F8F9FA;
        --card-bg: #FFFFFF;
        --primary-green: #004D40;
        --light-green-bg: #F0F7F5;
        --border-color: #E0EBE6;
        --text-dark: #343A40;
        --text-light: #6C757D;
        --slider-track: #E0EBE6;
        --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    }

    /* General Body styles */
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--page-bg);
        margin: 0;
        color: var(--text-dark);
    }

    .adp-page-container {
        display: flex;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .adp-main-content {
        background-color: var(--card-bg);
        border-radius: 24px;
        box-shadow: var(--box-shadow);
        width: 100%;
        max-width: 500px;
        padding: 24px;
        position: relative;
    }

    .adp-header {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 24px;
    }

    .adp-card {
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .adp-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .adp-card-icon {
        background-color: var(--light-green-bg);
        border-radius: 8px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .adp-card-icon img {
        width: 45px;
        height: 45px;
    }

    .adp-card-info {
        flex-grow: 1;
    }

    .adp-card-title {
        font-weight: 600;
        font-size: 14px;
    }

    .adp-card-subtitle {
        font-size: 12px;
        color: var(--text-light);
    }

    .adp-card-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-green);
        font-weight: 600;
        cursor: pointer;
    }

    .adp-arrow-svg {
        width: 20px;
        height: 20px;
        stroke: var(--primary-green);
        transition: transform 0.3s ease;
    }

    .adp-arrow-svg.rotated {
        transform: rotate(180deg);
    }

    .adp-progress-bar {
        width: 100%;
        height: 6px;
        background-color: var(--slider-track);
        border-radius: 50px;
        margin: 12px 0;
        overflow: hidden;
    }

    .adp-progress-fill {
        width: 70%;
        /* Example progress */
        height: 100%;
        background-color: var(--primary-green);
        border-radius: 50px;
    }

    .adp-details {
        display: none;
        /* Hidden by default */
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        margin-top: 16px;
    }

    .adp-detail-item {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .adp-detail-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .adp-detail-item .label {
        color: var(--text-light);
    }

    .adp-detail-item .value {
        font-weight: 600;
    }

    .adp-past-ads-header {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-light);
        margin-top: 32px;
        margin-bottom: 12px;
    }

    .adp-past-ads-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
        margin-right: -10px;
    }

    .adp-past-ads-list::-webkit-scrollbar {
        width: 6px;
    }

    .adp-past-ads-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .adp-past-ads-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .adp-past-ads-list::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .adp-footer-btn {
        width: 100%;
        margin-top: 32px;
        padding: 16px;
        background-color: var(--primary-green);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    /* --- MODAL STYLES --- */
    .adp-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 20px;
        box-sizing: border-box;
    }

    .adp-modal-overlay.active {
        display: flex;
    }

    .adp-modal-content {
        background-color: var(--card-bg);
        border-radius: 24px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        max-width: 450px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        font-family: 'Poppins', sans-serif;
        padding: 30px;
    }

    .adp-boost-details-view .adp-modal-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .adp-boost-details-view h2 {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 20px;
        color: #0b3d27;
        margin-bottom: 8px;
    }

    .adp-boost-details-view .adp-subtitle {
        font-size: 14px;
        color: #333333;
    }

    .adp-settings-box {
        border: 1px solid #5E8082;
        border-radius: 12px;
        padding: 10px 25px 25px 25px;
        margin-bottom: 25px;
    }

    .adp-setting-item {
        margin-bottom: 25px;
    }

    .adp-setting-item:last-child {
        margin-bottom: 0;
    }

    .adp-item-header .label {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 17px;
        color: #333333;
    }

    .adp-item-header .value {
        font-size: 14px;
        color: #5E8082;
        font-weight: 500;
    }

    .adp-setting-divider {
        border-top: 1px solid #5e8082;
        margin: 20px -25px;
    }

    .adp-settings-box input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 3px;
        background: #e0e7e5;
        border-radius: 5px;
        outline: none;
        margin-top: 15px;
    }

    .adp-settings-box input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: #0b3d27;
        border-radius: 50%;
        cursor: pointer;
    }

    .adp-budget-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .adp-budget-item .label-group .label {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 17px;
        color: #333333;
    }

    .adp-budget-item .label-group .sublabel {
        font-size: 14px;
        color: #5E8082;
        margin-top: 4px;
    }

    .adp-budget-item .value-group {
        text-align: right;
    }

    .adp-budget-item .value-group .price {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 17px;
    }

    .adp-budget-item .value-group .sublabel {
        font-size: 14px;
        color: #5E8082;
        margin-top: 4px;
    }

    .adp-payment-section h3 {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 17px;
        margin-bottom: 16px;
        text-align: left;
    }

    .adp-payment-method-box {
        border: 1px solid #014122;
        border-radius: 12px;
        padding: 18px 20px;
        text-align: left;
    }

    .adp-payment-method-header {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        font-size: 17px;
        color: #333333;
        margin-bottom: 20px;
    }

    .adp-payment-method-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .adp-card-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .adp-visa-logo {
        width: 35px;
    }

    .adp-card-name {
        font-size: 15px;
        color: #014122;
    }

    .adp-card-fund {
        font-size: 12px;
        color: #5E8082;
        margin-top: 4px;
    }

    .adp-change-link {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        color: #014122;
        text-decoration: underline;
        font-size: 16px;
    }

    .adp-info-text {
        font-size: 13px;
        color: #333333;
        line-height: 1.6;
        text-align: left;
        margin-top: 16px;
    }

    .adp-boost-post-btn {
        width: 100%;
        background-color: #014122;
        color: white;
        padding: 16px;
        border-radius: 50px;
        border: none;
        font-size: 16px;
        font-family: 'Arial Rounded MT Bold', sans-serif;
        cursor: pointer;
        margin-top: 24px;
    }

    /* == CORRECTED & STYLED: Success Modal == */
    .adp-success-modal-content {
        text-align: center;
        font-family: 'Inter', sans-serif;
        padding: 32px 24px;
    }

    .adp-success-icon {
        width: 130px;
        /* Increased image size */
        height: auto;
        margin-bottom: 20px;
    }

    .adp-success-modal-content h2 {
        font-family: 'Arial Rounded MT Bold', sans-serif;
        /* Special font for heading */
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 16px;
    }

    .adp-success-modal-content p {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 32px;
        max-width: 90%;
        margin-left: auto;
        margin-right: auto;
    }

    .adp-success-modal-content .adp-continue-btn {
        width: 100%;
        background-color: var(--primary-green);
        color: white;
        padding: 16px;
        border-radius: 50px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
    }
</style>
{{-- @endsection --}}

@section('content')
    <div class="adp-page-container">
        <div class="adp-main-content">
            <h2 class="adp-header">Ads & Promotions</h2>

            <div class="adp-card">
                <div class="adp-card-header">
                    <div class="adp-card-icon">
                        <img src="{{ asset('assets/web/studio-icon-logo.png') }}" alt="Studio Icon">
                    </div>
                    <div class="adp-card-info">
                        <div class="adp-card-title">In Process</div>
                        <div class="adp-card-subtitle">4 Days Remaining</div>
                    </div>
                    <div class="adp-card-actions adp-details-toggle">
                        <span>Stop</span>
                        <svg class="adp-arrow-svg" fill="none" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="adp-progress-bar">
                    <div class="adp-progress-fill"></div>
                </div>
                <div class="adp-details">
                    <div class="adp-detail-item"><span class="label">Status</span><span class="value">In Process</span>
                    </div>
                    <div class="adp-detail-item"><span class="label">Date</span><span class="value">June 14 - June
                            30</span></div>
                    <div class="adp-detail-item"><span class="label">Reach</span><span class="value">34,785</span></div>
                    <div class="adp-detail-item"><span class="label">Spend</span><span class="value">$15</span></div>
                    <div class="adp-detail-item"><span class="label">Like & reactions</span><span
                            class="value">6,780</span></div>
                    <div class="adp-detail-item"><span class="label">Duration</span><span class="value">15 Days</span>
                    </div>
                </div>
            </div>

            <h3 class="adp-past-ads-header">Past Ads</h3>
            <div class="adp-past-ads-list">
                <div class="adp-card">
                    <div class="adp-card-header">
                        <div class="adp-card-icon">
                            <img src="{{ asset('assets/web/studio-icon-logo.png') }}" alt="Studio Icon">
                        </div>
                        <div class="adp-card-info">
                            <div class="adp-card-title">Expired</div>
                            <div class="adp-card-subtitle">June 14 - June 30</div>
                        </div>
                        <div class="adp-card-actions adp-details-toggle">
                            <span>Boost Again</span>
                            <svg class="adp-arrow-svg" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="adp-details">
                        <div class="adp-detail-item"><span class="label">Status</span><span class="value">Expired</span>
                        </div>
                        <div class="adp-detail-item"><span class="label">Date</span><span class="value">June 14 - June
                                30</span></div>
                    </div>
                </div>
            </div>

            <button class="adp-footer-btn" id="open-boost-modal">Boost Your Studio</button>
        </div>
    </div>

    <!-- Modal 1: Boost Your Studio -->
    <div class="adp-modal-overlay" id="boost-modal">
        <div class="adp-modal-content">
            <div class="adp-boost-details-view">
                <div class="adp-modal-header">
                    <h2>Boost Your Studio</h2>
                    <p class="adp-subtitle">Put your studio in front of more guests, faster.</p>
                </div>
                <div class="adp-settings-box">
                    <div class="adp-setting-item">
                        <div class="adp-item-header">
                            <span class="label">Set Durations</span>
                            <span id="duration-value" class="value">15 Days</span>
                        </div>
                        <input type="range" min="1" max="30" value="15" id="duration-slider">
                    </div>
                    <div class="adp-setting-divider"></div>
                    <div class="adp-setting-item adp-budget-item">
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
                <div class="adp-payment-section">
                    <h3>Add Credit/Debit Cards</h3>
                    <div class="adp-payment-method-box">
                        <div class="adp-payment-method-header">Payment Method</div>
                        <div class="adp-payment-method-details">
                            <div class="adp-card-info">
                                <img class="adp-visa-logo" src="{{ asset('assets/web/extra/visa_logo.png') }}" alt="Visa Card Logo">
                                <div>
                                    <div class="adp-card-name">Visa Card</div>
                                    <div class="adp-card-fund">Fund Available $12,256</div>
                                </div>
                            </div>
                            <a href="#" class="adp-change-link">Change</a>
                        </div>
                    </div>
                </div>
                <p class="adp-info-text">We'll deduct funds about once a day when you run ads. If funds run out, your ads
                    will be paused.</p>
                <p class="adp-info-text">Ads are reviewed within 24 hours... a pause spending at any time.</p>
                <button class="adp-boost-post-btn" id="boost-post-action">Boost Post</button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Success Message -->
    <div class="adp-modal-overlay" id="success-modal">
        <div class="adp-modal-content adp-success-modal-content">
            {{-- Make sure this path is correct in your project --}}
            <img src="{{ asset('assets/web/thumbs_up.png') }}" alt="Thumbs Up" class="adp-success-icon">
            <h2>Studio Boosted Successfully!</h2>
            <p>We'll notify you once it's approved and starts reaching your selected audience. You can track performance or
                make edits anytime from your Ads Manager.</p>
            <button class="adp-continue-btn" id="continue-btn">Continue</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const boostModal = $('#boost-modal');
            const successModal = $('#success-modal');
            const openBoostModalBtn = $('#open-boost-modal');
            const boostPostBtn = $('#boost-post-action');
            const continueBtn = $('#continue-btn');
            const durationSlider = $('#duration-slider');
            const durationValue = $('#duration-value');

            function openModal(modal) {
                modal.addClass('active');
            }

            function closeModal(modal) {
                modal.removeClass('active');
            }

            openBoostModalBtn.on('click', function() {
                openModal(boostModal);
            });
            boostPostBtn.on('click', function() {
                closeModal(boostModal);
                openModal(successModal);
            });
            continueBtn.on('click', function() {
                closeModal(successModal);
            });

            $('.adp-modal-overlay').on('click', function(event) {
                if ($(event.target).is('.adp-modal-overlay')) {
                    closeModal($(this));
                }
            });

            durationSlider.on('input', function() {
                durationValue.text(`${$(this).val()} Days`);
            });

            $('.adp-details-toggle').on('click', function() {
                const parentCard = $(this).closest('.adp-card');
                parentCard.find('.adp-details').slideToggle(300);
                parentCard.find('.adp-arrow-svg').toggleClass('rotated');
            });
        });
    </script>
@endsection
