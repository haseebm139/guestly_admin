@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --dark-green: #004D40;
        --light-green-bg: #E6F4F0;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #e9ecef;
    }

    .dashboard-container {
        font-family: 'Inter', sans-serif;
    }

    .top-section {
        display: grid;
        grid-template-columns: 400px 1fr;
        gap: 24px;
        margin-top: 20px;
    }

    /* --- Calendar Styling --- */
    .calendar-card {
        background: #ffffff00;
        border-radius: 20px;
        padding: 24px;
        border: 2px solid #5e8082;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .calendar-header .month-year {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark-green);
    }

    .calendar-nav button {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--dark-green);
        font-weight: bold;
        font-size: 20px;
        padding: 0 8px;
    }

    .calendar-body {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        text-align: center;
    }

    .day-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--label-color);
        padding-bottom: 10px;
    }

    .date-cell {
        font-size: 14px;
        font-weight: 500;
        height: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        z-index: 1;
        transition: background-color 0.2s, color 0.2s;
    }

    .date-cell.inactive {
        color: #ccc;
        cursor: default;
    }

    .date-cell.active {
        background-color: #014122;
        color: #fff;
    }

    .date-cell.in-range::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: #5e80824d;
        z-index: -1;
    }

    .date-cell.range-start::before {
        left: 50%;
        border-radius: 50px 0 0 50px;
    }

    .date-cell.range-end::before {
        right: 50%;
        border-radius: 0 50px 50px 0;
    }

    .date-cell.range-start.range-end::before {
        display: none;
    }

    /* --- Spots Info Cards --- */
    .spots-info-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-card {
        background: #ffffff00;
        border-radius: 16px;
        padding: 20px;
        border: 2px solid #5e8082;
        ;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .info-card-header .icon {
        width: 10px;
        height: 10px;
        fill: var(--dark-green);
    }

    .info-card-header .title {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark-green);
    }

    .info-card .description {
        font-size: 14px;
        color: var(--text-light);
    }

    .past-spots-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .past-spots-header .view-all {
        font-size: 13px;
        font-weight: 500;
        color: #014122;
        text-decoration: underline;
        text-decoration-color: #014122;
        text-underline-offset: 5px;
        text-decoration-thickness: 1px;
    }

    .past-spots-header .view-all:hover {
        color: #0f5132;
        text-decoration-color: #0f5132;
    }

    .past-spots-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 16px;
    }

    .mini-spot-card {
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .mini-spot-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .mini-spot-card .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 8px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    }

    .mini-spot-card .studio-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mini-spot-card .studio-logo {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .mini-spot-card .studio-details {
        color: #fff;
    }

    .mini-spot-card .studio-name {
        font-size: 12px;
        font-weight: 600;
    }

    .mini-spot-card .studio-location {
        font-size: 10px;
        opacity: 0.8;
    }

    .mini-spot-card .actions {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 6px;
    }

    .mini-spot-card .actions button {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(2px);
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .mini-spot-card .actions svg {
        width: 12px;
        height: 12px;
        stroke: var(--dark-green);
    }

    /* --- Upcoming Spots Table --- */
    .upcoming-spots-section {
        margin-top: 24px;
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .upcoming-spots-section h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark-green);
        margin: 0 0 20px;
    }

    .spots-table {
        width: 100%;
        border-collapse: collapse;
    }

    .spots-table th,
    .spots-table td {
        padding: 16px 8px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .spots-table th {
        font-size: 14px;
        color: #014122;
        font-weight: 500;
    }

    .spots-table td {
        font-size: 14px;
        vertical-align: middle;
    }

    .spots-table td.clients-cell {
        position: relative;
    }

    .studio-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
    }

    .studio-cell img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    .clients-booked {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        user-select: none;
        padding: 4px 10px;
        border-radius: 20px;
        transition: background-color 0.3s, color 0.3s;
    }

    .clients-booked svg {
        transition: transform 0.3s ease;
    }

    .clients-booked svg path {
        transition: fill 0.3s;
    }

    .clients-booked.active svg {
        transform: rotate(180deg);
    }

    .client-avatars {
        display: flex;
    }

    .client-avatars img {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #fff;
        margin-left: -10px;
    }

    .client-avatars img:first-child {
        margin-left: 0;
    }

    .action-link {
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: var(--label-color);
        font-weight: 500;
    }

    .action-link:hover {
        color: var(--dark-green);
    }

    .action-link svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    .chk-wrap {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }

    .chk {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .chk-box {
        width: 18px;
        height: 18px;
        border: 1px solid #979797;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 5px 4px 12px #a1b5b6;
        transition: all 0.2s ease;
    }

    .chk-box::after {
        content: "";
        width: 4px;
        height: 12px;
        border: solid #e6f4f0;
        ;
        border-width: 0 2px 3px 0;
        transform: rotate(45deg);
        display: none;
    }

    .chk:checked+.chk-box {
        background: #014122;
    }

    .chk:checked+.chk-box::after {
        display: block;
    }

    .chk:focus-visible+.chk-box {
        box-shadow: 0 0 0 3px rgba(1, 65, 34, 0.25);
    }

    /* --- Active State Styling --- */
    .clients-booked.active {
        background-color: var(--light-green-bg);
        color: var(--dark-green);
        font-weight: 600;
    }

    .clients-booked.active svg path {
        fill: var(--dark-green);
    }

    /* --- Inline Client Popup Styling --- */
    .client-popup {
        position: absolute;
        top: 100%;
        /* MODIFIED: Opens downwards */
        margin-top: -1px;
        /* Overlap border for clean look */
        right: 0;
        width: 380px;
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        /* Start from slightly up */
        transition: all 0.3s ease;
        display: flex;
        /* NEW: Flexbox for layout */
        flex-direction: column;
        /* NEW: Vertical layout */
        max-height: 350px;
        /* NEW: Max height for scroll */
    }

    .client-popup.is-visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-shrink: 0;
        /* Prevent header from shrinking */
    }

    .popup-header .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: var(--dark-green);
    }

    .popup-header .client-avatars img {
        width: 28px;
        height: 28px;
    }

    .popup-header .close-popup {
        cursor: pointer;
        padding: 5px;
    }

    .popup-client-list {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        /* NEW: Scroll appears when needed */
        flex: 1;
        /* NEW: Takes up remaining space */
    }

    /* Custom Scrollbar Styling */
    .popup-client-list::-webkit-scrollbar {
        width: 6px;
    }

    .popup-client-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .popup-client-list::-webkit-scrollbar-thumb {
        background: #014122;
        border-radius: 10px;
    }

    .popup-client-list::-webkit-scrollbar-thumb:hover {
        background: #025c31;
    }

    .popup-client-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 4px;
        border-bottom: 1px solid var(--border-color);
    }

    .popup-client-list-item:last-child {
        border-bottom: none;
    }

    .popup-client-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .popup-client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .popup-client-name {
        font-size: 15px;
        font-weight: 500;
        color: var(--text-color);
    }

    .popup-view-request-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark-green);
        text-decoration: underline;
        text-underline-offset: 4px;
        text-decoration-thickness: 1.5px;
    }

    .popup-view-request-link:hover {
        color: #0f5132;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .top-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .past-spots-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="container-fluid explore_main_sec">
        <div class="row">
            <div class="col-md-12">
                <div class="search-section">
                    <div class="search-controls">

                        <button type="button" class="view_icon_img_btn"><img src="{{ asset('assets/web/eye_icon.png') }}"
                                alt="see"></button>
                        <div class="search-input-wrapper">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Where are you guesting next?" class="search-input">
                        </div>
                        <button class="filter-button" data-bs-toggle="modal" data-bs-target="#filter-modal-overlay">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Left: Studio Cards -->
                <div class="cards_container">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <h5 id="calendar-month-year" class="calendar-month-year"></h5>
                            <div class="calendr_nav_btn_wrapepr">
                                <button id="prev-month-btn" class="calendar-nav"><i
                                        class="fa-solid fa-chevron-left"></i></button>
                                <button id="next-month-btn" class="calendar-nav"><i
                                        class="fa-solid fa-chevron-right"></i></button>
                            </div>
                        </div>
                        <div class="calendar-grid calendar-grid-header">
                            <div class="day-name">M</div>
                            <div class="day-name">T</div>
                            <div class="day-name">W</div>
                            <div class="day-name">T</div>
                            <div class="day-name">F</div>
                            <div class="day-name">S</div>
                            <div class="day-name">S</div>
                        </div>
                        <div id="calendar-grid-body" class="calendar-grid">
                            <!-- Dynamic calendar days will be inserted here by JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row upcoming_guests_row">
                    <div class="col-md-12">
                        <div class="card_border">
                            <span>
                                <h5><i class="fa-solid fa-circle"></i> Next Guest Artists</h5>
                            </span>
                            <p>Your next guest artist arriving on September 14th. Just 12 days to go!</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="white_box upcoming_guests_wrapper">
                            <div class="upcoming_guests_header">
                                <div class="heading_wrapper">
                                    <img src="{{ asset('assets/web/upcoming_guest.png') }}" alt="upcoming guest icon">
                                    <h5>Upcoming Guests</h5>
                                </div>
                                <a href="#">View All</a>
                            </div>
                            <table class="table upcoming_guests_table" style="margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 3; $i++)
                                        <tr>
                                            <td><img class="user_icon_img" src="{{ asset('assets/web/person_icon.png') }}"
                                                    alt="User Icon"> John Doe</td>
                                            <td><i class="fa-solid fa-message"></i> <a href="#">Message Artist</a>
                                            </td>
                                            <td><i class="fa-solid fa-pen-to-square"></i> <a href="#">Edit
                                                    Schedule</a></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card_border stations_status_wrapper">
                            <img src="{{ asset('assets/web/studio_chair.png') }}" alt="chair">
                            <h5>Stations Available</h5>
                            <div class="stations_status">
                                <span>4 Available</span> <span class="danger_txt">2 Booked</span>
                            </div>
                            <h5><a href="#">View Details</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Upcoming Guest Spots Table -->
                <div class="upcoming-spots-section">
                    <h3>Upcoming Guest Spots</h3>
                    <table class="spots-table">
                        <thead>
                            <tr>
                                <th><!-- Checkbox --></th>
                                <th>Studio Name</th>
                                <th>Address</th>
                                <th>Clients Booked</th>
                                <th>Date & Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Increased client count to test scrolling
                                $all_clients = [];
                                $names = [
                                    'Marcus Bennett',
                                    'Jenna Martinez',
                                    'Trevor Collins',
                                    'Sophia Lee',
                                    'Leo Carter',
                                    'Ava Rodriguez',
                                    'Noah Evans',
                                ];
                                for ($i = 0; $i < 20; $i++) {
                                    $all_clients[] = [
                                        'name' => $names[$i % count($names)] . ' ' . ($i > count($names) ? 'II' : ''),
                                        'avatar' => 'https://i.pravatar.cc/150?img=' . ($i + 1),
                                    ];
                                }
                            @endphp
                            @for ($i = 0; $i < 4; $i++)
                                <tr>
                                    <td>
                                        <label class="chk-wrap">
                                            <input type="checkbox" class="chk">
                                            <span class="chk-box"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="studio-cell">
                                            <img src="{{ asset('assets/web/dashboard/default_1.png') }}" alt="Logo">
                                            <span>{{ $i % 2 == 0 ? 'Electric Tiger Tattoo' : 'The Inkwell Studio' }}</span>
                                        </div>
                                    </td>
                                    <td>San Diego, California, USA</td>
                                    <td class="clients-cell">
                                        <div class="clients-booked">
                                            <div class="client-avatars">
                                                {{-- Show first 4 avatars --}}
                                                @foreach (array_slice($all_clients, 0, 4) as $client)
                                                    <img src="{{ $client['avatar'] }}" alt="{{ $client['name'] }}">
                                                @endforeach
                                            </div>
                                            <span>{{ count($all_clients) }} Clients booked</span>
                                            <svg width="13" height="10" viewBox="0 0 19 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.886719 1.42578C1.40203 0.910471 2.21415 0.910535 2.72949 1.42578L9.01758 7.71387L15.29 1.44141C15.8054 0.926115 16.6185 0.926081 17.1338 1.44141C17.6491 1.95673 17.6491 2.76983 17.1338 3.28516L9.93164 10.4863C9.6789 10.7391 9.34374 10.873 9.01758 10.873H8.81055L8.77344 10.8359C8.6798 10.8192 8.58791 10.7935 8.5 10.7559C8.34469 10.6893 8.20453 10.5918 8.08789 10.4697V10.4707L0.886719 3.26855C0.371473 2.75321 0.371409 1.94109 0.886719 1.42578Z"
                                                    fill="#014122" stroke="black" />
                                            </svg>
                                        </div>

                                        <div class="client-popup">
                                            <div class="popup-header">
                                                <div class="header-left">
                                                    <span>{{ count($all_clients) }} Clients booked</span>
                                                    <div class="client-avatars">
                                                        @foreach (array_slice($all_clients, 0, 4) as $client)
                                                            <img src="{{ $client['avatar'] }}"
                                                                alt="{{ $client['name'] }}">
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="close-popup">
                                                    <svg width="19" height="12" viewBox="0 0 19 12"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                                        style="transform: rotate(180deg);">
                                                        <path
                                                            d="M0.886719 1.42578C1.40203 0.910471 2.21415 0.910535 2.72949 1.42578L9.01758 7.71387L15.29 1.44141C15.8054 0.926115 16.6185 0.926081 17.1338 1.44141C17.6491 1.95673 17.6491 2.76983 17.1338 3.28516L9.93164 10.4863C9.6789 10.7391 9.34374 10.873 9.01758 10.873H8.81055L8.77344 10.8359C8.6798 10.8192 8.58791 10.7935 8.5 10.7559C8.34469 10.6893 8.20453 10.5918 8.08789 10.4697V10.4707L0.886719 3.26855C0.371473 2.75321 0.371409 1.94109 0.886719 1.42578Z"
                                                            fill="#014122" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <ul class="popup-client-list">
                                                @foreach ($all_clients as $client)
                                                    <li class="popup-client-list-item">
                                                        <div class="popup-client-info">
                                                            <img src="{{ $client['avatar'] }}"
                                                                alt="{{ $client['name'] }}" class="popup-client-avatar">
                                                            <span class="popup-client-name">{{ $client['name'] }}</span>
                                                        </div>
                                                        <a href="#" class="popup-view-request-link">View Request</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                    <td>Mon, March 08 - Fri, March 12</td>
                                    <td>
                                        <div style="display:flex; gap: 16px;">
                                            <a href="#" class="action-link">
                                                <svg viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z">
                                                    </path>
                                                </svg>
                                                Message
                                            </a>
                                            <a href="#" class="action-link">
                                                <svg viewBox="0 0 24 24">
                                                    <path
                                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- FILTER MODAL -->
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="filter-modal-overlay" tabindex="-1" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content filter-modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h2 class="modal-title" id="filterModalLabel">Filter</h2>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Date Range -->
                    <div class="form-section">
                        <label class="form-label">Date Range</label>
                        <div class="cards_container">
                            <div class="calendar-container">
                                <div class="calendar-header">
                                    <h5 id="calendar-month-year" class="calendar-month-year"></h5>
                                    <div class="calendr_nav_btn_wrapepr">
                                        <button id="prev-month-btn" class="calendar-nav"><i
                                                class="fa-solid fa-chevron-left"></i></button>
                                        <button id="next-month-btn" class="calendar-nav"><i
                                                class="fa-solid fa-chevron-right"></i></button>
                                    </div>
                                </div>
                                <div class="calendar-grid calendar-grid-header">
                                    <div class="day-name">M</div>
                                    <div class="day-name">T</div>
                                    <div class="day-name">W</div>
                                    <div class="day-name">T</div>
                                    <div class="day-name">F</div>
                                    <div class="day-name">S</div>
                                    <div class="day-name">S</div>
                                </div>
                                <div id="calendar-grid-body" class="calendar-grid">
                                    <!-- Dynamic calendar days will be inserted here by JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- From / To Inputs -->
                    <div class="date-inputs-container">
                        <div class="date-input-group">
                            <label class="form-label-small">From</label>
                            <div id="from-date-display" class="date-input-display"></div>
                        </div>
                        <div class="date-input-group">
                            <label class="form-label-small">To</label>
                            <div id="to-date-display" class="date-input-display"></div>
                        </div>
                    </div>

                    <!-- Studio Type Dropdown -->
                    <div class="form-section">
                        <label class="form-label-small">Studio Type</label>
                        <div class="custom-select">
                            <span>Private Studio</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Country/Region Dropdown -->
                    <div class="form-section">
                        <label class="form-label-small">Country/Region</label>
                        <div class="custom-select">
                            <span>United States (+1)</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    {{--                    <button id="clear-dates-btn" class="back-btn_filter">Clear</button> --}}
                    <div class="button-group_filter">
                        <button id="clear-dates-btn" class="nav-btn_filter back-btn_filter">Clear</button>
                        <button class="nav-btn_filter next-btn_filter" data-bs-dismiss="modal">Apply</button>
                    </div>

                    {{--                    <button class="btn-apply">Apply</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // This script handles the initial body opacity transition for a smooth load effect.
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.calendar-container').each(function() {
                const $calendar = $(this);
                const $monthYearEl = $calendar.find('.calendar-month-year');
                const $calendarGridEl = $calendar.find('.calendar-grid-body');
                const $prevBtn = $calendar.find('.prev-month-btn');
                const $nextBtn = $calendar.find('.next-month-btn');

                let currentDate = new Date(2025, 8, 1);
                let startDate = new Date(2025, 8, 14);
                let endDate = new Date(2025, 8, 26);

                function renderCalendar() {
                    $calendarGridEl.empty();
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();
                    $monthYearEl.text(
                    `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`);

                    // First day of month adjusted for Monday start (0 = Monday, 6 = Sunday)
                    const firstDayOfMonth = new Date(year, month, 1).getDay();
                    const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
                    let startingDay = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;

                    // Add empty cells for days before month start
                    for (let i = 0; i < startingDay; i++) {
                        $('<div>').addClass('day-cell other-month').appendTo($calendarGridEl);
                    }

                    // Add date cells
                    for (let i = 1; i <= lastDateOfMonth; i++) {
                        const date = new Date(year, month, i);
                        const $dateCell = $('<div>')
                            .addClass('day-cell')
                            .text(i < 10 ? '0' + i : i)
                            .attr('data-date', date.toISOString().split('T')[0]);

                        if (startDate && date.getTime() === startDate.getTime()) {
                            $dateCell.addClass('start-date');
                        }
                        if (endDate && date.getTime() === endDate.getTime()) {
                            $dateCell.addClass('end-date');
                        }
                        if (startDate && endDate && date > startDate && date < endDate) {
                            $dateCell.addClass('in-range');
                        }

                        $calendarGridEl.append($dateCell);
                    }

                    // Update date displays if they exist
                    const $fromDisplay = $calendar.find('.from-date-display');
                    const $toDisplay = $calendar.find('.to-date-display');

                    if ($fromDisplay.length) {
                        $fromDisplay.text(startDate ? formatDate(startDate) : '');
                    }
                    if ($toDisplay.length) {
                        $toDisplay.text(endDate ? formatDate(endDate) : '');
                    }
                }

                // Date formatting helper
                function formatDate(date) {
                    return date.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }

                // Event Handlers
                $calendarGridEl.on('click', '.day-cell:not(.other-month)', function() {
                    const clickedDate = new Date($(this).data('date'));

                    if (!startDate || (startDate && endDate)) {
                        startDate = clickedDate;
                        endDate = null;
                    } else if (clickedDate < startDate) {
                        startDate = clickedDate;
                    } else {
                        endDate = clickedDate;
                    }
                    renderCalendar();
                });

                $prevBtn.click(function() {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    renderCalendar();
                });

                $nextBtn.click(function() {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    renderCalendar();
                });

                // Clear dates functionality
                $calendar.find('.clear-dates-btn').click(function() {
                    startDate = null;
                    endDate = null;
                    renderCalendar();
                });

                // Initial render
                renderCalendar();
            });

        });

        // ======================================================================
        // START: DYNAMIC FILTER MODAL & CALENDAR SCRIPT
        // ======================================================================
        document.addEventListener('DOMContentLoaded', () => {

            // --- Modal Control Elements ---
            const filterButton = document.querySelector('.filter-button');
            const modalOverlay = document.getElementById('filter-modal-overlay');
            const closeModalBtn = document.querySelector('.modal-close-btn');
            const applyBtn = document.querySelector('.next-btn_filter');
            const clearDatesBtn = document.getElementById('clear-dates-btn');

            // --- Inline Client Popup Script ---
            const popupTriggers = document.querySelectorAll('.clients-booked');

            function closeAllPopups() {
                document.querySelectorAll('.client-popup.is-visible').forEach(openPopup => {
                    openPopup.classList.remove('is-visible');
                });
                document.querySelectorAll('.clients-booked.active').forEach(activeTrigger => {
                    activeTrigger.classList.remove('active');
                });
            }
            popupTriggers.forEach(trigger => {
                const popup = trigger.nextElementSibling;
                const closeButton = popup.querySelector('.close-popup');
                trigger.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const isAlreadyVisible = popup.classList.contains('is-visible');
                    closeAllPopups();
                    if (!isAlreadyVisible) {
                        popup.classList.add('is-visible');
                        trigger.classList.add('active');
                    }
                });
                if (closeButton) {
                    closeButton.addEventListener('click', function(event) {
                        event.stopPropagation();
                        closeAllPopups();
                    });
                }
            });
            document.addEventListener('click', function() {
                closeAllPopups();
            });
        });
    </script>
@endsection

{{-- @push('styles') --}}
