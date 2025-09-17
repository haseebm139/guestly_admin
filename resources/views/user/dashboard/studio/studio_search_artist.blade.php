@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<style>
    :root {
        --primary-green: #008080;
        --light-green-bg: #F0F7F7;
        --tag-bg-realism: #E6F4F0;
        --tag-text-realism: #014122;
        --tag-bg-bold: #E6F4F0;
        --tag-text-bold: #014122;
        --border-color: #D5E9E9;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --verified-green: #014122;
    }

    body {
        background-color: var(--light-green-bg);
    }

    .content-card {
        background-color: var(--light-green-bg);
        padding: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    /* --- HEADER SECTION --- */
    .page-header-wrapper {
        display: flex;
        justify-content: flex-start;
        /* Items ko left se start karega */
        align-items: center;
        margin-bottom: 24px;
    }

    /* New wrapper for search and filter */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        /* Search aur filter ke beech space */
    }

    .search-bar {
        position: relative;
    }

    .search-bar svg {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        fill: var(--text-light);
    }

    .search-bar input {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 16px 20px 16px 52px;
        font-size: 16px;
        width: 350px;
        /* Thori si fixed width dedi */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .search-bar input::placeholder {
        color: var(--text-light);
    }

    .filter-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        padding: 16px 24px;
        font-size: 16px;
        font-weight: 500;
        color: var(--text-dark);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    /* Dropdown arrow styling */
    .dropdown-arrow {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    /* Class to rotate arrow on toggle */
    .filter-btn.active .dropdown-arrow {
        transform: rotate(180deg);
    }


    /* Grid Layout */
    .spots-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    /* --- ARTIST CARD STYLING --- */
    .artist-card {
        background-color: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .artist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.07);
    }

    .card_image_wrapper {
        position: relative;
        padding: 8px;
    }

    .swiper_slider img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
    }

    .swiper-pagination {
        bottom: 18px !important;
    }

    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.8);
        width: 6px;
        height: 6px;
        opacity: 1;
    }

    .swiper-pagination-bullet-active {
        background: #fff;
        width: 8px;
        height: 8px;
    }

    .card_content_wrapper {
        padding: 0 16px 16px 16px;
        flex-grow: 1;
    }

    .artist-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 12px;
        margin-bottom: 12px;
    }

    .artist-profile-pic {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 2px solid #fff;
        object-fit: cover;
    }

    .artist-details {
        flex-grow: 1;
    }

    .artist-details h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .artist-details p {
        font-size: 13px;
        color: var(--text-light);
        margin: 2px 0 0 0;
    }

    .message-icon {
        background-color: #F0F7F7;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .artist-verification {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 12px;
    }

    .artist-verification .verified-badge {
        display: flex;
        align-items: center;
        gap: 4px;
        color: var(--verified-green);
        font-weight: 500;
    }

    .artist-verification .verified-badge svg {
        width: 16px;
        height: 16px;
        fill: var(--verified-green);
    }

    .artist-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .tag {
        font-size: 12px;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 50px;
    }

    .tag.realism {
        background-color: var(--tag-bg-realism);
        color: var(--tag-text-realism);
    }

    .tag.bold {
        background-color: var(--tag-bg-bold);
        color: var(--tag-text-bold);
    }

    .artist-bio {
        font-size: 13px;
        color: var(--text-dark);
        line-height: 1.5;
        margin: 0;
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

        .page-header-wrapper {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .header-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .search-bar input {
            width: 100%;
        }
    }
</style>
{{-- @endpush --}}


@section('content')
    <div class="content-card">

        <div class="page-header-wrapper">
            <div class="header-actions">
                <div class="search-bar">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                        </path>
                    </svg>
                    <input type="text" placeholder="Search Guest Artists?">
                </div>
                <button class="filter-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                        <line x1="1" y1="14" x2="7" y2="14"></line>
                        <line x1="9" y1="8" x2="15" y2="8"></line>
                        <line x1="17" y1="16" x2="23" y2="16"></line>
                    </svg>
                    <span>Filter</span>
                    <svg class="dropdown-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="spots-grid">
            @for ($i = 0; $i < 8; $i++)
                <div class="artist-card">
                    <div class="card_image_wrapper">
                        <div class="swiper swiper_slider">
                            <div class="swiper-wrapper">
                                {{-- Backend se aane wale dynamic images yahan loop honge --}}
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_1_profile.jpg') }}"
                                        alt="Artwork"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_2_profile.jpg') }}"
                                        alt="Artwork"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/web/dashboard/default_3_profile.jpg') }}"
                                        alt="Artwork"></div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <div class="card_content_wrapper">
                        <div class="artist-header">
                            {{-- Backend se aane wali profile pic yahan lagegi --}}
                            <img src="{{ asset('assets/web/dashboard/default_1.png') }}" alt="Artist Name" class="artist-profile-pic">
                            <div class="artist-details">
                                {{-- Backend se aane wala naam aur experience yahan aayega --}}
                                <h3>Chris Johnson</h3>
                                <p>4+ Years of Experience</p>
                            </div>
                            <div class="message-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#014122"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <div class="artist-verification">
                            <span class="verified-badge">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z">
                                    </path>
                                </svg>
                                Verified
                            </span>
                            <span>&bull;</span>
                            {{-- Backend se aane wali location yahan aayegi --}}
                            <span>San Diego, California, USA</span>
                        </div>

                        <div class="artist-tags">
                            {{-- Backend se aane wale tags yahan loop honge --}}
                            <span class="tag realism">Realism & Illustrative</span>
                            <span class="tag bold">Bold & Graphic</span>
                        </div>

                        <p class="artist-bio">
                            {{-- Backend se aane wala bio yahan aayega --}}
                            I'm a passionate tattoo artist known for bold linework, fine detail, and custom designs that
                            tell a story. With over 6 years of experience, Riley specializes in neo-traditional, blockwork,
                            and botanical-inspired pieces.
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper sliders on all cards
            const swipers = document.querySelectorAll('.swiper_slider');
            swipers.forEach(function(swiperElement) {
                new Swiper(swiperElement, {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });

            // JavaScript for filter button toggle
            const filterButton = document.querySelector('.filter-btn');
            if (filterButton) {
                filterButton.addEventListener('click', function() {
                    this.classList.toggle('active');
                    // Yahan aap filters ko show/hide karne ka logic add kar sakte hain
                });
            }
        });
    </script>
@endsection
