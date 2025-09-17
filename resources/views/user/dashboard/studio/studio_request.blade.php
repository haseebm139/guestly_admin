@extends('user.layouts.master')

{{-- @push('styles') --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --page-bg: #F7FBFB;
        --card-bg: #FFFFFF;
        /* Updated colors to match the image */
        --highlight-card-bg: #e6f4f2;
        --border-color-light: #d0e8e4;
        --dark-green: #004d40;
        --date-row-bg-color: #dbe9e7;
        --date-text: #555;
        --selected-date-bg: #004d40;
        --border-color: #E9EFED;
        --text-dark: #212529;
        --text-light: #6c757d;
        --text-description: #5E6D69;
    }

    body {
        background-color: var(--page-bg);
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        padding: 32px;
    }

    /* --- TOP SECTION GRID --- */
    .top-section {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    /* --- [MODIFIED] CALENDAR & ARTIST CARD --- */
    .calendar-artist-wrapper {
        background-color: var(--highlight-card-bg);
        /* Light green background */
        border: 1px solid #5E8082;
        border-radius: 20px;
        padding: 0;
        /* Remove padding to make sections flush */
        display: flex;
        /* Use flexbox for layout */
    }

    .calendar-section {
        flex-basis: 60%;
        /* Calendar takes 60% width */
        padding: 24px;
        border-right: 1px solid #5E8082;
        /* Vertical separator */
        border-radius: inherit;
    }

    .artist-info-section {
        flex-basis: 40%;
        /* Artist info takes 40% width */
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Vertically center the content */
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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
        padding: 4px 8px;
        color: var(--dark-green);
        font-weight: bold;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        text-align: center;
    }

    .calendar-grid .day-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-light);
    }

    .calendar-grid .day-cell {
        font-size: 14px;
        font-weight: 500;
        height: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--date-text);
        cursor: pointer;
        /* Added cursor pointer for clickable dates */
    }

    .day-cell.active,
    .day-cell.start-date,
    .day-cell.end-date {
        background-color: var(--selected-date-bg);
        color: #FFFFFF;
        font-weight: 600;
        border-radius: 50%;
        /* Make it circular */
    }

    .day-cell.in-range {
        background-color: var(--date-row-bg-color);
        color: var(--text-dark);
        border-radius: 0;
    }

    .date-row-bg {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        background-color: var(--date-row-bg-color);
        border-radius: 50px;
        padding: 2px;
    }

    .date-row-bg .day-cell {
        background-color: transparent;
        /* Cells inside pill are transparent */
    }

    .day-cell.other-month {
        color: #99a7a5;
        /* Dimmed color for other month dates */
        cursor: default;
    }

    .artist-info-section .title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        font-weight: 600;
        color: var(--dark-green);
        margin-bottom: 8px;
    }

    .artist-info-section .title .dot {
        width: 10px;
        height: 10px;
        background-color: var(--dark-green);
        border-radius: 50%;
    }

    .artist-info-section .description {
        font-size: 14px;
        color: var(--text-description);
        line-height: 1.6;
        margin: 0;
    }

    /* --- REQUEST SUMMARY CARD (RIGHT) - Unchanged --- */
    .requests-summary-card {
        background-color: var(--highlight-card-bg);
        border: 1px solid #C2D5D1;
        border-radius: 20px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .requests-summary-card .icon {
        margin-bottom: 12px;
    }

    .requests-summary-card .title {
        font-size: 16px;
        font-weight: 500;
        color: var(--text-dark);
        margin: 0;
    }

    .requests-summary-card .count {
        font-size: 52px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 8px 0;
    }

    .requests-summary-card .view-all-link {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .requests-section {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 24px;
    }

    .requests-section-header {
        font-size: 20px;
        font-weight: 600;
        color: var(--dark-green);
        margin: 0 0 20px 0;
    }

    .requests-table {
        width: 100%;
        border-collapse: collapse;
    }

    .requests-table th,
    .requests-table td {
        padding: 16px 8px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .requests-table thead th {
        font-size: 13px;
        color: var(--text-description);
        font-weight: 500;
    }

    .requests-table tr:last-child td {
        border-bottom: none;
    }

    .artist-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .artist-cell img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .artist-cell span {
        font-weight: 500;
        color: var(--text-dark);
        font-size: 15px;
    }

    .requests-table td {
        font-size: 15px;
        color: var(--text-description);
    }

    .actions-cell a {
        text-decoration: none;
        color: var(--text-description);
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-right: 20px;
    }

    .actions-cell a:hover {
        color: var(--dark-green);
    }

    .actions-cell a.view-details-link {
        color: #A0A9A7;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .custom-checkbox input {
        display: none;
    }

    .custom-checkbox .checkmark {
        width: 20px;
        height: 20px;
        border: 1.5px solid #CDD5D3;
        border-radius: 6px;
        display: inline-block;
        cursor: pointer;
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="dashboard-container">
        <div class="top-section">
            <!-- [MODIFIED] Calendar and Next Artist Info Card -->
            <div class="calendar-artist-wrapper">
                <div class="calendar-section">
                    <div class="calendar-header">
                        <span id="calendar-month-year" class="month-year"></span>
                        <div class="calendar-nav">
                            <button id="prev-month-btn">&lt;</button>
                            <button id="next-month-btn">&gt;</button>
                        </div>
                    </div>
                    <div class="calendar-grid">
                        <!-- Day Names -->
                        <div class="day-name">M</div>
                        <div class="day-name">T</div>
                        <div class="day-name">W</div>
                        <div class="day-name">T</div>
                        <div class="day-name">F</div>
                        <div class="day-name">S</div>
                        <div class="day-name">S</div>
                    </div>
                    <!-- Calendar Body - Dates will be generated by jQuery here -->
                    <div id="calendar-grid-body" class="calendar-grid"></div>
                </div>
                <div class="artist-info-section">
                    <div>
                        <h4 class="title"><span class="dot"></span> Next Guest Artist</h4>
                        <p class="description">
                            Your next guest artist arriving on September 14th. Just 12 days to go!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Guest Spot Requests Summary Card (Unchanged) -->
            <div class="requests-summary-card">
                <div class="icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="#375B53"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z">
                        </path>
                    </svg>
                </div>
                <p class="title">Guest Spot Requests</p>
                <h1 class="count">865</h1>
                <a href="#" class="view-all-link">View All Requests</a>
            </div>
        </div>

        <!-- Recent Requests Table (Unchanged) -->
        <div class="requests-section">
            <h3 class="requests-section-header">Recent Requests</h3>
            <table class="requests-table">
                <thead>
                    <tr>
                        <th style="width: 5%;"><label class="custom-checkbox"><input type="checkbox"><span
                                    class="checkmark"></span></label></th>
                        <th>Artist Name</th>
                        <th style="width: 40%;">Description</th>
                        <th>Requested Dates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td><label class="custom-checkbox"><input type="checkbox"><span
                                        class="checkmark"></span></label></td>
                            <td>
                                <div class="artist-cell">
                                    <img src="https://i.pravatar.cc/150?img={{ $i + 10 }}" alt="Artist Avatar">
                                    <span>Chris Johnson</span>
                                </div>
                            </td>
                            <td>Excited to work in your space! I specialize in fine line and black & gray realism. Let me
                                know if you have specific hours or rules.</td>
                            <td>March 2023 - May 2023</td>
                            <td>
                                <div class="actions-cell">
                                    <a href="#">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M22 4c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z">
                                            </path>
                                        </svg>
                                        <span>Message Client</span>
                                    </a>
                                    <a href="#" class="view-details-link">View Details</a>
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
    {{-- jQuery CDN को शामिल करें --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // --- Calendar Elements ---
            const $monthYearDisplay = $('#calendar-month-year');
            const $calendarGridBody = $('#calendar-grid-body');
            const $prevMonthBtn = $('#prev-month-btn');
            const $nextMonthBtn = $('#next-month-btn');

            // --- Calendar State ---
            let currentDate = new Date(); // वर्तमान तिथि से शुरू करें
            let startDate = null;
            let endDate = null;
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];

            const toISODateString = (date) => {
                if (!date) return null;
                return date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2);
            }

            const renderCalendar = () => {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                $monthYearDisplay.text(`${monthNames[month]} ${year}`);
                $calendarGridBody.empty(); // कैलेंडर ग्रिड को खाली करें

                const firstDayOfMonth = new Date(year, month, 1);
                const lastDayOfMonth = new Date(year, month + 1, 0);
                const daysInMonth = lastDayOfMonth.getDate();

                // सोमवार को सप्ताह का पहला दिन मानें (0=सोमवार, 6=रविवार)
                const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7;

                const prevLastDay = new Date(year, month, 0).getDate();

                // पिछले महीने के दिन
                for (let i = startDayIndex; i > 0; i--) {
                    $calendarGridBody.append(`<div class="day-cell other-month">${prevLastDay - i + 1}</div>`);
                }

                // वर्तमान महीने के दिन
                for (let day = 1; day <= daysInMonth; day++) {
                    const cellDate = new Date(year, month, day);
                    const cellDateStr = toISODateString(cellDate);

                    const $cell = $('<div></div>')
                        .addClass('day-cell')
                        .text(('0' + day).slice(-2))
                        .data('date', cellDateStr);

                    // start, end और in-range तिथियों के लिए क्लास जोड़ें
                    if (startDate && cellDateStr === toISODateString(startDate)) {
                        $cell.addClass('start-date');
                        if (endDate && toISODateString(startDate) === toISODateString(endDate)) {
                            $cell.addClass('end-date');
                        }
                    }
                    if (endDate && cellDateStr === toISODateString(endDate)) {
                        $cell.addClass('end-date');
                    }
                    if (startDate && endDate && cellDate > startDate && cellDate < endDate) {
                        $cell.addClass('in-range');
                    }

                    $calendarGridBody.append($cell);
                }

                // अगले महीने के दिन
                const totalCells = startDayIndex + daysInMonth;
                const nextDays = (7 - (totalCells % 7)) % 7;
                for (let i = 1; i <= nextDays; i++) {
                    $calendarGridBody.append(`<div class="day-cell other-month">${('0' + i).slice(-2)}</div>`);
                }
            };

            // इवेंट डेलिगेशन का उपयोग करके क्लिक हैंडलर
            $calendarGridBody.on('click', '.day-cell:not(.other-month)', function() {
                const $clickedCell = $(this);
                const clickedDateStr = $clickedCell.data('date');
                if (!clickedDateStr) return;

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
            });

            $prevMonthBtn.on('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            $nextMonthBtn.on('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            renderCalendar();
        });
    </script>
@endsection
