<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/web/guestly_favicon.png') }}">

    {{-- CSS Links --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Aapki custom CSS file --}}
    <link rel="stylesheet" href="{{ asset('assets/web/css/style.css') }}"> {{-- Best practice for Laravel --}}
    {{-- Ya seedhe: <link rel="stylesheet" href="style.css"> --}}


</head>

<body>

    {{-- <div class="container"> --}}

    {{-- Sidebar ko yahan include kiya gaya hai --}}
    @include('user.partials.sidebar')


    <!-- Main Content -->
    <main class="main-content">

        {{-- Navbar (Header section) ko yahan include kiya gaya hai --}}
        @include('user.partials.navbar')

        {{-- Page ka specific content yahan display hoga --}}
        @yield('content')

    </main>
    {{-- </div> --}}

    {{-- Filter Modal (Yeh global hai, isliye master layout mein rakha hai) --}}
    {{-- START: FILTER MODAL --}}
    <div id="filter-modal-overlay" class="filter-modal-overlay hidden">
        <div class="filter-modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h2 class="modal-title">Filter</h2>
                <button class="modal-close-btn">
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
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button id="prev-month-btn" class="calendar-nav">
                                << /button>
                                    <span id="calendar-month-year" class="calendar-month-year"></span>
                                    <button id="next-month-btn" class="calendar-nav">></button>
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
                        <div id="calendar-grid-body" class="calendar-grid"></div>
                    </div>
                </div>

                <!-- From / To Inputs -->
                <div class="date-inputs-container">
                    <div class="date-input-group"><label class="form-label-small">From</label>
                        <div id="from-date-display" class="date-input-display"></div>
                    </div>
                    <div class="date-input-group"><label class="form-label-small">To</label>
                        <div id="to-date-display" class="date-input-display"></div>
                    </div>
                </div>

                <!-- Studio Type Dropdown -->
                <div class="form-section"><label class="form-label-small">Studio Type</label>
                    <div class="custom-select"><span>Private Studio</span><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg></div>
                </div>

                <!-- Country/Region Dropdown -->
                <div class="form-section"><label class="form-label-small">Country/Region</label>
                    <div class="custom-select"><span>United States (+1)</span><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button id="clear-dates-btn" class="btn-clear">Clear</button>
                <button class="btn-apply">Apply</button>
            </div>
        </div>
    </div>
    {{-- END: FILTER MODAL --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- JavaScript Libraries and Scripts --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Page-specific scripts ke liye (agar zaroorat pade) --}}
    @yield('scripts')

    {{-- Common scripts jo har page par chalenge --}}
    <script>
        $(document).ready(function() {
            $('.swiper_slider').each(function() {
                const swiper = new Swiper(this, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    loop: true, // Enable infinite loop
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true, // Make pagination dots clickable
                        type: 'bullets', // Use bullets for pagination
                    },
                    autoplay: {
                        delay: 3000, // Optional: adds 3 second delay between slides
                        disableOnInteraction: false, // Continues autoplay after user interaction
                    }
                });
            });
        });


        // Body fade-in effect on load
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });

        // Filter Modal and Calendar script
        document.addEventListener('DOMContentLoaded', () => {

            // --- Modal Control Elements ---
            const filterButton = document.querySelector('.filter-button');
            const modalOverlay = document.getElementById('filter-modal-overlay');
            const closeModalBtn = document.querySelector('.modal-close-btn');
            const applyBtn = document.querySelector('.btn-apply');
            const clearDatesBtn = document.getElementById('clear-dates-btn');

            // --- Calendar Elements ---
            const monthYearDisplay = document.getElementById('calendar-month-year');
            const calendarGridBody = document.getElementById('calendar-grid-body');
            const prevMonthBtn = document.getElementById('prev-month-btn');
            const nextMonthBtn = document.getElementById('next-month-btn');
            const fromDateDisplay = document.getElementById('from-date-display');
            const toDateDisplay = document.getElementById('to-date-display');

            // --- Calendar State ---
            let currentDate = new Date(2025, 8, 1); // September 2025 (months are 0-indexed)
            let startDate = new Date(2025, 8, 14);
            let endDate = new Date(2025, 8, 30);
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];

            // --- Modal Open/Close Functions ---
            const openModal = () => modalOverlay.classList.remove('hidden');
            const closeModal = () => modalOverlay.classList.add('hidden');

            // --- Date Formatting ---
            const formatDate = (date) => {
                if (!date) return "";
                return date.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            };

            const toISODateString = (date) => {
                const year = date.getFullYear();
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const day = date.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // --- Core Calendar Functionality ---
            const renderCalendar = () => {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
                calendarGridBody.innerHTML = '';

                const firstDayOfMonth = new Date(year, month, 1);
                const lastDayOfMonth = new Date(year, month + 1, 0);
                const daysInMonth = lastDayOfMonth.getDate();
                const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7; // Monday is 0

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
                updateDateInputs();
            };

            const updateDateInputs = () => {
                fromDateDisplay.textContent = formatDate(startDate);
                toDateDisplay.textContent = formatDate(endDate);
            };

            const handleDateClick = (e) => {
                const clickedDateStr = e.target.dataset.date;
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
            };

            // --- Event Listeners ---
            filterButton.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            applyBtn.addEventListener('click', closeModal);
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            clearDatesBtn.addEventListener('click', () => {
                startDate = null;
                endDate = null;
                renderCalendar();
            });

            renderCalendar();
        });
    </script>
    <script>
        // Jab poora page load ho jaye tab yeh script chalayein
        document.addEventListener('DOMContentLoaded', function() {

            const dropdownToggle = document.getElementById('profileDropdownToggle');

            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(event) {
                    event.preventDefault();
                    const parentContainer = this.parentElement;
                    parentContainer.classList.toggle('open');
                });
            }

            const activeDropdownMenu = document.querySelector('.dropdown-menu.show');
            if (activeDropdownMenu) {
                activeDropdownMenu.parentElement.classList.add('open');
            }

        });
    </script>
    {{-- <script> --}}
    {{--    document.addEventListener('DOMContentLoaded', function() { --}}
    {{--        // Clickable area aur dropdown menu ko select karein --}}
    {{--        const dropdownToggleArea = document.getElementById('profileToggleArea'); --}}
    {{--        const dropdownMenu = document.getElementById('profileDropdownMenu'); --}}

    {{--        // Check karein ke yeh dono cheezein page par maujood hain --}}
    {{--        if (dropdownToggleArea && dropdownMenu) { --}}

    {{--            // Clickable area par click listener lagayein --}}
    {{--            dropdownToggleArea.addEventListener('click', function(event) { --}}
    {{--                event.stopPropagation(); // Event ko bubble hone se rokein --}}
    {{--                dropdownMenu.classList.toggle('show'); // 'show' class ko add/remove karein --}}
    {{--            }); --}}
    {{--        } --}}

    {{--        // Agar page par kahin aur click ho to dropdown ko band kar dein --}}
    {{--        document.addEventListener('click', function(event) { --}}
    {{--            if (dropdownMenu && dropdownMenu.classList.contains('show')) { --}}
    {{--                // Agar click dropdown ya uske toggle area ke bahar hua ho --}}
    {{--                if (!dropdownToggleArea.contains(event.target)) { --}}
    {{--                    dropdownMenu.classList.remove('show'); --}}
    {{--                } --}}
    {{--            } --}}
    {{--        }); --}}
    {{--    }); --}}
    {{-- </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Elements ko select karein ---
            const profileToggle = document.getElementById('profileToggleArea');
            const profileMenu = document.getElementById('profileDropdownMenu');
            const notificationToggle = document.getElementById('notificationBellIcon');
            const notificationMenu = document.getElementById('notificationDropdown');

            // --- Profile Dropdown ke liye Click Event ---
            if (profileToggle && profileMenu) {
                profileToggle.addEventListener('click', function(event) {
                    event.stopPropagation(); // Event ko aage badhne se rokein

                    // Profile menu ko kholein ya band karein
                    profileMenu.classList.toggle('show');

                    // Agar notification menu khula hai to usay band kar dein
                    if (notificationMenu && notificationMenu.classList.contains('show')) {
                        notificationMenu.classList.remove('show');
                    }
                });
            }

            // --- Notification Dropdown ke liye Click Event ---
            if (notificationToggle && notificationMenu) {
                notificationToggle.addEventListener('click', function(event) {
                    event.stopPropagation(); // Event ko aage badhne se rokein

                    // Notification menu ko kholein ya band karein
                    notificationMenu.classList.toggle('show');

                    // Agar profile menu khula hai to usay band kar dein
                    if (profileMenu && profileMenu.classList.contains('show')) {
                        profileMenu.classList.remove('show');
                    }
                });
            }

            // --- Page par kahin bhi click karne se dropdowns band ho jayein ---
            document.addEventListener('click', function(event) {
                // Profile dropdown ko band karein agar click bahar hua hai
                if (profileMenu && profileMenu.classList.contains('show')) {
                    if (!profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
                        profileMenu.classList.remove('show');
                    }
                }

                // Notification dropdown ko band karein agar click bahar hua hai
                if (notificationMenu && notificationMenu.classList.contains('show')) {
                    if (!notificationToggle.contains(event.target) && !notificationMenu.contains(event
                            .target)) {
                        notificationMenu.classList.remove('show');
                    }
                }
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Language dropdown toggle
        $("#selectedLanguage").on("click", function () {
            $("#languageDropdown").toggle();
            $(".language-selector").toggleClass("open");
        });

        // Close when clicking outside
        $(document).on("click", function (e) {
            if (!$(e.target).closest('.language-selector').length) {
                $("#languageDropdown").hide();
                $(".language-selector").removeClass("open");
            }
        });

        // Language change AJAX (aapki wali script)
        $('input[name="language"]').on('change', function () {
            let lang = $(this).val();

            $.post("{{ route('lang.ajaxSwitch') }}", {
                _token: "{{ csrf_token() }}",
                lang: lang
            }, function (data) {
                if (data.status === 'success') {
                    location.reload();
                }
            });
        });
    });
</script>

</body>

</html>
