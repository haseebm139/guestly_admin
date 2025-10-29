@extends('user.layouts.master')

{{--@push('styles')--}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --dark-green: #014122;
        /* Updated color to match the new image's highlight */
        --range-highlight-bg: #EFF5F3;
        --border-color-soft: #DDEBE7;
        --text-color-primary: #333;
        --text-color-secondary: #555;
        --text-color-light: #868e96;
    }
    body { background-color: #FAFCFB; font-family: 'Inter', sans-serif; }
    .dashboard-container { padding: 20px; }
    .top-section { display: grid; grid-template-columns: 400px 1fr; gap: 24px; margin-bottom: 24px; }

    /* --- Calendar Styling (NEW and CORRECTED) --- */
    .calendar-card {
        background: var(--light-green-bg); border-radius: 20px; padding: 24px;
        border: 1px solid #5e8082;
    }
    .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .calendar-header .month-year { font-size: 18px; font-weight: 600; color: var(--dark-green); }
    .calendar-nav button { background: none; border: none; cursor: pointer; color: var(--dark-green); font-weight: bold; font-size: 20px; padding: 0 8px; }

    /* Calendar Grid Structure */
    .calendar-grid-header, #calendar-grid-body {
        display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; text-align: center;
    }
    .day-name { font-size: 13px; font-weight: 500; color: var(--text-color-light); padding-bottom: 10px; }

    /* Individual Day Cell Styling */
    .day-cell {
        font-size: 14px; font-weight: 500; height: 38px;
        display: flex; justify-content: center; align-items: center;
        border-radius: 0; /* Use 0 for rectangular highlights */
        cursor: pointer; position: relative;
    }
    .day-cell.other-month { color: #ccc; cursor: default; }

    /* --- THE FIX & NEW STYLE --- */

    /* 1. Base style for the entire highlighted row */
    .day-cell.start-date, .day-cell.end-date, .day-cell.in-range {
        background-color: var(--range-highlight-bg);
        color: var(--text-color-primary); /* Reset text color for all range cells */
    }

    /* 2. Style for the start and end dates specifically */
    .day-cell.start-date, .day-cell.end-date {
        color: #fff; /* White text only on the start/end dates */
        overflow: hidden; /* Ensures pseudo-element doesn't bleed out */
    }

    /* 3. Create the half-moon shapes using a pseudo-element */
    .day-cell.start-date::before,
    .day-cell.end-date::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--dark-green);
        z-index: -1; /* This is the key: places it BEHIND the text number */
    }

    /* 4. Shape the pseudo-elements correctly */
    .day-cell.start-date::before {
        border-radius: 50px 0 0 50px;
    }
    .day-cell.end-date::before {
        border-radius: 0 50px 50px 0;
    }
    /* 5. Handle single-day selection */
    .day-cell.start-date.end-date::before {
        border-radius: 50px; /* Make it a full circle */
    }


    /* --- Info Cards Styling --- */
    .info-cards-wrapper { display: flex; flex-direction: column; gap: 20px; }
    .info-card {
        background: var(--light-green-bg); border-radius: 16px; padding: 20px;
        border: 1px solid #5e8082; display: flex; flex-direction: column;
    }
    .info-card-header { display: flex; align-items: center; gap: 10px; }
    .info-card-header .dot { width: 10px; height: 10px; background-color: var(--dark-green); border-radius: 50%; }
    .info-card-header .title { font-size: 16px; font-weight: 600; color: var(--dark-green); margin: 0; }
    .info-card .description { font-size: 14px; color: var(--text-color-secondary); margin: 8px 0 0; }
    .link-card { flex-direction: row; align-items: center; justify-content: space-between; }
    .link-card .card-content { display: flex; align-items: center; gap: 16px; }
    .link-card .icon-placeholder { color: var(--dark-green); }
    .link-card .title { font-size: 18px; font-weight: 600; color: #333333; }
    .link-card .view-link {
        font-size: 16px; font-weight: 600; color: var(--dark-green);
        text-decoration: underline; text-underline-offset: 4px; text-decoration-thickness: 1.5px;
    }
    .link-card .view-link:hover { color: #0f5132; }

    /* --- Tattoo Requests Section --- */
    .requests-section { margin-top: 24px; background: #fff; border-radius: 16px; padding: 24px; }
    .requests-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;}
    .requests-header h3 { font-size: 20px; font-weight: 600; color: var(--dark-green); margin: 0; }
    .filter-tabs { display: flex; gap: 20px; }
    .filter-tabs button {
        background: none; border: none; padding: 8px 4px; font-size: 16px; font-weight: 500;
        color: var(--text-color-light); cursor: pointer; border-bottom: 2px solid transparent;
        transition: color 0.2s, border-color 0.2s;
    }
    .filter-tabs button.active { color: var(--dark-green); border-bottom-color: var(--dark-green); font-weight: 600; }

    /* --- Tattoo Requests Table --- */
    .requests-table { width: 100%; border-collapse: collapse; }
    .requests-table th, .requests-table td { padding: 16px 8px; text-align: left; border-bottom: 1px solid var(--border-color-soft); }
    .requests-table th { font-size: 14px; color: var(--dark-green); font-weight: 600; text-transform: uppercase; }
    .requests-table td { font-size: 14px; color: var(--text-color-secondary); vertical-align: middle; }
    .requests-table tr:last-child td { border-bottom: none; }
    .client-cell { display: flex; align-items: center; gap: 12px; }
    .client-cell img { width: 40px; height: 40px; border-radius: 50%; }
    .client-cell span { font-weight: 600; color: var(--text-color-primary); }
    .actions-cell { display: flex; align-items: center; gap: 24px; }
    .action-link { display: flex; align-items: center; gap: 6px; text-decoration: none; color: var(--text-color-secondary); font-weight: 500; }
    .action-link:hover { color: var(--dark-green); }
    .action-link svg { width: 18px; height: 18px; fill: currentColor; }
    .action-link.details-link { color: var(--text-color-light); }
    .chk-wrap { display: inline-flex; }
    .chk { position: absolute; opacity: 0; }
    .chk-box { width: 18px; height: 18px; border: 1.5px solid #bdc5c4; border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
    .chk-box::after { content: ""; width: 5px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); display: none; }
    .chk:checked + .chk-box { background: var(--dark-green); border-color: var(--dark-green); }
    .chk:checked + .chk-box::after { display: block; }
    @media (max-width: 1200px) { .top-section { grid-template-columns: 1fr; } }
</style>
{{--@endpush--}}

@section('content')
    <div class="dashboard-container">
        <div class="top-section">
            <div class="calendar-card">
                <div class="calendar-header">
                    <span class="month-year" id="calendar-month-year"></span>
                    <div class="calendar-nav">
                        <button id="prev-month-btn">&lt;</button>
                        <button id="next-month-btn">&gt;</button>
                    </div>
                </div>
                <div class="calendar-grid-header">
                    <div class="day-name">M</div><div class="day-name">T</div><div class="day-name">W</div>
                    <div class="day-name">T</div><div class="day-name">F</div><div class="day-name">S</div>
                    <div class="day-name">S</div>
                </div>
                <div id="calendar-grid-body"></div>
            </div>
            <div class="info-cards-wrapper">
                <div class="info-card">
                    <div class="info-card-header">
                        <span class="dot"></span>
                        <h3 class="title">Next Client</h3>
                    </div>
                    <p class="description">Your next client is at The Inkwell Studio on September 14th. Just 12 days to go!</p>
                </div>
                <div class="info-card link-card">
                    <div class="card-content">
                        <div class="icon-placeholder">
                            {{--                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 22H18.016C18.896 22 19.744 21.72 20.408 21.16C21.064 20.592 21.504 19.8 21.64 18.912C21.928 17.16 22.016 15.3 22.016 13.408V6.016C22.016 4.912 21.568 3.936 20.824 3.192C20.072 2.44 19.096 2 18.016 2H4C3.472 2 2.984 2.208 2.592 2.6C2.2 3 2 3.488 2 4V20C2 20.528 2.2 21.016 2.592 21.408C2.984 21.8 3.472 22 4 22ZM9 12V4H18C18.528 4 19.016 4.2 19.408 4.592C19.8 4.984 20 5.472 20 6V13.2C20 15.16 19.928 16.968 19.672 18.52C19.584 19.088 19.24 19.576 18.736 19.88C18.224 20.192 17.616 20.12 17.128 19.768L14.5 17.5L9 12Z" fill="#014122"/></svg>--}}
                            <img  height="80" src="{{ asset ('assets/web/document.png') }}">
                        </div>
                        <h3 class="title">Tattoo Request Forms</h3>
                    </div>
                    <a href="#" class="view-link">View Forms</a>
                </div>
                <div class="info-card link-card">
                    <div class="card-content">
                        <div class="icon-placeholder">
                            {{--                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 22H18.016C18.896 22 19.744 21.72 20.408 21.16C21.064 20.592 21.504 19.8 21.64 18.912C21.928 17.16 22.016 15.3 22.016 13.408V6.016C22.016 4.912 21.568 3.936 20.824 3.192C20.072 2.44 19.096 2 18.016 2H4C3.472 2 2.984 2.208 2.592 2.6C2.2 3 2 3.488 2 4V20C2 20.528 2.2 21.016 2.592 21.408C2.984 21.8 3.472 22 4 22ZM9 12V4H18C18.528 4 19.016 4.2 19.408 4.592C19.8 4.984 20 5.472 20 6V13.2C20 15.16 19.928 16.968 19.672 18.52C19.584 19.088 19.24 19.576 18.736 19.88C18.224 20.192 17.616 20.12 17.128 19.768L14.5 17.5L9 12Z" fill="#014122"/></svg>--}}
                            <img  height="80" src="{{ asset ('assets/web/document.png') }}">
                        </div>
                        <h3 class="title">Flash Tattoos</h3>
                    </div>
                    <a href="{{ asset ('dashboard/artist_tattoo') }}" class="view-link">View Tattoos</a>
                </div>
            </div>
        </div>
        <div class="requests-section">
            <div class="requests-header">
                <h3>Tattoo Requests</h3>
                <nav class="filter-tabs">
                    <button type="button">Pending</button> <button type="button" class="active">Approved</button> <button type="button">Rejected</button>
                </nav>
            </div>
            <table class="requests-table">
                <thead>
                <tr>
                    <th style="width: 5%;"><label class="chk-wrap"><input type="checkbox" class="chk"><span class="chk-box"></span></label></th>
                    <th>Client Name</th><th>Description</th><th>Booking Date</th><th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < 4; $i++)
                    <tr>
                        <td><label class="chk-wrap"><input type="checkbox" class="chk"><span class="chk-box"></span></label></td>
                        <td>
                            <div class="client-cell">
                                <img src="https://i.pravatar.cc/150?img={{ $i + 5 }}" alt="Client Avatar">
                                <span>Trevor Collins</span>
                            </div>
                        </td>
                        <td>Excited to work in your space! I specialize in fine line and black & gray realism. Let me know if you have specific hours or rules.</td>
                        <td>7:00PM, March 2023</td>
                        <td>
                            <div class="actions-cell">
                                <a href="#" class="action-link"><svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"></path></svg>Message Client</a>
                                <a href="#" class="action-link details-link">View Details</a>
                            </div>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Calendar Elements ---
            const monthYearDisplay = document.getElementById('calendar-month-year');
            const calendarGridBody = document.getElementById('calendar-grid-body');
            const prevMonthBtn = document.getElementById('prev-month-btn');
            const nextMonthBtn = document.getElementById('next-month-btn');

            // --- Calendar State ---
            let currentDate = new Date('2025/09/01'); // Start in September 2025
            let startDate = new Date('2025/09/14');   // Default selection
            let endDate = new Date('2025/09/19');     // Default selection
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            const toISODateString = (date) => {
                const year = date.getFullYear();
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const day = date.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            const renderCalendar = () => {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
                calendarGridBody.innerHTML = '';

                const firstDayOfMonth = new Date(year, month, 1);
                const lastDayOfMonth = new Date(year, month + 1, 0);
                const daysInMonth = lastDayOfMonth.getDate();
                const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7;

                for (let i = 0; i < startDayIndex; i++) {
                    calendarGridBody.innerHTML += `<div class="day-cell other-month"></div>`;
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const cell = document.createElement('div');
                    cell.classList.add('day-cell');
                    cell.textContent = day.toString().padStart(2, '0');

                    const cellDate = new Date(year, month, day);
                    cell.dataset.date = toISODateString(cellDate);

                    if (startDate && toISODateString(cellDate) === toISODateString(startDate)) {
                        cell.classList.add('start-date');
                        if (endDate && toISODateString(startDate) === toISODateString(endDate)) {
                            cell.classList.add('end-date');
                        }
                    }
                    if (endDate && toISODateString(cellDate) === toISODateString(endDate)) {
                        cell.classList.add('end-date');
                    }
                    if (startDate && endDate && cellDate > startDate && cellDate < endDate) {
                        cell.classList.add('in-range');
                    }

                    cell.addEventListener('click', handleDateClick);
                    calendarGridBody.appendChild(cell);
                }
            };

            const handleDateClick = (e) => {
                const clickedDateStr = e.target.dataset.date;
                if (!clickedDateStr) return;

                // YOUR PROVEN FIX: Appending T00:00:00 avoids all timezone issues.
                const clickedDate = new Date(clickedDateStr + 'T00:00:00');

                if (!startDate || (startDate && endDate)) {
                    startDate = clickedDate;
                    endDate = null;
                } else if (clickedDate < startDate) {
                    startDate = clickedDate;
                } else {
                    endDate = clickedDate;
                }
                renderCalendar();
            };

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            renderCalendar();
        });
    </script>
@endsection
