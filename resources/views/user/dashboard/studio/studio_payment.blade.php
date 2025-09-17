@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --dark-green: #004D40;
        --selected-bg: #E6F4F0;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #ced4da;
    }

    .payments-page-wrapper {
        background-color: var(--light-green-bg);
        padding: 40px 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }

    .payments-card-container {
        background-color: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 500px;
        /* Iski width thori kam hai */
        padding: 32px;
        margin: 0 auto;
        /* Horizontally center karne ke liye */
        box-sizing: border-box;
    }

    .card-title-heading {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: #014122;
        margin-bottom: 32px;
    }

    /* Saved Payment Methods */
    .payment-method-box {
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .payment-method-box.selected {
        background-color: var(--selected-bg);
        border-color: var(--dark-green);
    }

    .card-logo-payment {
        width: 35px;
        height: 20px;
    }

    .card-details {
        flex-grow: 1;
    }

    .card-details .name {
        font-weight: 600;
        font-size: 16px;
    }

    .card-details .number {
        color: var(--label-color);
        font-size: 14px;
    }

    .checkmark-icon {
        width: 24px;
        height: 24px;
        fill: var(--dark-green);
        display: none;
        /* Shuru mein hidden */
    }

    .payment-method-box.selected .checkmark-icon {
        display: block;
        /* Selected hone par dikhao */
    }

    hr {
        border: 0;
        border-top: 1px solid var(--border-color);
        margin: 32px 0;
    }

    /* Add Card Form */
    .form-section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .input-field {
        border: 1px solid #5e8082;
        border-radius: 12px;
        padding: 8px 16px;
        margin-bottom: 16px;
    }

    .input-field .label {
        display: block;
        font-size: 12px;
        color: #5e8082;
        margin-bottom: 2px;
    }

    .input-field input {
        width: 100%;
        border: none;
        padding: 0;
        font-size: 15px;
        font-weight: 500;
    }

    .input-field input:focus {
        outline: none;
    }

    .input-field input::placeholder {
        color: #ccc;
    }

    .form-row {
        display: flex;
        gap: 16px;
    }

    .form-row .input-field {
        flex: 1;
    }

    /* Taake dono fields barabar space lein */

    .add-card-btn {
        width: 100%;
        background-color: #014122;
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 16px;
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="payments-page-wrapper">

        <div class="payments-card-container">

            <h2 class="card-title-heading">Payments Methods</h2>

            {{-- Saved Cards List --}}
            <div class="saved-cards-list">
                <div class="payment-method-box selected">
                    <img src="{{ asset('assets/web/extra/visa_icon.svg') }}" alt="Visa Logo" class="card-logo-payment">
                    <div class="card-details">
                        <span class="name" style="color:#014122;">Visa Card</span>
                        <br>
                        <span class="number">**** **** **** 7867</span>
                    </div>
                    <svg class="checkmark-icon" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                    </svg>
                </div>

                <div class="payment-method-box">
                    <img src="{{ asset('assets/web/extra/mastercard_icon.svg') }}" alt="Mastercard Logo" class="card-logo-payment">
                    <div class="card-details">
                        <span class="name" style="color:#014122;">Mastercard Card</span>
                        <br>
                        <span class="number">**** **** **** 7867</span>
                    </div>
                    <svg class="checkmark-icon" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                    </svg>
                </div>
            </div>

            <hr>

            {{-- Add Card Form --}}
            <form>
                {{--            @csrf --}}
                <h3 class="form-section-title">Add Credit/Debit Cards</h3>

                <div class="input-field">
                    <label for="card_number" class="label">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="Enter Your Card Number">
                </div>

                <div class="form-row">
                    <div class="input-field">
                        <label for="expiry_date" class="label">Expiry Date</label>
                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                    </div>
                    <div class="input-field">
                        <label for="cvc" class="label">Security Code</label>
                        <input type="text" id="cvc" name="cvc" placeholder="CVC">
                    </div>
                </div>

                <button type="submit" class="add-card-btn">Add Card</button>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.payment-method-box').on('click', function() {
                // Sab cards se 'selected' class hatao
                $('.payment-method-box').removeClass('selected');

                // Sirf click kiye gaye card par 'selected' class lagao
                $(this).addClass('selected');

                // Optional: Aap yahan backend ko call bhej sakte hain default card change karne ke liye
                // var cardId = $(this).data('id'); // Agar aapne div mein data-id="123" rakha hai
                // $.post('/set-default-card', { card_id: cardId });
            });
        });
    </script>
@endsection
