@extends('user.layouts.master')

{{-- @section('head') --}}
{{-- @endsection --}}

@section('content')
    <div class="container-fluid explore_main_sec">
        <div class="row">
            <div class="col-md-12">
                <div class="search-section">
                    <p class="search-text">Over 14 Studios nearby</p>
                    <div class="search-controls">
                        <div class="search-input-wrapper">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="{{ __('search_paragraph') }}" class="search-input">
                        </div>
                        <button class="filter-button" data-bs-toggle="modal" data-bs-target="#filter-modal-overlay">
                            <i class="fa-solid fa-sliders"></i>
                            <span>{{ __('filter') }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Left: Studio Cards -->
                <div class="cards_container">
                    <div class="row">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="col-xxl-6 col-xl-12 col-lg-12">
                                <!-- Studio Card 1 -->
                                <div class="studio-card">
                                    <div class="card_image_wrapper">
                                        <div class="swiper swiper_slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('assets/web/dashboard/default_1_profile.jpg') }}"
                                                        alt="The Inkwell Studio Logo" class="">
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('assets/web/dashboard/default_2_profile.jpg') }}"
                                                        alt="The Inkwell Studio Logo" class="">
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('assets/web/dashboard/default_3_profile.jpg') }}"
                                                        alt="The Inkwell Studio Logo" class="">
                                                </div>
                                            </div>
                                            <!-- Add Navigation -->
                                            {{-- <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div> --}}
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                    <div class="card_content_wrapper"
                                        onclick=window.location.href="{{ asset('dashboard/studio_detail') }}">
                                        <div class="card-header">
                                            <div class="card-logo-wrapper">
                                                <img src="{{ asset('assets/web/dashboard/default_1.png') }}"
                                                    alt="The Inkwell Studio Logo" class="card-logo">
                                            </div>
                                            <div class="card_location_wrapper">
                                                <p>The Inkwell Studio</p>
                                                <img src="{{ asset('assets/web/extra/location_logo.png') }}" alt="Location"
                                                    style="width: 16px; height: 16px; vertical-align: middle;">
                                                <span>San Diego, California, USA</span>
                                            </div>
                                            <button class="card-like-btn">
                                                <svg fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="card-info-section">
                                            <div class="card-status-row">
                                                <span class="card-verified">
                                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span>Verified</span>
                                                </span>
                                                <span class="card-status-badge open">OPEN</span>
                                            </div>
                                            <div class="card-details">
                                                <div class="timings_detail">
                                                    <span>Open Today: 12:00 PM - 10:00 PM</span>
                                                </div>
                                                <div class="specialities_wrapper">
                                                    <span>Specialties: Realism & Illustrative - Bold & Graphic</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Right: Map -->
                <div id="map-container">
                    <div id="map"></div>

                    <!-- NEW HTML STRUCTURE BASED ON YOUR CSS -->
                    <div id="details-panel-wrapper">
                        <div class="studio-card">
                            <div class="card-image-wrapper">
                                <button id="close-btn" class="modal-close-btn">×</button>
                                <div id="image-container">
                                    <!-- Main Image will be injected by JS here -->
                                </div>
                                <div id="slider-dots" class="card-image-dots">
                                    <!-- Slider dots will be injected by JS here -->
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card-header">
                                    <div class="card-logo-wrapper">
                                        <img id="studio-logo" src="" alt="Studio Logo" class="card-logo">
                                        <div class="card-title-location">
                                            <h3 id="studio-name" class="card-title"></h3>
                                            <div id="studio-location" class="card-location"></div>
                                        </div>
                                    </div>
                                    <button class="card-like-btn" aria-label="Like this studio">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="card-info-section">
                                    <div class="card-status-row">
                                        <div class="card-verified">
                                            <svg fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Verified</span>
                                        </div>
                                        <span id="status-badge" class="card-status-badge"></span>
                                    </div>
                                    <div id="studio-details" class="card-details">
                                        <!-- Hours and Specialties will be injected here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <!-- Studio Card 2 -->
        <div class="studio-card" onclick=window.location.href="{{ asset('assets/web/dashboard/studio_detail') }}">
            <div class="card-image-wrapper">
                <img src="{{ asset ('dashboard/default_3_profile.jpg') }}" alt="Arm tattoo" class="card-image">
                <div class="card-image-dots">
                    <span class="active"></span><span></span><span></span>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <div class="card-logo-wrapper">
                        <img src="{{ asset ('dashboard/default_3.png') }}" alt="Electric Tiger Tattoo Logo" class="card-logo">
                        <div class="card-title-location">
                            <h3 class="card-title">Electric Tiger Tattoo</h3>
                            <p class="card-location">
                                <img src="{{ asset ('extra/location_logo.png') }}" alt="Location" style="width: 16px; height: 16px; vertical-align: middle;">
                                San Diego, California, USA
                            </p>
                        </div>
                    </div>
                    <button class="card-like-btn">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="card-info-section">
                    <div class="card-status-row">
                        <span class="card-verified">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span>Verified</span>
                        </span>
                        <span class="card-status-badge open">OPEN</span>
                    </div>
                    <div class="card-details">
                        <p>Open Today: 9:00 AM - 5:00 PM</p>
                        <p>Specialties: Painterly & Abstract</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Studio Card 3 -->
        <div class="studio-card" onclick=window.location.href="{{ asset('assets/web/dashboard/studio_detail') }}">
            <div class="card-image-wrapper">
                <img src="{{ asset ('dashboard/default_2_profile.jpg') }}" alt="Hand tattoos" class="card-image">
            </div>
            <div class="card-body">
                <div class="card-header">
                    <div class="card-logo-wrapper">
                        <img src="{{ asset ('dashboard/default_2.png') }}" alt="Crimson Lotus Tattoo Logo" class="card-logo">
                        <div class="card-title-location">
                            <h3 class="card-title">Crimson Lotus Tattoo</h3>
                            <p class="card-location">
                                <img src="{{ asset ('extra/location_logo.png') }}" alt="Location" style="width: 16px; height: 16px; vertical-align: middle;">
                                San Diego, California, USA
                            </p>
                        </div>
                    </div>
                    <button class="card-like-btn">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="card-info-section" >
                    <div class="card-status-row">
                        <span class="card-verified">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span>Verified</span>
                        </span>
                        <span class="card-status-badge open">OPEN</span>
                    </div>
                    <div class="card-details">
                        <p>Open Today: 12:00 PM - 10:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Studio Card 4 (Closed) -->
        <div class="studio-card" onclick=window.location.href="{{ asset('assets/web/dashboard/studio_detail') }}">
            <div class="card-image-wrapper">
                <img src="{{ asset ('dashboard/default_1_profile.jpg') }}" alt="Another tattoo artist" class="card-image">
                <div class="card-image-dots">
                    <span class="active"></span><span></span>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <div class="card-logo-wrapper">
                        <img src="{{ asset ('dashboard/default_1.png') }}" alt="The Inkwell Studio Logo" class="card-logo">
                        <div class="card-title-location">
                            <h3 class="card-title">The Inkwell Studio</h3>
                            <p class="card-location">
                                <img src=" {{ asset ('extra/location_logo.png') }}" alt="Location" style="width: 16px; height: 16px; vertical-align: middle;">
                                San Diego, California, USA
                            </p>
                        </div>
                    </div>
                    <button class="card-like-btn">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="card-info-section">
                    <div class="card-status-row">
                        <span class="card-verified">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span>Verified</span>
                        </span>
                        <span class="card-status-badge closed">CLOSED</span>
                    </div>
                    <div class="card-details">
                        <p>Opens Tomorrow: 12:00 PM</p>
                    </div>
                </div>
            </div>
        </div> --}}


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
                            <div class="calendar-container">
                                <div class="calendar-header">
                                    <button id="prev-month-btn" class="calendar-nav">&lt;</button>
                                    <span id="calendar-month-year" class="calendar-month-year"></span>
                                    <button id="next-month-btn" class="calendar-nav">&gt;</button>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
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
        {{-- Leaflet JS is needed for the map --}}
        {{--    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> --}}
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap">
        </script>
        {{--    <script> --}}
        {{--        // Initialize map, centered on New York City --}}
        {{--        var map = L.map('map', { --}}
        {{--            zoomControl: false, // Hide default zoom +/- --}}
        {{--        }).setView([40.74, -73.98], 13); --}}

        {{--        // Add a light-themed tile layer from CartoDB, similar to the image --}}
        {{--        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { --}}
        {{--            maxZoom: 19, --}}
        {{--            // attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors © <a href="https://carto.com/attributions">CARTO</a>' --}}
        {{--        }).addTo(map); --}}

        {{--        // --- CUSTOM MARKERS --- --}}

        {{--        // Data for studios based on the image --}}
        {{--        const studios = [ --}}
        {{--            { name: 'The Inkwell Studio', latlng: [40.7650, -73.9995] }, --}}
        {{--            { name: 'Crimson Lotus Tattoo', latlng: [40.7829, -73.9654] }, --}}
        {{--            { name: 'Electric Tiger Tattoo', latlng: [40.7295, -73.9930] } --}}
        {{--        ]; --}}

        {{--        // SVG icon for the studio markers --}}
        {{--        const buildingSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" /></svg>`; --}}

        {{--        // Loop through studios and add a custom marker for each --}}
        {{--        studios.forEach(studio => { --}}
        {{--            const studioIcon = L.divIcon({ --}}
        {{--                html: ` --}}
        {{--                    <div class="studio-marker"> --}}
        {{--                        <div class="studio-marker-icon">${buildingSVG}</div> --}}
        {{--                        <span>${studio.name}</span> --}}
        {{--                    </div> --}}
        {{--                `, --}}
        {{--                className: '', // Leaflet adds 'leaflet-div-icon' class by default --}}
        {{--                iconSize: null, // Size will be determined by CSS --}}
        {{--                iconAnchor: [75, 18] // Center of the icon, adjust as needed --}}
        {{--            }); --}}

        {{--            L.marker(studio.latlng, { icon: studioIcon }).addTo(map); --}}
        {{--        }); --}}

        {{--        // Add the 'You' marker --}}
        {{--        const youLocation = [40.7484, -73.9500]; // An example "You" location --}}

        {{--        const youIcon = L.divIcon({ --}}
        {{--            html: '<div class="you-marker-icon"></div>', --}}
        {{--            className: '', --}}
        {{--            iconSize: [24, 24], --}}
        {{--            iconAnchor: [12, 12] --}}
        {{--        }); --}}

        {{--        L.marker(youLocation, { icon: youIcon, zIndexOffset: 1000 }).addTo(map) --}}
        {{--            .bindTooltip('You', { --}}
        {{--                permanent: true, --}}
        {{--                direction: 'right', --}}
        {{--                offset: [15, 0], --}}
        {{--                className: 'you-tooltip' --}}
        {{--            }); --}}

        {{--    </script> --}}
        <script>
            // --- DATA (Aapke image paths ke saath) ---
            const studios = [{
                    name: 'The Inkwell Studio',
                    location: 'San Diego, CA',
                    lat: 40.7650,
                    lng: -73.9995,
                    logo: "{{ asset('assets/web/dashboard/default_1.png') }}",
                    coverImage: "{{ asset('assets/web/dashboard/default_1_profile.jpg') }}",
                    hours: '12:00 PM – 10:00 PM',
                    specialties: 'Realism & Illustrative',
                    isOpen: true
                },
                {
                    name: 'Electric Tiger Tattoo',
                    location: 'Manhattan, NY',
                    lat: 40.7831,
                    lng: -73.9712,
                    logo: "{{ asset('assets/web/dashboard/default_3.png') }}",
                    coverImage: "{{ asset('assets/web/dashboard/default_3_profile.jpg') }}",
                    hours: '11:00 AM – 9:00 PM',
                    specialties: 'Neo-Traditional',
                    isOpen: false
                },
                {
                    name: 'Crimson Lotus Tattoo',
                    location: 'Brooklyn, NY',
                    lat: 40.6782,
                    lng: -73.9442,
                    logo: "{{ asset('assets/web/dashboard/default_2.png') }}",
                    coverImage: "{{ asset('assets/web/dashboard/default_2_profile.jpg') }}",
                    hours: '10:00 AM – 8:00 PM',
                    specialties: 'Tattoo & Piercing',
                    isOpen: true
                }
            ];

            let map;
            const panelWrapper = document.getElementById('details-panel-wrapper');

            function initMap() {
                class CustomMarker extends google.maps.OverlayView {
                    constructor(position, map, studio) {
                        super();
                        this.position = position;
                        this.studio = studio;
                        this.div = null;
                        this.setMap(map);
                    }
                    onAdd() {
                        this.div = document.createElement("div");
                        this.div.className = "custom-marker";
                        this.div.innerHTML =
                            `<div class="marker-label">${this.studio.name}</div><div class="marker-pin"><svg width="48" height="56" viewBox="0 0 60 70"><defs><filter id="shadow" x="-50%" y="-50%" width="200%" height="200%"><feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#000000" flood-opacity="0.3"/></filter></defs><path d="M30 70C30 70 5 45 5 25C5 12.8 16.2 2 30 2C43.8 2 55 12.8 55 25C55 45 30 70 30 70Z" fill="white" filter="url(#shadow)"/><circle cx="30" cy="25" r="22" fill="none" stroke="#d1d5db" stroke-width="4" class="marker-border"/><image href="${this.studio.logo}" x="8" y="3" height="44" width="44" clip-path="url(#circleClip${this.studio.lat})" /><clipPath id="circleClip${this.studio.lat}"><circle cx="30" cy="25" r="22"/></clipPath></svg></div>`;
                        this.addListeners();
                        const panes = this.getPanes();
                        panes.overlayMouseTarget.appendChild(this.div);
                    }
                    draw() {
                        const overlayProjection = this.getProjection();
                        if (!overlayProjection || !this.div) return;
                        const sw = overlayProjection.fromLatLngToDivPixel(this.position);
                        const totalHeight = this.div.offsetHeight;
                        this.div.style.left = sw.x + "px";
                        this.div.style.top = (sw.y - totalHeight) + "px";
                    }
                    onRemove() {
                        if (this.div) {
                            this.div.parentNode.removeChild(this.div);
                            this.div = null;
                        }
                    }
                    addListeners() {
                        const pin = this.div.querySelector('.marker-pin');
                        const border = this.div.querySelector('.marker-border');
                        pin.addEventListener("mouseover", () => {
                            border.style.transition = 'stroke 0.3s ease';
                            border.style.stroke = "#10B981";
                        });
                        pin.addEventListener("mouseout", () => {
                            border.style.stroke = "#d1d5db";
                        });
                        this.div.addEventListener("click", () => {
                            showStudioDetails(this.studio);
                        });
                    }
                }

                // Map ko initialize karein
                map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: 40.7128,
                        lng: -74.0060
                    }, // Default center, foran badal jayega
                    zoom: 12,
                    disableDefaultUI: true,
                    styles: [{
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#f5f5f5"
                        }]
                    }, {
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }, {
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#616161"
                        }]
                    }, {
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "color": "#f5f5f5"
                        }]
                    }, {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#ffffff"
                        }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#dadada"
                        }]
                    }, {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#c9c9c9"
                        }]
                    }]
                });

                // === YAHAN BADA BADLAAV HAI ===

                // Saare markers ko fit karne ke liye ek bounds object banayein
                const bounds = new google.maps.LatLngBounds();

                studios.forEach(studio => {
                    const position = new google.maps.LatLng(studio.lat, studio.lng);
                    new CustomMarker(position, map, studio);
                    bounds.extend(position);
                });

                // 'idle' event ka intezar karein, jo sirf ek baar chalega
                google.maps.event.addListenerOnce(map, 'idle', function() {
                    // Check karein ki studios hain ya nahi
                    if (studios.length > 0) {
                        // Agar ek se zyada marker hain to map ko bounds ke hisaab se fit karein
                        if (studios.length > 1) {
                            // 50px padding add karein taaki markers kinare se na katein
                            map.fitBounds(bounds, 50);
                        } else {
                            // Agar sirf ek marker hai, to us par center karein
                            map.setCenter(bounds.getCenter());
                            map.setZoom(14);
                        }
                    }
                });
                // ===================================

                panelWrapper.addEventListener('click', function(event) {
                    if (event.target && event.target.id === 'close-btn') {
                        panelWrapper.classList.remove('active');
                    }
                });
                map.addListener('dragstart', () => panelWrapper.classList.remove('active'));
                map.addListener('zoom_changed', () => panelWrapper.classList.remove('active'));
            }

            function showStudioDetails(studio) {
                // Is function mein koi badlaav nahi
                panelWrapper.innerHTML = `
            <div class="studio-card">
                <div class="card-image-wrapper">
                    <button id="close-btn" class="modal-close-btn">×</button>
                    <img src="${studio.coverImage}" alt="${studio.name} cover image" class="card-image">
                </div>
                <div class="card-body">
                     <div class="card-header">
                        <div class="card-logo-wrapper">
                            <img src="${studio.logo}" alt="${studio.name} logo" class="card-logo">
                        </div>
                        <div class="card-title-location">
                            <h3 class="card-title">${studio.name}</h3>
                            <div class="card-location">
                                <img src="{{ asset('assets/web/extra/location_logo.png') }}" alt="Location">
                                <span>${studio.location}</span>
                            </div>
                        </div>
                        <button class="card-like-btn" aria-label="Like this studio">
                           <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                    </div>
                    <div class="card-info-section">
                        <div class="card-status-row">
                            <div class="card-verified">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span>Verified</span>
                            </div>
                            <span class="card-status-badge ${studio.isOpen ? 'open' : 'closed'}">${studio.isOpen ? 'OPEN' : 'CLOSED'}</span>
                        </div>
                        <div class="card-details">
                            <strong>Hours:</strong> ${studio.hours}<br>
                            <strong>Specialties:</strong> ${studio.specialties}
                        </div>
                    </div>
                </div>
            </div>`;

                panelWrapper.classList.add('active');
            }
        </script>
        <script>
            // This script handles the initial body opacity transition for a smooth load effect.
            window.addEventListener('load', () => {
                document.body.style.opacity = 1;
            });
        </script>
        <script>
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

                // // --- Modal Open/Close Functions ---
                // const openModal = () => {
                //     modalOverlay.classList.remove('hidden');
                //     filterButton.classList.add('open');
                // }
                // const closeModal = () => {
                //     modalOverlay.classList.add('hidden');
                //     filterButton.classList.remove('open');
                // }

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
                    // Returns date in 'YYYY-MM-DD' format, ignoring time zones
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
                    // Adjust to make Monday the first day (0)
                    const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7;

                    // Add blank cells for days before the 1st of the month
                    for (let i = 0; i < startDayIndex; i++) {
                        calendarGridBody.innerHTML += `<div class="day-cell other-month"></div>`;
                    }

                    // Add cells for each day of the current month
                    for (let day = 1; day <= daysInMonth; day++) {
                        const cell = document.createElement('div');
                        cell.classList.add('day-cell');
                        cell.textContent = day.toString().padStart(2, '0');

                        const cellDate = new Date(year, month, day);
                        cell.dataset.date = toISODateString(cellDate);

                        // Add styling for selected dates and range
                        if (startDate && toISODateString(cellDate) === toISODateString(startDate)) {
                            cell.classList.add('start-date');
                            if (endDate && toISODateString(startDate) === toISODateString(endDate)) {
                                cell.classList.add('end-date'); // Also an end date if it's a single day selection
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

                    const clickedDate = new Date(clickedDateStr +
                    'T00:00:00'); // Use T00:00:00 to avoid timezone issues

                    // Logic for selecting start/end dates
                    if (!startDate || (startDate && endDate)) {
                        startDate = clickedDate;
                        endDate = null;
                    } else if (clickedDate < startDate) {
                        // If clicked date is before start date, make it the new start date
                        startDate = clickedDate;
                    } else {
                        // Otherwise, set it as the end date
                        endDate = clickedDate;
                    }
                    renderCalendar();
                };

                // --- Event Listeners ---
                // filterButton.addEventListener('click', openModal);
                // closeModalBtn.addEventListener('click', closeModal);
                // applyBtn.addEventListener('click', closeModal);
                // modalOverlay.addEventListener('click', (e) => {
                //     if (e.target === modalOverlay) closeModal();
                // });

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
                    renderCalendar(); // Re-render to clear highlights and inputs
                });

                // Initial render on page load
                renderCalendar();
            });
        </script>
    @endsection
