@extends('user.layouts.master')

{{-- @push('styles') --}}
{{-- Bootstrap CSS (Agar master layout mein nahi hai to yahan add karein) --}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<style>
    /* Google Fonts - Poppins (optional, for better text rendering) */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        /* Page ka background color */
    }

    /* Main notification card ki styling */
    .notifications-container {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Header (jahan button hai) */
    .notifications-header {
        display: flex;
        justify-content: flex-start;
        /* Button ko left par rakhega */
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    /* "Mark all as Read" button */
    .btn-mark-all {
        background-color: #00AEEF;
        /* Image wala blue color */
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        border-radius: 8px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s ease;
    }

    .btn-mark-all:hover {
        background-color: #0099D4;
        color: #fff;
    }

    /* Notification list ki styling */
    .notification-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Har ek notification item */
    .notification-item {
        display: flex;
        align-items: center;
        padding: 16px 8px;
        /* Thodi si padding */
        border-bottom: 1px solid #e9ecef;
    }

    .notification-item:last-child {
        border-bottom: none;
        /* Aakhri item ke neeche line nahi hogi */
    }

    /* User ka icon/avatar */
    .notification-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .notification-avatar svg {
        width: 24px;
        height: 24px;
        color: #4a5568;
    }

    /* Text wala hissa (Name aur message) */
    .notification-content {
        flex-grow: 1;
        /* Taake yeh poori jagah le le */
    }

    .notification-content p {
        margin: 0;
        line-height: 1.5;
        font-size: 15px;
        color: #6c757d;
        /* Text ka halka color */
    }

    .notification-content strong {
        color: #212529;
        /* Name ka dark color */
        font-weight: 600;
    }

    /* Right side wala hissa (dot aur time) */
    .notification-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: #6c757d;
        flex-shrink: 0;
        margin-left: 16px;
    }

    .unread-dot {
        width: 10px;
        height: 10px;
        background-color: #00AEEF;
        /* Image wala blue dot */
        border-radius: 50%;
    }
</style>
{{-- @endpush --}}


@section('content')
    {{-- Hum ne content-card hata kar seedha Bootstrap ka container istemal kiya hai --}}
    <div class="container py-4">

        <div class="notifications-container">

            {{-- 1. Header Section --}}
            <div class="notifications-header">
                <button class="btn btn-mark-all">
                    <span>Mark all as Read</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </button>
            </div>

            {{-- 2. Notifications List Section --}}
            <ul class="notification-list">

                {{-- Yeh ek loop mein chalega (for example, @foreach) --}}
                @for ($i = 0; $i < 5; $i++)
                    <li class="notification-item">
                        <div class="notification-avatar">
                            {{-- User ka Icon SVG --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="notification-content">
                            <p><strong>John Doe</strong></p>
                            <p>It is a long established fact that a reader will be distracted</p>
                        </div>
                        <div class="notification-meta">
                            <span class="unread-dot"></span>
                            <span>00 min ago</span>
                        </div>
                    </li>
                @endfor

            </ul>

        </div>

    </div>
@endsection


@section('scripts')
    {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Yahan aap future mein "Mark all as Read" button ke click par
            // AJAX request bhej kar notifications ko read mark kar sakte hain.
        });
    </script>
@endsection
