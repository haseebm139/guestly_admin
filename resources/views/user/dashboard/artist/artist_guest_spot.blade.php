@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<style>
    :root {
        --dark-green: #014122;
        --border-color: #e9ecef;
        --text-dark: #1f2937;
        --text-light: #6b7280;
    }

    /* Main Container Card */
    .content-card {
        background-color: #E6F4F0;
        /* Main card ka background white */
        border-radius: 24px;
        /*box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);*/
        padding: 32px;
        width: 100%;
        box-sizing: border-box;
    }

    /* --- HEADER SECTION (Wapas add kiya gaya) --- */
    .page-header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title-wrapper {
        font-size: 20px;
        font-weight: 600;
        color: var(--dark-green);
    }

    .header-actions {
        display: flex;
        gap: 16px;
    }

    .search-bar {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-bar svg {
        position: absolute;
        left: 16px;
        width: 20px;
        height: 20px;
        fill: var(--text-light);
    }

    .search-bar input {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 12px 16px 12px 48px;
        font-size: 15px;
        width: 300px;
    }

    .upload-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 12px 20px;
        font-size: 15px;
        font-weight: 600;
        color: var(--dark-green);
        text-decoration: none;
    }

    .upload-btn svg {
        width: 20px;
        height: 20px;
        stroke: var(--dark-green);
    }

    /* Grid Layout */
    .spots-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* --- STUDIO CARD STYLING (Bilkul image jaisi) --- */
    .studio-card-wrapper {
        background-color: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .card_image_wrapper {
        position: relative;
        padding: 10px;
        /* Yeh image ke gird white gap banayega */
    }

    .swiper_slider img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        /* Image ke corners ko round karega */
    }

    .swiper-pagination {
        bottom: 20px !important;
    }

    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.7);
        width: 8px;
        height: 8px;
        opacity: 1;
    }

    .swiper-pagination-bullet-active {
        background: var(--dark-green);
    }

    .card-actions {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 8px;
        z-index: 10;
    }

    .card-actions button {
        background: #d5f3f1;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .card-actions svg {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth hover */
        stroke: var(--dark-green);
    }

    .card-actions svg:hover {
        transform: scale(1.2);
        /* Zoom effect */
    }

    /* Shake animation */
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

    .card-actions button:hover {
        animation: bell-shake 1s ease-in-out;
        transform-origin: center;
        /* jahan se bell hang hoti hai */
    }

    .card_content_wrapper {
        padding: 16px;
        padding-top: 0;
        flex-grow: 1;
    }

    .card-header-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-logo-wrapper {
        height: 40px;
        width: 40px;
        border-radius: 50%;
    }

    .card_location_wrapper p {
        font-weight: 600;
        font-size: 16px;
        color: var(--text-dark);
        margin: 0;
    }

    .card_location_wrapper span {
        font-size: 13px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .card_location_wrapper span svg {
        width: 14px;
        height: 14px;
        fill: var(--text-light);
    }

    hr.card-divider {
        border: 0;
        border-top: 1px solid var(--border-color);
        margin: 16px 0;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #333333;
    }

    .date-info svg {
        width: 16px;
        height: 16px;
    }

    .description {
        font-size: 13px;
        color: var(--text-dark);
        line-height: 1.5;
        margin-top: 8px;
    }

    .card-footer {
        padding: 16px;
        padding-top: 0;
    }

    .view-details-btn {
        width: 100%;
        background: #014122;
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .spots-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .spots-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .search-bar input {
            width: 100%;
        }
    }

    /* =================================================== */
    /* ============== NEW MODAL STYLES HERE ============== */
    /* =================================================== */
    /*.edit-guest-modal-overlay {*/
    /*    position: fixed; top: 0; left: 70px; width: 100%; height: 100%;*/
    /*    background-color: rgba(0, 0, 0, 0.6);*/
    /*    display: none; justify-content: center; align-items: center;*/
    /*    z-index: 1000; padding: 20px; box-sizing: border-box;*/
    /*    -webkit-backdrop-filter: blur(8px);*/
    /*    backdrop-filter: blur(8px);*/
    /*    transition: opacity 0.3s ease, visibility 0s 0.3s, backdrop-filter 0.3s ease;*/
    /*}*/
    .edit-guest-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        /* ✅ yahan 0 kar do */
        width: 100%;
        /* ✅ full width lega */
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 20px;
        box-sizing: border-box;
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        transition: opacity 0.3s ease, visibility 0s 0.3s, backdrop-filter 0.3s ease;
    }

    .sidebar.blur {
        filter: blur(8px);
        transition: filter 0.3s ease;
    }

    body.modal-open {
        overflow: hidden;
    }

    .edit-guest-modal-content {
        background-color: #fff;
        padding: 24px;
        border-radius: 24px;
        width: 100%;
        max-width: 550px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        display: flex;
        flex-direction: column;
        max-height: 70vh;
        /* Modal ki max height set ki */
    }

    .edit-guest-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .edit-guest-modal-title {
        font-size: 22px;
        font-weight: 700;
        margin-left: 80px;
        color: var(--dark-green);
    }

    .edit-guest-modal-close-btn {
        background-color: var(--dark-green);
        color: #fff;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        line-height: 1;
    }

    .edit-guest-modal-image-wrapper {
        position: relative;
        margin-bottom: 24px;
    }

    .edit-guest-modal-image-wrapper .main-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 16px;
    }

    .edit-guest-modal-image-overlay {
        position: absolute;
        bottom: 0;
        left: 60px;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        border-radius: 0 0 16px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .edit-guest-modal-image-overlay .logo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .edit-guest-modal-image-overlay .studio-info p {
        margin: 0;
        color: #fff;
        font-weight: 600;
        font-size: 18px;
    }

    .edit-guest-modal-image-overlay .studio-info span {
        margin: 0;
        color: #e0e0e0;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .edit-guest-modal-image-overlay .studio-info span svg {
        width: 14px;
        height: 14px;
        fill: #fff;
    }

    .edit-guest-modal-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
        overflow-y: auto;
        flex-grow: 1;
        padding-right: 10px;
    }

    .edit-guest-modal-form-group {
        border: 1px solid #5e8082;
        border-radius: 12px;
        padding: 12px 16px;
        position: relative;
    }

    .edit-guest-modal-form-group.textarea-group {
        padding-bottom: 50px;
    }

    .edit-guest-modal-form-group label {
        font-size: 12px;
        color: #5e8082;
        display: block;
        margin-bottom: 4px;
    }

    .edit-guest-modal-form-group .value-display {
        font-size: 15px;
        font-weight: 500;
        color: var(--text-dark);
        width: calc(100% - 50px);
    }

    .edit-guest-modal-form-group .value-input {
        font-size: 15px;
        font-weight: 500;
        color: var(--text-dark);
        border: none;
        outline: none;
        padding: 0;
        width: calc(100% - 50px);
        background: transparent;
        font-family: inherit;
    }

    .edit-guest-modal-form-group textarea {
        width: 100%;
        border: none;
        outline: none;
        resize: none;
        font-size: 15px;
        color: var(--text-dark);
        padding: 0;
        font-family: inherit;
        background: transparent;
    }

    .edit-guest-modal-form-group .edit-link {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: 600;
        color: var(--dark-green);
        text-decoration: none;
        cursor: pointer;
    }

    .edit-guest-modal-date-fields {
        display: flex;
        gap: 16px;
    }

    .edit-guest-modal-date-fields .edit-guest-modal-form-group {
        flex: 1;
    }

    .edit-guest-modal-form-group .update-btn {
        position: absolute;
        bottom: 12px;
        right: 16px;
        background: #e6f4f0;
        color: var(--dark-green);
        border: 1px solid #b2dfdb;
        border-radius: 50px;
        padding: 6px 16px;
        font-weight: 600;
        cursor: pointer;
    }

    .edit-guest-modal-footer {
        margin-top: 24px;
        flex-shrink: 0;
    }

    .edit-guest-modal-footer .rebook-btn {
        width: 100%;
        background: var(--dark-green);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    /* =================================================== */
    /* === STYLES FOR NEW SECTIONS IN MODAL (AS PER IMAGE) === */
    /* =================================================== */
    .modal-section {
        margin-top: 24px;
        border-top: 1px solid var(--border-color);
        padding-top: 24px;
    }

    .modal-section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
    }

    .client-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .client-list-item {
        display: flex;
        align-items: center;
    }

    .client-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 16px;
    }

    .client-name {
        font-size: 16px;
        color: var(--text-dark);
        flex-grow: 1;
    }

    .client-request-link {
        font-size: 15px;
        font-weight: 600;
        color: var(--dark-green);
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
    }

    .portfolio-grid img {
        width: 100%;
        height: auto;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 12px;
    }
</style>
{{-- @endpush --}}


@section('content')
    <div class="content-card">

        <div class="page-header-wrapper">
            <h2 class="page-title-wrapper">Past Guest Spots</h2>
            <div class="header-actions">
                <div class="search-bar">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                        </path>
                    </svg>
                    <input type="text" placeholder="Where are you guesting next?">
                </div>
                <a href="#" class="upload-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <span>Upload Your Experience</span>
                </a>
            </div>
        </div>

        <div class="spots-grid">
            @for ($i = 0; $i < 6; $i++)
                <div class="studio-card-wrapper">
                    <div class="card_image_wrapper">
                        <div class="swiper swiper_slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_1_profile.jpg') }}"
                                        alt="Studio Image"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_2_profile.jpg') }}"
                                        alt="Studio Image"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_3_profile.jpg') }}"
                                        alt="Studio Image"></div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="card-actions">
                            <button title="Edit" class="js-open-edit-guest-modal">
                                <svg width="20" height="20" viewBox="0 0 19 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.00282 5.75742H4.25246C3.85444 5.75742 3.47272 5.91553 3.19128 6.19697C2.90984 6.47841 2.75172 6.86013 2.75172 7.25815V14.0114C2.75172 14.4095 2.90984 14.7912 3.19128 15.0726C3.47272 15.3541 3.85444 15.5122 4.25246 15.5122H11.0058C11.4038 15.5122 11.7855 15.3541 12.0669 15.0726C12.3484 14.7912 12.5065 14.4095 12.5065 14.0114V13.2611M11.7561 4.25668L14.0072 6.50778M15.0465 5.446C15.342 5.15047 15.508 4.74965 15.508 4.33171C15.508 3.91377 15.342 3.51294 15.0465 3.21741C14.7509 2.92189 14.3501 2.75586 13.9322 2.75586C13.5142 2.75586 13.1134 2.92189 12.8179 3.21741L6.50356 9.50924V11.7603H8.75465L15.0465 5.446Z"
                                        stroke="#014122" stroke-width="1.50073" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button title="Delete">
                                <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.27034 3.75732H13.2762M5.77254 6.75879V11.261M8.774 6.75879V11.261M2.02071 3.75732L2.77107 12.7617C2.77107 13.1597 2.92918 13.5415 3.21063 13.8229C3.49207 14.1043 3.87379 14.2625 4.2718 14.2625H10.2747C10.6728 14.2625 11.0545 14.1043 11.3359 13.8229C11.6174 13.5415 11.7755 13.1597 11.7755 12.7617L12.5258 3.75732M5.02217 3.75732V1.50623C5.02217 1.30722 5.10123 1.11636 5.24195 0.975636C5.38267 0.834916 5.57353 0.755859 5.77254 0.755859H8.774C8.97301 0.755859 9.16387 0.834916 9.30459 0.975636C9.44531 1.11636 9.52437 1.30722 9.52437 1.50623V3.75732"
                                        stroke="#014122" stroke-width="1.50073" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="card_content_wrapper">
                        <div class="card-header-wrapper">
                            <img src="{{ asset('assets/web/dashboard/default_1.png') }}" alt="Studio Logo" class="card-logo-wrapper">
                            <div class="card_location_wrapper">
                                <p>The Inkwell Studio</p>
                                <span>
                                    <img src="{{ asset('assets/web/extra/location_logo.png') }}" alt="Location"
                                        style="width: 16px; height: 16px; vertical-align: middle;">
                                    San Diego, California, USA
                                </span>
                            </div>
                        </div>

                        <hr class="card-divider">

                        <div class="date-info">
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9125 23.4548H3.51473C2.85918 23.4548 2.23048 23.1944 1.76693 22.7309C1.30339 22.2673 1.04297 21.6386 1.04297 20.9831V6.15251C1.04297 5.49695 1.30339 4.86825 1.76693 4.40471C2.23048 3.94116 2.85918 3.68075 3.51473 3.68075H18.3453C19.0008 3.68075 19.6295 3.94116 20.0931 4.40471C20.5566 4.86825 20.8171 5.49695 20.8171 6.15251V11.096H1.04297M19.5812 14.8037V19.7472H24.5247M19.5812 14.8037C20.8923 14.8037 22.1497 15.3245 23.0768 16.2516C24.0039 17.1787 24.5247 18.4361 24.5247 19.7472M19.5812 14.8037C18.2701 14.8037 17.0127 15.3245 16.0856 16.2516C15.1585 17.1787 14.6377 18.4361 14.6377 19.7472C14.6377 21.0583 15.1585 22.3157 16.0856 23.2428C17.0127 24.1699 18.2701 24.6907 19.5812 24.6907C20.8923 24.6907 22.1497 24.1699 23.0768 23.2428C24.0039 22.3157 24.5247 21.0583 24.5247 19.7472M15.8735 1.20898V6.15251M5.98649 1.20898V6.15251"
                                    stroke="#5E8082" stroke-width="1.85382" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>March 12, 2023 - May 28, 2023</span>
                        </div>
                        <p class="description">Focused on fine line and realism. Excellent experience and supportive staff.
                        </p>
                    </div>

                    <div class="card-footer">
                        <button class="view-details-btn">View Details</button>
                    </div>
                </div>
            @endfor
        </div>

        <div id="editGuestSpotModal" class="edit-guest-modal-overlay">
            <div class="edit-guest-modal-content">
                <div class="edit-guest-modal-header">
                    <h3 class="edit-guest-modal-title">Edit Past Guest Spots</h3>
                    <button class="edit-guest-modal-close-btn">&times;</button>
                </div>

                <div class="edit-guest-modal-image-wrapper">
                    <img src="{{ asset('assets/web/dashboard/default_1_profile.jpg') }}" alt="Studio Tattoo" class="main-image">
                    <div class="edit-guest-modal-image-overlay">
                        <img src="{{ asset('assets/web/dashboard/default_1.png') }}" alt="Studio Logo" class="logo">
                        <div class="studio-info">
                            <p>The Inkwell Studio</p>
                            <span>
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z">
                                    </path>
                                </svg>
                                San Diego, California, USA
                            </span>
                        </div>
                    </div>
                </div>

                <div class="edit-guest-modal-body">
                    <div class="edit-guest-modal-form-group" data-editable-field>
                        <label>Studio Name</label>
                        <div class="value-display">The Inkwell Studio</div>
                        <input type="text" class="value-input" value="The Inkwell Studio" style="display: none;">
                        <a class="edit-link">Edit</a>
                    </div>

                    <div class="edit-guest-modal-form-group" data-editable-field>
                        <label>Location</label>
                        <div class="value-display">San Diego, California, USA</div>
                        <input type="text" class="value-input" value="San Diego, California, USA"
                            style="display: none;">
                        <a class="edit-link">Edit</a>
                    </div>

                    <div class="edit-guest-modal-date-fields">
                        <div class="edit-guest-modal-form-group">
                            <label>Start Date</label>
                            <div class="value">March 2023</div>
                        </div>
                        <div class="edit-guest-modal-form-group">
                            <label>End Date</label>
                            <div class="value">May 2023</div>
                        </div>
                    </div>

                    <div class="edit-guest-modal-form-group textarea-group">
                        <label>Feedback / Experience</label>
                        <textarea rows="4" placeholder="Share your experience...">Focused on fine line and realism. Excellent experience and supportive staff.</textarea>
                        <button class="update-btn">Update</button>
                    </div>

                    <!-- =================================================== -->
                    <!-- === NEW SECTIONS ADDED HERE (AS PER IMAGE) === -->
                    <!-- =================================================== -->
                    <div class="modal-section">
                        <h4 class="modal-section-title">Clients that you've booked here</h4>
                        <ul class="client-list">
                            <li class="client-list-item">
                                <img src="{{-- path/to/marcus-bennett.jpg --}}" alt="Marcus Bennett" class="client-avatar">
                                <span class="client-name">Marcus Bennett</span>
                                <a href="#" class="client-request-link">View Request</a>
                            </li>
                            <li class="client-list-item">
                                <img src="{{-- path/to/jenna-martinez.jpg --}}" alt="Jenna Martinez" class="client-avatar">
                                <span class="client-name">Jenna Martinez</span>
                                <a href="#" class="client-request-link">View Request</a>
                            </li>
                            <li class="client-list-item">
                                <img src="{{-- path/to/trevor-collins-1.jpg --}}" alt="Trevor Collins" class="client-avatar">
                                <span class="client-name">Trevor Collins</span>
                                <a href="#" class="client-request-link">View Request</a>
                            </li>
                            <li class="client-list-item">
                                <img src="{{-- path/to/trevor-collins-2.jpg --}}" alt="Trevor Collins" class="client-avatar">
                                <span class="client-name">Trevor Collins</span>
                                <a href="#" class="client-request-link">View Request</a>
                            </li>
                        </ul>
                    </div>

                    <div class="modal-section">
                        <h4 class="modal-section-title">Portfolio from that spot</h4>
                        <div class="portfolio-grid">
                            <img src="{{-- path/to/portfolio-1.jpg --}}" alt="Portfolio image 1">
                            <img src="{{-- path/to/portfolio-2.jpg --}}" alt="Portfolio image 2">
                            <img src="{{-- path/to/portfolio-3.jpg --}}" alt="Portfolio image 3">
                        </div>
                    </div>

                </div>

                <div class="edit-guest-modal-footer">
                    <button class="rebook-btn">Rebook</button>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- EXISTING SWIPER CODE ---
            // const swipers = document.querySelectorAll('.swiper_slider');
            // swipers.forEach(function (swiperElement) {
            //     new Swiper(swiperElement, {
            //         loop: true,
            //         pagination: {el: '.swiper-pagination', clickable: true,},
            //         autoplay: {delay: 3500, disableOnInteraction: false,},
            //     });
            // });

            // --- NEW AND UPDATED JAVASCRIPT FOR MODAL ---
            const editGuestModal = document.getElementById('editGuestSpotModal');
            const openModalButtons = document.querySelectorAll('.js-open-edit-guest-modal');
            const closeModalButton = document.querySelector('.edit-guest-modal-close-btn');
            const modalBody = document.querySelector('.edit-guest-modal-body');

            const openModal = () => {
                if (editGuestModal) editGuestModal.style.display = 'flex';
                document.querySelector('.sidebar').classList.add('blur');
                document.body.classList.add('modal-open');

            };

            const closeModal = () => {
                if (editGuestModal) editGuestModal.style.display = 'none';
                document.querySelector('.sidebar').classList.remove('blur');
                document.body.classList.remove('modal-open');
            };

            openModalButtons.forEach(button => button.addEventListener('click', openModal));
            if (closeModalButton) closeModalButton.addEventListener('click', closeModal);
            if (editGuestModal) {
                editGuestModal.addEventListener('click', function(event) {
                    if (event.target === editGuestModal) closeModal();
                });
            }

            if (modalBody) {
                modalBody.addEventListener('click', function(e) {
                    if (e.target.classList.contains('edit-link')) {
                        e.preventDefault();
                        const link = e.target;
                        const formGroup = link.closest('[data-editable-field]');
                        const display = formGroup.querySelector('.value-display');
                        const input = formGroup.querySelector('.value-input');

                        if (link.textContent === 'Edit') {
                            display.style.display = 'none';
                            input.style.display = 'block';
                            input.focus();
                            input.setSelectionRange(input.value.length, input.value.length);
                            link.textContent = 'Done';
                        } else {
                            display.textContent = input.value;
                            display.style.display = 'block';
                            input.style.display = 'none';
                            link.textContent = 'Edit';
                        }
                    }
                });
            }
        });
    </script>
@endsection
