@extends('user.layouts.master')

{{-- @push('styles') --}}
{{-- CSS mein ahem layout changes kiye gaye hain --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --dark-green: #004D40;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #e9ecef;
    }

    .reviews-card-container {
        background-color: #e6f4f0;
        border-radius: 24px;
        /*box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);*/
        width: 100%;
        padding: 32px;
        box-sizing: border-box;
    }

    /* Filter Tabs ko card ke right par align kiya gaya */
    .filter-tabs {
        display: flex;
        justify-content: flex-end;
        /* Ab yeh poore card ke right par align honge */
        gap: 20px;
        margin-bottom: 24px;
    }

    .filter-tabs button {
        background: none;
        border: none;
        padding: 8px 10px;
        font-size: 16px;
        font-weight: 600;
        color: var(--label-color);
        cursor: pointer;
        border-bottom: 3px solid transparent;
        border-bottom-color: #868e96;
        border-radius: 3px
    }

    .filter-tabs button.active {
        color: var(--dark-green);
        border-bottom-color: #014122;
    }

    /* Main Content Layout (Do columns ke liye) */
    /*.reviews-content-area {*/
    /*    display: flex;*/
    /*    gap: 32px;*/
    /*    align-items: flex-start;*/
    /*}*/
    .reviews-content-area {
        display: flex;
        gap: 32px;
        align-items: flex-start;
        min-width: 0;
        /* Add this */
    }

    /* Left Sidebar (Sticky) */
    .left-sidebar {
        flex: 0 0 200px;
        position: sticky;
        top: 20px;
    }

    .total-reviews-card {
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
    }

    .total-reviews-card .label {
        font-size: 14px;
        font-weight: 500;
        color: var(--label-color);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .total-reviews-card .count {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark-green);
        margin-top: 8px;
    }

    .star-icon {
        color: #ffc107;
        font-size: 20px;
    }

    /* Right Grid (Scrollable Content) */
    /*.reviews-grid-wrapper {*/
    /*    flex: 1;*/
    /*}*/
    .reviews-grid-wrapper {
        flex: 1;
        width: 100%;
        /* Add this */
        min-width: 0;
        /* Helps with flex shrinking issues */
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    /* Review Card (Pehle jaisa hi) */
    .review-card {
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
    }

    .review-header-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .review-header-wrapper .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .review-header-wrapper .user-info .name {
        font-weight: 600;
        color: var(--text-color);
    }

    .review-header-wrapper .user-info .location {
        font-size: 12px;
        color: var(--label-color);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .review-header-wrapper .user-info .location svg {
        width: 18px;
        height: 18px;
    }

    .review-timestamp {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--label-color);
        margin-top: 16px;
        margin-bottom: 8px;
    }

    .review-body {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }

    .review-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 16px;
    }

    /* Responsive */
    /*@media (max-width: 992px) { .reviews-grid { grid-template-columns: 1fr; } }*/
    /*@media (max-width: 768px) {*/
    /*    .reviews-content-area { flex-direction: column; }*/
    /*    .left-sidebar { position: static; width: 100%; margin-bottom: 24px; }*/
    /*}*/
    /* Tablet: 992px se chhoti screen me bhi 2 column */
    @media (max-width: 992px) {
        .reviews-grid {
            grid-template-columns: repeat(2, minmax(220px, 1fr)) !important;
        }
    }

    @media (min-width: 768px) {
        .reviews-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    /* Mobile: 576px se chhoti screen me auto-fit */
    @media (max-width: 576px) {
        .reviews-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) !important;
        }
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="reviews-card-container">

        {{-- AHEM CHANGE: Form/Filter ab 2-column layout se bahar hai, taake woh top par rahe --}}
        <form id="reviewFilterForm" action="{{-- route('reviews.index') --}}" method="GET">
            <nav class="filter-tabs">
                <button type="submit" name="filter" value="all"
                    class="{{ request('filter', 'all') == 'all' ? 'active' : '' }}">All</button>
                <button type="submit" name="filter" value="clients"
                    class="{{ request('filter') == 'clients' ? 'active' : '' }}">Clients</button>
                <button type="submit" name="filter" value="studios"
                    class="{{ request('filter') == 'studios' ? 'active' : '' }}">Studios</button>
            </nav>
        </form>

        {{-- Yahan se 2-column layout shuru hota hai --}}
        <div class="reviews-content-area">

            <aside class="left-sidebar">
                <div class="total-reviews-card">
                    <span class="label"><span class="star-icon">⭐</span> Total Reviews</span>
                    <p class="count">7820</p>
                </div>
            </aside>

            <main class="reviews-grid-wrapper">
                <div class="reviews-grid">

                    @for ($i = 0; $i < 10; $i++)
                        <div class="review-card">
                            <div class="review-header-wrapper">
                                <img src="{{ asset('assets/web/dashboard/review_profile.png') }}" alt="Profile Picture"
                                    class="profile-pic">
                                <div class="user-info">
                                    <span class="name">Jessica L.</span>
                                    <span class="location">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 10.9998C9 11.7954 9.31607 12.5585 9.87868 13.1211C10.4413 13.6837 11.2044 13.9998 12 13.9998C12.7956 13.9998 13.5587 13.6837 14.1213 13.1211C14.6839 12.5585 15 11.7954 15 10.9998C15 10.2041 14.6839 9.44104 14.1213 8.87844C13.5587 8.31583 12.7956 7.99976 12 7.99976C11.2044 7.99976 10.4413 8.31583 9.87868 8.87844C9.31607 9.44104 9 10.2041 9 10.9998Z"
                                                stroke="#5E8082" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M17.657 16.6567L13.414 20.8997C13.039 21.2743 12.5306 21.4848 12.0005 21.4848C11.4704 21.4848 10.962 21.2743 10.587 20.8997L6.343 16.6567C5.22422 15.5379 4.46234 14.1124 4.15369 12.5606C3.84504 11.0087 4.00349 9.40022 4.60901 7.93844C5.21452 6.47665 6.2399 5.22725 7.55548 4.34821C8.87107 3.46918 10.4178 3 12 3C13.5822 3 15.1289 3.46918 16.4445 4.34821C17.7601 5.22725 18.7855 6.47665 19.391 7.93844C19.9965 9.40022 20.155 11.0087 19.8463 12.5606C19.5377 14.1124 18.7758 15.5379 17.657 16.6567Z"
                                                stroke="#5E8082" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        San Diego, California, USA
                                    </span>
                                </div>
                            </div>
                            <div class="review-timestamp">
                                <span>Jan 21 2025</span>
                                <span>8:00PM</span>
                            </div>
                            <p class="review-body">"Absolutely loved my experience at Ink Haven! The studio is spotless, and
                                my fine line piece came out even better than I imagined. Super professional and welcoming
                                vibe. Will definitely be back!"</p>
                            <img src="{{ asset('assets/web/dashboard/review_pic.png') }}" alt="Tattoo work" class="review-image">
                        </div>
                    @endfor

                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Script ko thora behtar kiya gaya hai taake page refresh par active state bani rahe --}}
    <script>
        // Is script ki ab zaroorat nahi kyunki active class Blade se handle ho rahi hai
        // Lekin agar aap AJAX se filter karna chahte hain to yeh kaam aayegi.
        // $(document).ready(function() {
        //     $('.filter-tabs button').on('click', function(e) {
        //         $('.filter-tabs button').removeClass('active');
        //         $(this).addClass('active');
        //     });
        // });
    </script>
@endsection
