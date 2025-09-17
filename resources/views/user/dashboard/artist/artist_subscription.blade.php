@extends('user.layouts.master')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --light-green-bg: #EBF5F0;
        --dark-green: #004D40;
        --pro-btn-bg: #8FA99F;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #ced4da;
    }

    .sub-page-wrapper {
        background-color: var(--light-green-bg);
        padding: 40px 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }

    .sub-card-container {
        background-color: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 650px;
        padding: 32px;
        box-sizing: border-box;
    }

    .card-title-heading {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: #014122;
        margin-bottom: 32px;
    }

    /* Current Plan Info Box */
    .current-plan-info {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
    }

    .current-plan-info .plan-name {
        font-size: 24px;
        font-weight: 600;
        color: #014122;
    }

    .current-plan-info .plan-details {
        color: var(--label-color);
        margin-top: 8px;
        margin-bottom: 24px;
    }

    .change-plan-btn {
        background-color: #014122;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
    }

    .cancel-link {
        display: block;
        margin-top: 16px;
        color: var(--label-color);
        font-size: 14px;
        text-decoration: underline;
        cursor: pointer;
    }

    /* Available Plans Section (initially hidden) */
    .available-plans-section {
        margin-top: 8px;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .pricing-grid {
        display: flex;
        gap: 24px;
        justify-content: center;
    }

    .pricing-card {
        background-color: #E6F4F0;
        border: 2px solid #5e8082;
        border-radius: 24px;
        box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.3), 0 0 15px rgba(11, 61, 39, 0.2);
        padding: 24px;
        flex: 1;
        max-width: 300px;
        display: flex;
        flex-direction: column;
    }

    .pricing-card.pro-tier {
        border-color: #014122;
        box-shadow: inset 0 0 15px rgba(11, 61, 39, 0.3), 0 0 15px rgba(11, 61, 39, 0.2);
    }

    .pricing-card-header {
        text-align: center;
        padding-bottom: 5px;
        border-bottom: 1px solid #b5bebe;
        margin-bottom: 10px;
    }

    .pricing-card-header h3 {
        font-size: 20px;
        color: #014122;
        margin: 0;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0 0;
        flex-grow: 1;
    }

    .features-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 14px;
        color: var(--text-color);
    }

    .features-list svg {
        width: 18px;
        height: 18px;
        fill: #5E8082;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .plan-button {
        width: 100%;
        border: none;
        padding: 12px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    .plan-button.free {
        background-color: #014122;
        color: #fff;
    }

    .plan-button.pro {
        background-color: var(--pro-btn-bg);
        color: #fff;
    }

    .plan-button:disabled {
        background-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }
</style>

@section('content')
    <div class="sub-page-wrapper">
        <div class="sub-card-container">

            <h2 class="card-title-heading">Subscription Management</h2>

            {{-- Yeh section user ka current plan dikhayega --}}
            @php
                // Yeh aap apne controller se pass karenge. Example ke liye 'pro' set hai.
                $currentUserPlan = 'pro';
            @endphp

            <div class="current-plan-info">
                <h3 class="plan-name">{{ $currentUserPlan == 'pro' ? 'Pro Tier' : 'Free Tier' }}</h3>
                <p class="plan-details">
                    Your plan renews on October 23, 2024.
                </p>
                <button id="changePlanBtn" class="change-plan-btn">Change Plan</button>
                <a href="#" class="cancel-link">Cancel Subscription</a>
            </div>

            {{-- Yeh section 'Change Plan' click karne par show hoga --}}
            <div id="available-plans-section" class="available-plans-section" style="display: none;">
                <div class="pricing-grid">

                    <!-- Free Tier Card -->
                    <div class="pricing-card">
                        <div class="pricing-card-header">
                            <h3>Free Tier</h3>
                        </div>
                        <ul class="features-list">
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> 1 active studio request at a time.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Basic guest artist profile.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Messaging with studios (limited).</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Studio calendar viewing (read-only).</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Studio seat availability view.</li>
                        </ul>
                        @if ($currentUserPlan == 'free')
                            <button class="plan-button free" disabled>Current Plan</button>
                        @else
                            <button class="plan-button free">Downgrade to Free</button>
                        @endif
                    </div>

                    <!-- Pro Tier Card -->
                    <div class="pricing-card pro-tier">
                        <div class="pricing-card-header">
                            <h3>Pro Tier</h3>
                        </div>
                        <ul class="features-list">
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Unlimited studio requests.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Full booking management tools.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Advanced guest artist profile.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Priority messaging and real-time chat.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Direct calendar integration.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> Preferred studio tagging.</li>
                            <li><svg viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg> And Much More</li>
                        </ul>
                        @if ($currentUserPlan == 'pro')
                            <button class="plan-button pro" disabled>Current Plan</button>
                        @else
                            <button class="plan-button pro">$19/month</button>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#changePlanBtn').on('click', function() {
                // slideToggle se section smoothly open/close hoga
                $('#available-plans-section').slideToggle(400);
            });
        });
    </script>
@endsection
