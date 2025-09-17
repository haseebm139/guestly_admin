@extends('user.layouts.master')

<head>
    <title>Studio Availability</title>

    {{-- Google Fonts Link --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Color Palette refined to match the images */
            --primary-green: #004D40;
            --secondary-green-bg: #F0F7F5;
            /* Lighter background for cards */
            --tag-bg: #E0EBE6;
            /* Slightly darker for tags */
            --white-bg: #FFFFFF;
            --light-page-bg: #F8F9FA;
            --text-dark: #343A40;
            --text-light: #6C757D;
            --border-color: #DEE2E6;
            --blocked-date-bg: #FAD2D2;
            /* Muted pink/red for BLOCKED dates */
            --blocked-date-text: #B95C5C;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-page-bg);
            margin: 0;
            color: var(--text-dark);
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Align to top */
            min-height: 100vh;
            padding: 40px 20px;
            box-sizing: border-box;
        }

        .main-container {
            background-color: var(--white-bg);
            border-radius: 24px;
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 600px;
            padding: 32px;
            box-sizing: border-box;
        }

        .main-heading {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            color: var(--primary-green);
            margin-top: 0;
            margin-bottom: 8px;
        }

        .sub-heading {
            text-align: center;
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 32px;
        }

        .availability-options {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            /* Increased margin */
        }

        .option-card {
            flex: 1;
            background-color: var(--secondary-green-bg);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #5e8082;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
        }

        .option-card img {
            height: 48px;
            margin-bottom: 12px;
        }

        .option-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-section {
            margin-bottom: 24px;
        }

        .section-title {
            display: block;
            /* Make it a block for better spacing */
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
            /* Increased spacing */
        }

        /* Dropdown Styling */
        .day-selector .dropdown {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            /* Matched border radius */
            border: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-dark);
            background-color: var(--white-bg);
            margin-bottom: 16px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6L8 10L12 6' stroke='%236C757D' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }

        .selected-days {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .day-tag {
            background-color: var(--tag-bg);
            color: var(--primary-green);
            padding: 8px 12px 8px 16px;
            /* Adjusted padding */
            border-radius: 50px;
            /* Pill shape */
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            /* Adjusted gap */
        }

        .day-tag .remove-day {
            cursor: pointer;
            background: var(--primary-green);
            color: white;
            border-radius: 50%;
            width: 20px;
            /* Increased size */
            height: 20px;
            /* Increased size */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            /* Adjusted for visibility */
            line-height: 1;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }

        .day-tag .remove-day:hover {
            background-color: #c73e3e;
            /* A red on hover for delete */
        }


        .save-button-container {
            text-align: center;
            margin-top: 40px;
        }

        .save-btn {
            background-color: #014122;
            color: white;
            border: none;
            padding: 16px 40px;
            /* Increased padding */
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease;
        }

        .save-btn:hover {
            background-color: #00382d;
        }


        /* --- MODAL STYLES (RENAMED) --- */
        .sa-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: none;
            /* Initially hidden */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sa-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .sa-modal-content {
            background: var(--white-bg);
            padding: 24px;
            border-radius: 24px;
            width: 100%;
            max-width: 450px;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .sa-modal-overlay.active .sa-modal-content {
            transform: scale(1);
        }

        .sa-modal-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .sa-modal-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: var(--primary-green);
        }

        .sa-close-modal {
            position: absolute;
            top: 16px;
            right: 16px;
            background: var(--primary-green);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 18px;
            cursor: pointer;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1;
            transition: transform 0.2s ease;
        }

        .sa-close-modal:hover {
            transform: rotate(90deg);
        }

        /* --- DYNAMIC CALENDAR STYLES --- */
        .calendar-container {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            /* Increased spacing */
            padding: 0 8px;
        }

        .calendar-header span {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 16px;
        }

        .calendar-nav {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-dark);
            padding: 4px;
        }

        .calendar-grid-header,
        .calendar-grid-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            /* Spacing between cells */
        }

        .day-name {
            font-weight: 600;
            color: var(--text-light);
            font-size: 12px;
            text-align: center;
        }

        .day-cell {
            font-size: 14px;
            height: 36px;
            width: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            border-radius: 50%;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .day-cell.selectable:not(.other-month) {
            cursor: pointer;
        }

        .day-cell.selectable:not(.other-month):hover {
            background-color: var(--secondary-green-bg);
        }

        .day-cell.other-month {
            color: var(--text-light);
            opacity: 0.5;
            cursor: default;
        }

        .day-cell.blocked-date {
            background-color: var(--blocked-date-bg);
            color: var(--blocked-date-text);
            font-weight: 600;
        }

        .day-cell.selection-active {
            background-color: var(--primary-green);
            color: white;
            font-weight: 600;
        }

        /* Modal Form Inputs (Block Dates) */
        .sa-modal-form-inputs {
            display: flex;
            flex-direction: column;
            gap: 16px;
            /* Increased gap */
        }

        .date-inputs-row {
            display: flex;
            gap: 16px;
        }

        .input-wrapper {
            flex: 1;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px 12px;
        }

        .input-wrapper label {
            display: block;
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 2px;
        }

        .input-wrapper input,
        .input-wrapper .value-span {
            width: 100%;
            border: none;
            background: transparent;
            padding: 0;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            box-sizing: border-box;
        }

        .input-wrapper input:focus {
            outline: none;
        }

        /* Modal Action Button */
        .sa-modal-action-btn {
            width: 100%;
            padding: 16px;
            background: #014122;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 24px;
            transition: background-color 0.2s ease;
        }

        .sa-modal-action-btn:hover {
            background-color: #00382d;
        }

        /* Unblock Dates Modal List */
        .blocked-dates-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 180px;
            /* Set a max-height */
            overflow-y: auto;
            /* Enable vertical scrollbar when content overflows */
        }

        .blocked-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .blocked-item-info .date {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
        }

        .blocked-item-info .reason {
            font-size: 12px;
            color: var(--text-light);
        }

        .unblock-btn {
            background: none;
            border: none;
            color: #014122;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            padding: 4px;
        }
    </style>
</head>

@section('content')
    <div class="page-wrapper">
        <div class="main-container">
            <h2 class="main-heading">Studio Availability</h2>
            <p class="sub-heading">Select the availability of the studio</p>

            <div class="availability-options">
                <div id="openBlockModal" class="option-card">
                    <img src="{{ asset('assets/web/extra/block_dates.svg') }}" alt="Block Dates Icon">
                    <div class="title">Block Dates</div>
                </div>
                <div id="openUnblockModal" class="option-card">
                    <img src="{{ asset('assets/web/extra/unblock_dates.svg') }}" alt="Unblock Dates Icon">
                    <div class="title">Unblock Dates</div>
                </div>
            </div>

            <div class="form-section">
                <label class="section-title" for="available-days">Available Days</label>
                <div class="day-selector">
                    <select id="available-days" class="dropdown">
                        <option selected disabled>Select your days</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>
                <div class="selected-days" id="available-days-container">
                </div>
            </div>

            <div class="form-section">
                <label class="section-title" for="unavailable-days">Unavailable Days</label>
                <div class="day-selector">
                    <select id="unavailable-days" class="dropdown">
                        <option selected disabled>Select your days</option>
                        {{-- Options for unavailable days --}}
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>
                <div class="selected-days" id="unavailable-days-container"></div>
            </div>

            <div class="save-button-container">
                <button class="save-btn">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Block Dates Modal -->
    <div id="blockDateModal" class="sa-modal-overlay">
        <div class="sa-modal-content">
            <button class="sa-close-modal">&times;</button>
            <div class="sa-modal-header">
                <h3>Block Dates</h3>
            </div>
            <div class="calendar-container">
                <div class="calendar-header">
                    <button class="calendar-nav" id="block-prev-month-btn">&lt;</button>
                    <span id="block-calendar-month-year"></span>
                    <button class="calendar-nav" id="block-next-month-btn">&gt;</button>
                </div>
                <div class="calendar-grid-header">
                    <div class="day-name">M</div>
                    <div class="day-name">T</div>
                    <div class="day-name">W</div>
                    <div class="day-name">T</div>
                    <div class="day-name">F</div>
                    <div class="day-name">S</div>
                    <div class="day-name">S</div>
                </div>
                <div class="calendar-grid-body" id="block-calendar-grid-body">
                </div>
            </div>

            <div class="sa-modal-form-inputs">
                <div class="date-inputs-row">
                    <div class="input-wrapper">
                        <label>Year</label>
                        <span class="value-span" id="block-year-display">--</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Month</label>
                        <span class="value-span" id="block-month-display">--</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Date</label>
                        <span class="value-span" id="block-date-display">--</span>
                    </div>
                </div>
                <div class="input-wrapper">
                    <label>Name</label>
                    <input type="text" placeholder="e.g., Public Holiday">
                </div>
                <div class="input-wrapper">
                    <label>Reason</label>
                    <input type="text" placeholder="e.g., Maintenance">
                </div>
            </div>

            <button type="button" class="sa-modal-action-btn">Block</button>
        </div>
    </div>

    <!-- Unblock Dates Modal -->
    <div id="unblockDateModal" class="sa-modal-overlay">
        <div class="sa-modal-content">
            <button class="sa-close-modal">&times;</button>
            <div class="sa-modal-header">
                <h3>Unblock Dates</h3>
            </div>
            <div class="calendar-container">
                <div class="calendar-header">
                    <button class="calendar-nav" id="unblock-prev-month-btn">&lt;</button>
                    <span id="unblock-calendar-month-year"></span>
                    <button class="calendar-nav" id="unblock-next-month-btn">&gt;</button>
                </div>
                <div class="calendar-grid-header">
                    <div class="day-name">M</div>
                    <div class="day-name">T</div>
                    <div class="day-name">W</div>
                    <div class="day-name">T</div>
                    <div class="day-name">F</div>
                    <div class="day-name">S</div>
                    <div class="day-name">S</div>
                </div>
                <div class="calendar-grid-body" id="unblock-calendar-grid-body">
                </div>
            </div>

            <div class="blocked-dates-list">
                <div class="blocked-item">
                    <div class="blocked-item-info">
                        <div class="date">September 14 2025</div>
                        <div class="reason">Holiday</div>
                    </div>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="blocked-item">
                    <div class="blocked-item-info">
                        <div class="date">September 30 2025</div>
                        <div class="reason">Wedding</div>
                    </div>
                    <button class="unblock-btn">Unblock</button>
                </div>
                <div class="blocked-item">
                    <div class="blocked-item-info">
                        <div class="date">October 05 2025</div>
                        <div class="reason">Maintenance</div>
                    </div>
                    <button class="unblock-btn">Unblock</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // --- MODAL LOGIC ---
            const blockModal = $('#blockDateModal');
            const unblockModal = $('#unblockDateModal');
            const openBlockBtn = $('#openBlockModal');
            const openUnblockBtn = $('#openUnblockModal');
            const closeButtons = $('.sa-close-modal');

            function openModal(modal) {
                modal.addClass('active');
            }

            function closeModal(modal) {
                modal.removeClass('active');
            }

            openBlockBtn.on('click', function() {
                openModal(blockModal);
            });
            openUnblockBtn.on('click', function() {
                openModal(unblockModal);
            });
            closeButtons.on('click', function() {
                closeModal($(this).closest('.sa-modal-overlay'));
            });
            $('.sa-modal-overlay').on('click', function(event) {
                if ($(event.target).is('.sa-modal-overlay')) {
                    closeModal($(this));
                }
            });
            $(document).on('keydown', function(event) {
                if (event.key === "Escape") {
                    closeModal($('.sa-modal-overlay.active'));
                }
            });

            // --- REUSABLE FUNCTION FOR DAY SELECTION ---
            function initializeDaySelector(selectId, containerId) {
                const $select = $(`#${selectId}`);
                const $container = $(`#${containerId}`);

                $select.on('change', function() {
                    const selectedDay = $(this).val();
                    if (!selectedDay || $(this).find('option:selected').is(':disabled')) {
                        return;
                    }
                    if ($container.find(`.day-tag[data-day="${selectedDay}"]`).length > 0) {
                        return;
                    }

                    const newTag =
                        `<div class="day-tag" data-day="${selectedDay}">${selectedDay}<span class="remove-day">&times;</span></div>`;
                    $container.append(newTag);

                    $(this).find(`option[value="${selectedDay}"]`).prop('disabled', true);
                    $(this).val($('option:first', this).val());
                });

                $container.on('click', '.remove-day', function() {
                    const dayTag = $(this).closest('.day-tag');
                    const dayToRemove = dayTag.data('day');
                    dayTag.remove();
                    $select.find(`option[value="${dayToRemove}"]`).prop('disabled', false);
                });
            }

            // Initialize both day selectors
            initializeDaySelector('available-days', 'available-days-container');
            initializeDaySelector('unavailable-days', 'unavailable-days-container');


            // --- DYNAMIC CALENDAR LOGIC ---
            function initializeCalendar(config) {
                const {
                    monthYearId,
                    gridBodyId,
                    prevBtnId,
                    nextBtnId,
                    isSelectable,
                    blockedDates = [],
                    yearDisplayId,
                    monthDisplayId,
                    dateDisplayId
                } = config;

                const $monthYearDisplay = $(`#${monthYearId}`);
                const $calendarGridBody = $(`#${gridBodyId}`);
                const $prevMonthBtn = $(`#${prevBtnId}`);
                const $nextMonthBtn = $(`#${nextBtnId}`);
                const $yearDisplay = yearDisplayId ? $(`#${yearDisplayId}`) : null;
                const $monthDisplay = monthDisplayId ? $(`#${monthDisplayId}`) : null;
                const $dateDisplay = dateDisplayId ? $(`#${dateDisplayId}`) : null;

                let currentDate = new Date();
                let selectedDate = null;
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];

                const formatDateToString = (date) => {
                    if (!date) return null;
                    const year = date.getFullYear();
                    const month = ('0' + (date.getMonth() + 1)).slice(-2);
                    const day = ('0' + date.getDate()).slice(-2);
                    return `${year}-${month}-${day}`;
                };

                const updateDateDisplays = (date) => {
                    if (!$yearDisplay) return;
                    if (date) {
                        $yearDisplay.text(date.getFullYear());
                        $monthDisplay.text(monthNames[date.getMonth()]);
                        $dateDisplay.text(date.getDate());
                    } else {
                        $yearDisplay.text('--');
                        $monthDisplay.text('--');
                        $dateDisplay.text('--');
                    }
                };

                const renderCalendar = () => {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();

                    $monthYearDisplay.text(`${monthNames[month]} ${year}`);
                    $calendarGridBody.empty();

                    const firstDayOfMonth = new Date(year, month, 1);
                    const lastDayOfMonth = new Date(year, month + 1, 0);
                    const daysInMonth = lastDayOfMonth.getDate();
                    const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7;
                    const prevLastDay = new Date(year, month, 0).getDate();

                    for (let i = startDayIndex; i > 0; i--) {
                        $calendarGridBody.append(
                            `<div class="day-cell other-month">${prevLastDay - i + 1}</div>`);
                    }

                    for (let day = 1; day <= daysInMonth; day++) {
                        const cellDate = new Date(year, month, day);
                        const cellDateStr = formatDateToString(cellDate);
                        const $cell = $('<div></div>')
                            .addClass('day-cell')
                            .text(('0' + day).slice(-2))
                            .data('date', cellDateStr);

                        if (isSelectable) $cell.addClass('selectable');
                        if (blockedDates.includes(cellDateStr)) $cell.addClass('blocked-date');
                        if (selectedDate && cellDateStr === formatDateToString(selectedDate)) $cell.addClass(
                            'selection-active');

                        $calendarGridBody.append($cell);
                    }

                    const totalCells = startDayIndex + daysInMonth;
                    const nextDays = (7 - (totalCells % 7)) % 7;
                    for (let i = 1; i <= nextDays; i++) {
                        $calendarGridBody.append(
                            `<div class="day-cell other-month">${('0' + i).slice(-2)}</div>`);
                    }
                };

                if (isSelectable) {
                    $calendarGridBody.on('click', '.day-cell.selectable:not(.other-month)', function() {
                        const clickedDateStr = $(this).data('date');
                        if (!clickedDateStr) return;
                        selectedDate = new Date(clickedDateStr + 'T00:00:00');
                        updateDateDisplays(selectedDate);
                        renderCalendar();
                    });
                }

                $prevMonthBtn.on('click', () => {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    renderCalendar();
                });

                $nextMonthBtn.on('click', () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    renderCalendar();
                });

                renderCalendar();
            }

            // --- Calendar Initialization ---
            initializeCalendar({
                monthYearId: 'block-calendar-month-year',
                gridBodyId: 'block-calendar-grid-body',
                prevBtnId: 'block-prev-month-btn',
                nextBtnId: 'block-next-month-btn',
                isSelectable: true,
                yearDisplayId: 'block-year-display',
                monthDisplayId: 'block-month-display',
                dateDisplayId: 'block-date-display'
            });

            const previouslyBlockedDates = ['2025-09-14', '2025-09-30', '2025-10-05'];
            initializeCalendar({
                monthYearId: 'unblock-calendar-month-year',
                gridBodyId: 'unblock-calendar-grid-body',
                prevBtnId: 'unblock-prev-month-btn',
                nextBtnId: 'unblock-next-month-btn',
                isSelectable: false,
                blockedDates: previouslyBlockedDates
            });
        });
    </script>
@endsection
