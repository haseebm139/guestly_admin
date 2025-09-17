@extends('layouts.master')

@section('title', 'The Inkwell Studio Profile')

@section('content')
    <style>
        /* Main Page CSS (No Changes) */
        .location-map-container { position: relative; }
        #map { height: 450px; width: 100%; border-radius: 12px; background-color: #e9e9e9; }

        :root {
            --bg-color: #e6f4f0;
            --primary-green: #0b3d27;
            --secondary-green-btn: #5e8082;
            --text-primary: #0b3d27;
            --text-secondary: #5d7a70;
            --border-active: #0b3d27;
            --border-inactive: #e0e7e5;
            --card-bg: #ffffff;
            --label-color: #888;
        }
    </style>
    <div class="studio-detail-layout">

        {{-- ========== LEFT COLUMN: MAIN CONTENT ========== --}}
        <div class="studio-main-content">

            {{-- Hero Image Section (No changes here) --}}
            <section class="studio-hero">
                <img src="{{ asset ('dashboard/logo_main.jpg') }}">
                <div class="studio-hero-overlay">
                    <div class="hero-top">
                        <div class="studio-info-header">
                            <img src="{{ asset ('dashboard/default_1.png') }}" alt="The Inkwell Studio Logo" class="studio-logo">
                            <div>
                                <h1 class="studio-name">The Inkwell Studio</h1>
                                <p class="studio-location">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                                    San Diego, California, USA
                                </p>
                            </div>
                        </div>
                        <button class="like-button active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>
                        </button>
                    </div>
                    <div class="hero-bottom">
                        <div class="verified-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.638.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.639a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.638-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.638zM8.982 1.75c.576-.576 1.48-.576 2.056 0l.622.637.89-.011c1.033 0 1.9.867 1.9 1.9l-.01.89.638.622c.576.576.576 1.48 0 2.056l-.637.622.011.89c0 1.033-.867 1.9-1.9 1.9l-.89-.01.622.639c.576.576.576 1.48 0 2.056l-.622.637-.89.011c-1.033 0-1.9-.867-1.9-1.9l.01-.89-.638-.622c-.576-.576-.576-1.48 0-2.056l.637-.622-.011-.89c0-1.033.867-1.9 1.9-1.9l.89.01-.622-.638a1.44 1.44 0 0 1-.515-.923L8.982 1.75zM6.5 12.011l-3-3 1.054-1.054 1.946 1.947 4.95-4.95 1.054 1.054-6 6z"/></svg>
                            Verified
                        </div>
                        <div class="carousel-dots"><span class="dot active"></span><span class="dot"></span><span class="dot"></span></div>
                        <div class="star-rating">★★★★☆ <span>67 Review</span></div>
                    </div>
                </div>
            </section>

            {{-- Small Image Gallery --}}
            <section class="studio-image-gallery">
                <img src="{{ asset ('dashboard/logo_1.jpg') }}" alt="Gallery image 1">
                <img src="{{ asset ('dashboard/logo_2.jpg') }}" alt="Gallery image 2">
                <img src="{{ asset ('dashboard/logo_3.jpg') }}" alt="Gallery image 3">
                <img src="{{ asset ('dashboard/logo_4.jpg') }}" alt="Gallery image 4">
                <img src="{{ asset ('dashboard/logo_5.jpg') }}" alt="Gallery image 5">
                <img src="{{ asset ('dashboard/logo_6.jpg') }}" alt="Gallery image 6">
            </section>

            {{-- About Section --}}
            <section class="studio-section">
                <h2 class="section-title-md">About The Inkwell Studio</h2>
                <p>Nestled in the heart of Brooklyn, New York, Ink Haven Studio is a modern, artist-owned tattoo space built for creativity, comfort, and precision. With a strong focus on Fine Line and Black & Grey styles, we specialize in clean, detailed work that tells your story through timeless ink.</p>
            </section>

            {{-- NEW: 2-Column Grid for Amenities and Map --}}
            <div class="amenities-map-grid">
                {{-- Column 1: Amenities --}}
                <section>
                    <h2 class="section-title-md">Amenities</h2>
                    <div class="amenities-list">
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src="{{ asset ('extra/amenities_1.png') }}" alt="Studio Manager Icon" class="amenity-icon">
                            </div>
                            <span>Studio Manager or Assistant On Site</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src="{{ asset ('extra/amenities_2.png') }}" alt="Adjustable Chair Icon" class="amenity-icon">
                            </div>
                            <span>Adjustable Tattoo Chair or Table</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset ('extra/amenities_3.png') }}" alt="Fridge Icon" class="amenity-icon">
                            </div>
                            <span>Fridge</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset ('extra/amenities_4.png') }}" alt="24/7 Access Icon" class="amenity-icon">
                            </div>
                            <span>24/7 Studio Access</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset ('extra/amenities_5.png') }}" alt="Bathroom Icon" class="amenity-icon">
                            </div>
                            <span>Bathroom Access</span>
                        </div>
                    </div>
                </section>

                <section class="location-map-container">
                    <h2 class="section-title-md">Our Location</h2>

                    <div id="map"></div>
                </section>
            </div>

            {{-- Reviews Section --}}
            <section class="studio-section">
                <h2 class="section-title-md">What other people say</h2>
                <div class="reviews-grid">
                    {{-- Review Cards... --}}
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica1" alt="Jessica L."><div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div></div>
                            <div class="review-date">Jan 21 2025 <span>9:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my fine line piece came out even better than I imagined. Super professional and welcoming vibe. Will definitely be back!"</p>
                        <img src="{{ asset ('dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica2" alt="Jessica L."><div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div></div>
                            <div class="review-date">Jan 21 2025 <span>8:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my fine line piece came out even better than I imagined. Super professional and welcoming vibe. Will definitely be back!"</p>
                        <img src="{{ asset ('dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica2" alt="Jessica L."><div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div></div>
                            <div class="review-date">Jan 21 2025 <span>8:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my fine line piece came out even better than I imagined. Super professional and welcoming vibe. Will definitely be back!"</p>
                        <img src="{{ asset ('dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap">
    </script>
    <script>
        const studios = [
            { name: 'The Inkwell Studio', location: 'San Diego, CA', lat: 40.7650, lng: -73.9995, logo: "{{ asset('dashboard/default_1.png') }}", coverImage: "{{ asset('dashboard/default_1_profile.jpg') }}", hours: '12:00 PM – 10:00 PM', specialties: 'Realism & Illustrative', isOpen: true },
            { name: 'Electric Tiger Tattoo', location: 'Manhattan, NY', lat: 40.7831, lng: -73.9712, logo: "{{ asset('dashboard/default_3.png') }}", coverImage: "{{ asset('dashboard/default_3_profile.jpg') }}", hours: '11:00 AM – 9:00 PM', specialties: 'Neo-Traditional', isOpen: false },
            { name: 'Crimson Lotus Tattoo', location: 'Brooklyn, NY', lat: 40.6782, lng: -73.9442, logo: "{{ asset('dashboard/default_2.png') }}", coverImage: "{{ asset('dashboard/default_2_profile.jpg') }}", hours: '10:00 AM – 8:00 PM', specialties: 'Tattoo & Piercing', isOpen: true }
        ];

        let map;
        const panelWrapper = document.getElementById('details-panel-wrapper');

        function initMap() {
            class CustomMarker extends google.maps.OverlayView {
                constructor(position, map, studio) { super(); this.position = position; this.studio = studio; this.div = null; this.setMap(map); }
                onAdd() { this.div = document.createElement("div"); this.div.className = "custom-marker"; this.div.innerHTML = `<div class="marker-label">${this.studio.name}</div><div class="marker-pin"><svg width="48" height="56" viewBox="0 0 60 70"><defs><filter id="shadow" x="-50%" y="-50%" width="200%" height="200%"><feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#000000" flood-opacity="0.3"/></filter></defs><path d="M30 70C30 70 5 45 5 25C5 12.8 16.2 2 30 2C43.8 2 55 12.8 55 25C55 45 30 70 30 70Z" fill="white" filter="url(#shadow)"/><circle cx="30" cy="25" r="22" fill="none" stroke="#d1d5db" stroke-width="4" class="marker-border"/><image href="${this.studio.logo}" x="8" y="3" height="44" width="44" clip-path="url(#circleClip${this.studio.lat})" /><clipPath id="circleClip${this.studio.lat}"><circle cx="30" cy="25" r="22"/></clipPath></svg></div>`; this.addListeners(); const panes = this.getPanes(); panes.overlayMouseTarget.appendChild(this.div); }
                draw() { const overlayProjection = this.getProjection(); if (!overlayProjection || !this.div) return; const sw = overlayProjection.fromLatLngToDivPixel(this.position); const totalHeight = this.div.offsetHeight; this.div.style.left = sw.x + "px"; this.div.style.top = (sw.y - totalHeight) + "px"; }
                onRemove() { if (this.div) { this.div.parentNode.removeChild(this.div); this.div = null; } }
                addListeners() { const pin = this.div.querySelector('.marker-pin'); const border = this.div.querySelector('.marker-border'); pin.addEventListener("mouseover", () => { border.style.transition = 'stroke 0.3s ease'; border.style.stroke = "#10B981"; }); pin.addEventListener("mouseout", () => { border.style.stroke = "#d1d5db"; }); this.div.addEventListener("click", () => { showStudioDetails(this.studio); }); }
            }

            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 40.7128, lng: -74.0060 },
                zoom: 12,
                disableDefaultUI: true,
                styles: [ { "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }] },{ "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },{ "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] },{ "elementType": "labels.text.stroke", "stylers": [{ "color": "#f5f5f5" }] },{ "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }] },{ "featureType": "road.highway", "elementType": "geometry", "stylers": [{ "color": "#dadada" }] },{ "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#c9c9c9" }] } ]
            });

            const bounds = new google.maps.LatLngBounds();

            studios.forEach(studio => {
                const position = new google.maps.LatLng(studio.lat, studio.lng);
                new CustomMarker(position, map, studio);
                bounds.extend(position);
            });

            google.maps.event.addListenerOnce(map, 'idle', function(){
                if (studios.length > 0) {
                    if (studios.length > 1) {
                        map.fitBounds(bounds, 50);
                    } else {
                        map.setCenter(bounds.getCenter());
                        map.setZoom(14);
                    }
                }
            });

            if (panelWrapper) {
                panelWrapper.addEventListener('click', function(event) { if (event.target && event.target.id === 'close-btn') { panelWrapper.classList.remove('active'); } });
                map.addListener('dragstart', () => panelWrapper.classList.remove('active'));
                map.addListener('zoom_changed', () => panelWrapper.classList.remove('active'));
            }
        }

        function showStudioDetails(studio) {
            if (!panelWrapper) return;
            panelWrapper.innerHTML = `
            <div class="studio-card">
                <div class="card-image-wrapper">
                    <button id="close-btn">×</button>
                    <img src="${studio.coverImage}" alt="${studio.name} cover image" class="card-image">
                </div>
                <div class="card-body">
                     <div class="card-header">
                        <div class="card-logo-wrapper">
                            <img src="${studio.logo}" alt="${studio.name} logo" class="card-logo">
                            <div class="card-title-location">
                                <h3 class="card-title">${studio.name}</h3>
                                <div class="card-location">
                                    <img src="{{ asset('extra/location_logo.png') }}" alt="Location">
                                    <span>${studio.location}</span>
                                </div>
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
@endsection
