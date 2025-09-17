@extends('user.layouts.master')

{{-- @push('styles') --}}
<style>
    :root {
        --dark-green: #014122;
        --light-green-bg: #E6F4F0;
        --border-color: #e9ecef;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --tag-bg: #e0f2f1;
        /* Light teal for tags */
        --tag-text: #00796b;
        /* Darker teal for tag text */
        --icon-bg: #e0f2f1;
        /* Background for top-right icons */
    }

    /* Main container styling */
    .content-card {
        background-color: var(--light-green-bg);
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        box-sizing: border-box;
    }

    /* --- HEADER SECTION --- */
    .page-header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .search-bar {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-bar svg {
        position: absolute;
        left: 20px;
        width: 20px;
        height: 20px;
        fill: var(--text-light);
    }

    .search-bar input {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 12px 20px 12px 52px;
        /* Adjusted padding for icon */
        font-size: 15px;
        width: 400px;
        /* Adjusted width */
        outline: none;
        transition: border-color 0.2s;
    }

    .search-bar input:focus {
        border-color: var(--dark-green);
    }

    .upload-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 12px 24px;
        font-size: 15px;
        font-weight: 600;
        color: var(--dark-green);
        text-decoration: none;
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    .upload-btn:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .upload-btn svg {
        width: 20px;
        height: 20px;
        stroke: var(--dark-green);
    }

    /* --- TATTOO GRID --- */
    .tattoo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* --- TATTOO CARD STYLING (To match the image) --- */
    .tattoo-card {
        background-color: #ffffff;
        border-radius: 20px;
        border: 1px solid #5e808299;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .tattoo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .tattoo-image-container {
        position: relative;
        padding: 16px;
        text-align: center;

    }

    .tattoo-image-container img {
        width: 65%;
        height: auto;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        /* Use 'contain' to see the full tattoo design */
        border-radius: 12px;
    }

    .tattoo-size-tag {
        position: absolute;
        top: 26px;
        /* 16px padding + 10px */
        left: 26px;
        /* 16px padding + 10px */
        background-color: #BBDBC3;
        color: #014122;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
    }

    .tattoo-actions {
        position: absolute;
        top: 26px;
        /* 16px padding + 10px */
        right: 26px;
        /* 16px padding + 10px */
        display: flex;
        gap: 8px;
    }

    .tattoo-actions button {
        background-color: var(--icon-bg);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .tattoo-actions button:hover {
        background-color: #cce8e6;
        transform: scale(1.1);
    }

    .tattoo-actions svg {
        stroke: var(--dark-green);
    }

    .tattoo-actions svg:hover {
        transform: scale(1.1);
        /* Zoom effect */
    }

    @keyframes bell-shake {
        0% {
            transform: rotate(0deg);
        }

        10% {
            transform: rotate(15deg);
        }

        20% {
            transform: rotate(-12deg);
        }

        30% {
            transform: rotate(10deg);
        }

        40% {
            transform: rotate(-8deg);
        }

        50% {
            transform: rotate(6deg);
        }

        60% {
            transform: rotate(-4deg);
        }

        70% {
            transform: rotate(2deg);
        }

        80% {
            transform: rotate(-1deg);
        }

        90% {
            transform: rotate(1deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .tattoo-actions button:hover {
        animation: bell-shake 1s ease-in-out;
        transform-origin: center;
        /* jahan se bell hang hoti hai */
    }

    .tattoo-details-container {
        padding: 0px 20px 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .tattoo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .tattoo-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .tattoo-price {
        font-size: 22px;
        font-weight: 600;
        color: var(--dark-green);
    }

    .tattoo-subtitle {
        font-size: 14px;
        color: #333333;
        margin: 0 0 12px 0;
    }

    hr.card-divider {
        border: 0;
        border-top: 1px solid var(--border-color);
        margin: auto 0 12px;
    }

    .tattoo-description {
        font-size: 14px;
        color: #333333;
        line-height: 1.5;
        margin: 0;
        margin-top: auto;
        /* Pushes description down if card heights vary */
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .tattoo-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header-wrapper {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .search-bar input {
            width: 100%;
        }

        .tattoo-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
{{-- @endpush --}}


@section('content')
    <div class="content-card">

        <div class="page-header-wrapper">
            <div class="search-bar">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                    </path>
                </svg>
                <input type="text" placeholder="Search Tattoo">
            </div>
            <a href="#" class="upload-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                <span>Upload Flash Tattoo</span>
            </a>
        </div>

        <div class="tattoo-grid">
            @for ($i = 0; $i < 2; $i++)
                {{-- Card 1 --}}
                <div class="tattoo-card">
                    <div class="tattoo-image-container">
                        <span class="tattoo-size-tag">Small (2x2")</span>
                        <div class="tattoo-actions">
                            <button title="Share">
                                <svg width="18" height="18" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.3635 1.61523V6.61523C6.14477 7.90023 3.08852 15.1002 1.86352 21.6152C1.81727 21.8727 8.59352 14.1627 14.3635 14.1152V19.1152L24.3635 10.3652L14.3635 1.61523Z"
                                        stroke="#014122" stroke-width="1.875" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button title="Delete">
                                <svg width="18" height="18" viewBox="0 0 15 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.27034 3.75732H13.2762M5.77254 6.75879V11.261M8.774 6.75879V11.261M2.02071 3.75732L2.77107 12.7617C2.77107 13.1597 2.92918 13.5415 3.21063 13.8229C3.49207 14.1043 3.87379 14.2625 4.2718 14.2625H10.2747C10.6728 14.2625 11.0545 14.1043 11.3359 13.8229C11.6174 13.5415 11.7755 13.1597 11.7755 12.7617L12.5258 3.75732M5.02217 3.75732V1.50623C5.02217 1.30722 5.10123 1.11636 5.24195 0.975636C5.38267 0.834916 5.57353 0.755859 5.77254 0.755859H8.774C8.97301 0.755859 9.16387 0.834916 9.30459 0.975636C9.44531 1.11636 9.52437 1.30722 9.52437 1.50623V3.75732"
                                        stroke="#014122" stroke-width="1.50073" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <img src="{{ asset('assets/web/dashboard/tattoo_logo_1.jpg') }}" alt="Eye of Horus Tattoo">
                    </div>
                    <div class="tattoo-details-container">
                        <div class="tattoo-header">
                            <h4 class="tattoo-title">Eye of Horus</h4>
                            <span class="tattoo-price">$500</span>
                        </div>
                        <p class="tattoo-subtitle">Repeatable</p>
                        <hr class="card-divider">
                        <p class="tattoo-description">Focused on fine line and realism. Excellent experience and supportive
                            staff</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="tattoo-card">
                    <div class="tattoo-image-container">
                        <span class="tattoo-size-tag">Large (6x6")</span>
                        <div class="tattoo-actions">
                            <button title="Share">
                                <svg width="18" height="18" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.3635 1.61523V6.61523C6.14477 7.90023 3.08852 15.1002 1.86352 21.6152C1.81727 21.8727 8.59352 14.1627 14.3635 14.1152V19.1152L24.3635 10.3652L14.3635 1.61523Z"
                                        stroke="#014122" stroke-width="1.875" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button title="Delete">
                                <svg width="18" height="18" viewBox="0 0 15 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.27034 3.75732H13.2762M5.77254 6.75879V11.261M8.774 6.75879V11.261M2.02071 3.75732L2.77107 12.7617C2.77107 13.1597 2.92918 13.5415 3.21063 13.8229C3.49207 14.1043 3.87379 14.2625 4.2718 14.2625H10.2747C10.6728 14.2625 11.0545 14.1043 11.3359 13.8229C11.6174 13.5415 11.7755 13.1597 11.7755 12.7617L12.5258 3.75732M5.02217 3.75732V1.50623C5.02217 1.30722 5.10123 1.11636 5.24195 0.975636C5.38267 0.834916 5.57353 0.755859 5.77254 0.755859H8.774C8.97301 0.755859 9.16387 0.834916 9.30459 0.975636C9.44531 1.11636 9.52437 1.30722 9.52437 1.50623V3.75732"
                                        stroke="#014122" stroke-width="1.50073" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <img src="{{ asset('assets/web/dashboard/tattoo_logo_2.jpg') }}" alt="Floral Mandala Tattoo">
                    </div>
                    <div class="tattoo-details-container">
                        <div class="tattoo-header">
                            <h4 class="tattoo-title">Floral Mandala</h4>
                            <span class="tattoo-price">$500</span>
                        </div>
                        <p class="tattoo-subtitle">Repeatable</p>
                        <hr class="card-divider">
                        <p class="tattoo-description">Focused on fine line and realism. Excellent experience and supportive
                            staff</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="tattoo-card">
                    <div class="tattoo-image-container">
                        <span class="tattoo-size-tag">Medium (4x4")</span>
                        <div class="tattoo-actions">
                            <button title="Share">
                                <svg width="18" height="18" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.3635 1.61523V6.61523C6.14477 7.90023 3.08852 15.1002 1.86352 21.6152C1.81727 21.8727 8.59352 14.1627 14.3635 14.1152V19.1152L24.3635 10.3652L14.3635 1.61523Z"
                                        stroke="#014122" stroke-width="1.875" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button title="Delete">
                                <svg width="18" height="18" viewBox="0 0 15 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.27034 3.75732H13.2762M5.77254 6.75879V11.261M8.774 6.75879V11.261M2.02071 3.75732L2.77107 12.7617C2.77107 13.1597 2.92918 13.5415 3.21063 13.8229C3.49207 14.1043 3.87379 14.2625 4.2718 14.2625H10.2747C10.6728 14.2625 11.0545 14.1043 11.3359 13.8229C11.6174 13.5415 11.7755 13.1597 11.7755 12.7617L12.5258 3.75732M5.02217 3.75732V1.50623C5.02217 1.30722 5.10123 1.11636 5.24195 0.975636C5.38267 0.834916 5.57353 0.755859 5.77254 0.755859H8.774C8.97301 0.755859 9.16387 0.834916 9.30459 0.975636C9.44531 1.11636 9.52437 1.30722 9.52437 1.50623V3.75732"
                                        stroke="#014122" stroke-width="1.50073" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <img src="{{ asset('assets/web/dashboard/tattoo_logo_3.jpg') }}" alt="Phoenix Rebirth Tattoo">
                    </div>
                    <div class="tattoo-details-container">
                        <div class="tattoo-header">
                            <h4 class="tattoo-title">Phoenix Rebirth</h4>
                            <span class="tattoo-price">$500</span>
                        </div>
                        <p class="tattoo-subtitle">Repeatable</p>
                        <hr class="card-divider">
                        <p class="tattoo-description">Focused on fine line and realism. Excellent experience and supportive
                            staff</p>
                    </div>
                </div>
            @endfor
        </div>

    </div>
@endsection


@section('scripts')
    {{-- No scripts are needed for this specific UI as the slider and modal are removed. --}}
@endsection
