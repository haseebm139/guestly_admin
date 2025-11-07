@extends('user.layouts.master')

@section('title', 'The Inkwell Studio Details')

@section('content')
    <style>
        /* Main Page CSS (No Changes) */
        .location-map-container {
            position: relative;
        }

        #map {
            height: 450px;
            width: 100%;
            border-radius: 12px;
            background-color: #e9e9e9;
        }

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
                <img src="{{ asset('assets/web/dashboard/logo_main.jpg') }}">
                <div class="studio-hero-overlay">
                    <div class="hero-top">
                        <div class="studio-info-header">
                            <img src="{{ asset('assets/web/dashboard/default_1.png') }}" alt="The Inkwell Studio Logo"
                                class="studio-logo">
                            <div>
                                <h1 class="studio-name">The Inkwell Studio</h1>
                                <p class="studio-location">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                    </svg>
                                    San Diego, California, USA
                                </p>
                            </div>
                        </div>
                        <button class="like-button active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                        </button>
                    </div>
                    <div class="hero-bottom">
                        <div class="verified-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.638.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.639a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.638-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.638zM8.982 1.75c.576-.576 1.48-.576 2.056 0l.622.637.89-.011c1.033 0 1.9.867 1.9 1.9l-.01.89.638.622c.576.576.576 1.48 0 2.056l-.637.622.011.89c0 1.033-.867 1.9-1.9 1.9l-.89-.01.622.639c.576.576.576 1.48 0 2.056l-.622.637-.89.011c-1.033 0-1.9-.867-1.9-1.9l.01-.89-.638-.622c-.576-.576-.576-1.48 0-2.056l.637-.622-.011-.89c0-1.033.867-1.9 1.9-1.9l.89.01-.622-.638a1.44 1.44 0 0 1-.515-.923L8.982 1.75zM6.5 12.011l-3-3 1.054-1.054 1.946 1.947 4.95-4.95 1.054 1.054-6 6z" />
                            </svg>
                            Verified
                        </div>
                        <div class="carousel-dots"><span class="dot active"></span><span class="dot"></span><span
                                class="dot"></span></div>
                        <div class="star-rating">★★★★☆ <span>67 Review</span></div>
                    </div>
                </div>
            </section>

            {{-- Small Image Gallery --}}
            <section class="studio-image-gallery">
                <img src="{{ asset('assets/web/dashboard/logo_1.jpg') }}" alt="Gallery image 1">
                <img src="{{ asset('assets/web/dashboard/logo_2.jpg') }}" alt="Gallery image 2">
                <img src="{{ asset('assets/web/dashboard/logo_3.jpg') }}" alt="Gallery image 3">
                <img src="{{ asset('assets/web/dashboard/logo_4.jpg') }}" alt="Gallery image 4">
                <img src="{{ asset('assets/web/dashboard/logo_5.jpg') }}" alt="Gallery image 5">
                <img src="{{ asset('assets/web/dashboard/logo_6.jpg') }}" alt="Gallery image 6">
            </section>

            {{-- About Section --}}
            <section class="studio-section">
                <h2 class="section-title-md">About The Inkwell Studio</h2>
                <p>Nestled in the heart of Brooklyn, New York, Ink Haven Studio is a modern, artist-owned tattoo space built
                    for creativity, comfort, and precision. With a strong focus on Fine Line and Black & Grey styles, we
                    specialize in clean, detailed work that tells your story through timeless ink.</p>
            </section>

            {{-- NEW: 2-Column Grid for Amenities and Map --}}
            <div class="amenities-map-grid">
                {{-- Column 1: Amenities --}}
                <section>
                    <h2 class="section-title-md">Amenities</h2>
                    <div class="amenities-list">
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src="{{ asset('assets/web/extra/amenities_1.png') }}" alt="Studio Manager Icon"
                                    class="amenity-icon">
                            </div>
                            <span>Studio Manager or Assistant On Site</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src="{{ asset('assets/web/extra/amenities_2.png') }}" alt="Adjustable Chair Icon"
                                    class="amenity-icon">
                            </div>
                            <span>Adjustable Tattoo Chair or Table</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset('assets/web/extra/amenities_3.png') }}" alt="Fridge Icon" class="amenity-icon">
                            </div>
                            <span>Fridge</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset('assets/web/extra/amenities_4.png') }}" alt="24/7 Access Icon"
                                    class="amenity-icon">
                            </div>
                            <span>24/7 Studio Access</span>
                        </div>
                        <div class="amenity-item">
                            <div class="amenity-icon-container">
                                <img src=" {{ asset('assets/web/extra/amenities_5.png') }}" alt="Bathroom Icon" class="amenity-icon">
                            </div>
                            <span>Bathroom Access</span>
                        </div>
                    </div>
                </section>

                {{-- Column 2: Location Map --}}
                {{--                <section> --}}
                {{--                    <h2 class="section-title-md">Our Location</h2> --}}
                {{--                    <div id="map"></div> --}}
                {{--                </section> --}}
                {{--                <section class="location-map-container"> --}}
                {{--                    <h2 class="section-title-md">Our Location</h2> --}}

                {{--                    --}}{{-- FLOATING BOOKING CARD --}}
                {{--                    <div class="booking-card"> --}}
                {{--                        <div class="booking-card-content"> --}}
                {{--                            <svg class="calendar-icon" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg> --}}
                {{--                            <span>Calendar Availability</span> --}}
                {{--                        </div> --}}
                {{--                        <a href="#" class="book-now-button">Book Now</a> --}}
                {{--                    </div> --}}
                {{--                    --}}{{-- END OF CARD --}}

                {{--                    <div id="map"></div> --}}
                {{--                </section> --}}
                <section class="location-map-container">
                    <h2 class="section-title-md">Our Location</h2>
                    <div class="booking-card">
                        <div class="booking-card-content"><svg class="calendar-icon" width="24" height="24"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z" />
                            </svg> <span>Calendar Availability</span></div>
                        <button id="open-booking-modal-btn" class="book-now-button">Book Now</button>
                    </div>
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
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica1" alt="Jessica L.">
                                <div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div>
                            </div>
                            <div class="review-date">Jan 21 2025 <span>9:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my
                            fine line piece came out even better than I imagined. Super professional and welcoming vibe.
                            Will definitely be back!"</p>
                        <img src="{{ asset('assets/web/dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica2"
                                    alt="Jessica L.">
                                <div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div>
                            </div>
                            <div class="review-date">Jan 21 2025 <span>8:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my
                            fine line piece came out even better than I imagined. Super professional and welcoming vibe.
                            Will definitely be back!"</p>
                        <img src="{{ asset('assets/web/dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-user-info"><img src="https://i.pravatar.cc/40?u=jessica2"
                                    alt="Jessica L.">
                                <div><strong>Jessica L.</strong><span>San Diego, California, USA</span></div>
                            </div>
                            <div class="review-date">Jan 21 2025 <span>8:08PM</span></div>
                        </div>
                        <p class="review-text">"Absolutely loved my experience at Ink Haven! The studio is spotless, and my
                            fine line piece came out even better than I imagined. Super professional and welcoming vibe.
                            Will definitely be back!"</p>
                        <img src="{{ asset('assets/web/dashboard/review_logo.jpg') }}" class="review-image" alt="Tattoo example">
                    </div>
                </div>
            </section>

        </div>
    </div>
    <div class="booking-modal-overlay" id="booking-modal-overlay">
        <div class="booking-modal-container" id="booking-modal-container">
            <button id="close-modal-btn">&times;</button>
            <div class="form-slider-track">

                <!-- Step 1: Date Selection -->
                <div class="form-step active" data-step="0">
                    <h2>Book your Spot</h2>
                    <p class="subtitle">Please proceed to book your guest spot as an artist.</p>
                    <div class="progress-indicator">
                        <div class="progress-step active"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                    </div>
                    <div class="form-content-scrollable">
                        <div class="calendar">
                            <div class="calendar-header">
                                <span class="calendar-nav" id="prev-month-btn">&lt;</span>
                                <strong id="calendar-month-year"></strong>
                                <span class="calendar-nav" id="next-month-btn">&gt;</span>
                            </div>
                            <div id="calendar-grid-body"></div>
                        </div>
                        <div class="date-range-inputs">
                            <div class="form-group"><label>From</label>
                                <div class="date-display" id="from-date-display"></div>
                            </div>
                            <div class="form-group"><label>To</label>
                                <div class="date-display" id="to-date-display"></div>
                            </div>
                        </div>
                        <div class="field-row-bordered">
                            <span>Request a Studio Tour</span>
                            <div class="billing-toggle"><span>Yes</span><label class="switch"><input type="checkbox"
                                        checked><span class="slider"></span></label><span>No</span></div>
                        </div>
                    </div>
                    <div class="button-group"><button class="nav-btn back-btn" disabled>Back</button><button
                            class="nav-btn next-btn">Next</button></div>
                </div>

                <div class="form-step" data-step="1">
                    <h2>Book your Spot</h2>
                    <p class="subtitle">Please proceed to book your guest spot as an artist.</p>
                    <div class="progress-indicator">
                        <div class="progress-step active"></div>
                        <div class="progress-step active"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                    </div>

                    <div class="form-content-scrollable">
                        <div class="form-section-title">Upload Your Work</div>

                        <!-- File Type Dropdown with Floating Label -->
                        <div class="floating-label-group">
                            <select id="file-type" required>
                                <option value="Portfolio" selected>Portfolio</option>
                                <option value="CV">CV / Resume</option>
                                <option value="Flash Sheet">Flash Sheet</option>
                            </select>
                            <label for="file-type">File Type</label>
                        </div>

                        <!-- Dotted Upload Box -->
                        <div class="upload-box-dotted" id="upload-box">
                            <div class="upload-box-content">
                                <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z"
                                        stroke="#0B3D27" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M14 2V8H20" stroke="#0B3D27" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 18V12" stroke="#0B3D27" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M9 15L12 12L15 15" stroke="#0B3D27" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span>Upload File</span>
                            </div>
                        </div>
                        <input type="file" id="file-input" multiple hidden>

                        <!-- Info Text -->
                        <p class="upload-info-text">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 15C11.866 15 15 11.866 15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15Z"
                                    stroke="#5D7A70" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 10.5V8" stroke="#5D7A70" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 5.5H8.0075" stroke="#5D7A70" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>You can upload PDF, JPG, PNG, or ZIP files up to 50MB each.</span>
                        </p>

                        <!-- Image Preview Gallery -->
                        <div class="image-preview-gallery" id="image-preview-gallery">
                            <!-- Image previews will be added here by JS -->
                        </div>

                        <!-- Uploaded Files List -->
                        <div class="uploaded-files-list" id="uploaded-files-list">
                            <!-- Uploaded file rows will be added here by JS -->
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="nav-btn back-btn">Back</button>
                        <button class="nav-btn next-btn">Next</button>
                    </div>
                </div>

                <!-- Template for an uploaded file row -->
                <template id="uploaded-file-template">
                    <div class="uploaded-file-row" data-id="">
                        {{--                        <div class="file-icon-container"> --}}
                        {{--                            <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="8" fill="#E6F4F0"/><path d="M28 13H15C14.4696 13 13.9609 13.2107 13.5858 13.5858C13.2107 13.9609 13 14.4696 13 15V26C13 26.5304 13.2107 27.0391 13.5858 27.4142C13.9609 27.7893 14.4696 28 15 28H28C28.5304 28 29.0391 27.7893 29.4142 27.4142C29.7893 27.0391 30 26.5304 30 26V15C30 14.4696 29.7893 13.9609 29.4142 13.5858C29.0391 13.2107 28.5304 13 28 13Z" stroke="#0B3D27" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 18C16.5 19 19 16.5 20.5 15" stroke="#0B3D27" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 15V13.5C11 12.6716 11.6716 12 12.5 12H25.5C26.3284 12 27 12.6716 27 13.5V15" stroke="#0B3D27" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> --}}
                        {{--                        </div> --}}
                        <div class="file-icon-container">
                            <img src="{{ asset('assets/web/document.png') }}" width="60" height="80" alt="File Preview" />
                        </div>
                        <div class="file-info">
                            <div class="file-name"></div>
                            <div class="file-time"></div>
                        </div>
                        <div class="file-size-pill"></div>
                        <button class="file-remove-btn" aria-label="Remove file">&times;</button>
                    </div>
                </template>

                <!-- Step 3: Message & Artist Details -->
                <div class="form-step" data-step="2">
                    <h2>Book your Spot</h2>
                    <p class="subtitle">Please proceed to book your guest spot as an artist.</p>
                    <div class="progress-indicator">
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                    </div>
                    <div class="form-content-scrollable">
                        <div class="form-group"><label>Leave a Message for the Studio (Optional)</label>
                            <textarea placeholder="Write Something Here..."></textarea>
                        </div>
                        <div class="artist-details-group">
                            <div class="form-group"><label>Are You Booking Solo or With a Group?</label><select>
                                    <option>Group</option>
                                    <option>Solo</option>
                                </select></div>
                            <div class="form-group" style="margin-top:15px;"><label>Name of the Artist</label><input
                                    type="text" value="Jessica L."></div>
                            <a href="#" class="add-more-link">Add More</a>
                        </div>
                    </div>
                    <div class="button-group"><button class="nav-btn back-btn">Back</button><button
                            class="nav-btn next-btn">Next</button></div>
                </div>

                <!-- Step 4: Agreement -->
                <div class="form-step" data-step="3">
                    <h2>Book your spot</h2>
                    <p class="subtitle">Please proceed to book your guest spot as an artist.</p>
                    <div class="progress-indicator">
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                        <div class="progress-step"></div>
                    </div>
                    <div class="form-content-scrollable">
                        <div class="form-section-title">Guest Artist Terms & Conditions</div>
                        <div class="agreement-box">

                            <p>Before submitting your booking request, please take a moment to carefully review and agree to
                                our Guest Artist Terms & Conditions. These terms have been created to ensure a smooth,
                                professional, and respectful experience for both you and the studio.</p>
                            <br>
                            <p>As a guest artist, you are expected to adhere to all studio policies, which include but are
                                not limited to:</p><br>
                            <ul>
                                <li><strong>Health & Hygiene Standards:</strong> Maintaining a clean and sanitary workspace
                                    at all times, properly sterilizing equipment, and following all local health
                                    regulations.</li>
                                <li><strong>Professional Conduct:</strong> Treating staff, clients, and fellow artists with
                                    respect and professionalism. Any form of discrimination, harassment, or unprofessional
                                    behavior will not be tolerated.</li>
                                <li><strong>Client Management:</strong> Being responsible for your own clients, including
                                    their communication, comfort, and consent throughout the session.</li>
                                <li><strong>Studio Property & Etiquette:</strong> Respecting the space, equipment, and any
                                    provided resources. Any damage caused will be your responsibility.</li>
                                <li><strong>Scheduling & Punctuality:</strong> Arriving on time for your scheduled days and
                                    informing the studio in advance if there are any changes or emergencies.</li>
                            </ul>
                            <br>
                            <p>By agreeing to these terms, you acknowledge your role in maintaining the studio's reputation
                                and creating a safe, welcoming environment for everyone. Failure to comply may result in
                                your booking being canceled.</p>
                        </div>
                    </div>
                    <div class="button-group"><button class="nav-btn back-btn">Back</button><button
                            class="nav-btn agree-btn" id="agree-btn">Agree and Continue</button></div>
                </div>

                <!-- Step 5: Submitted Confirmation -->
                <div class="form-step" style="margin-bottom: -50px" data-step="4">
                    <div class="final-modal-content">
                        <img class="success-icon" src="{{ asset('assets/web/thumbs_up.png') }}" alt="Thumbs Up">
                        <h2 style="font-weight: 500; max-width: 345px;">Booking Request Submitted!</h2>
                        <p>Thank you! Your booking request has been successfully submitted and is now pending studio
                            approval. You’ll receive a notification once the studio reviews and responds to your request.'
                        </p>
                        <div class="button-group"><button class="nav-btn next-btn"
                                id="submitted-continue-btn">Continue</button></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap">
    </script>
    <script>
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

            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 40.7128,
                    lng: -74.0060
                },
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

            const bounds = new google.maps.LatLngBounds();

            studios.forEach(studio => {
                const position = new google.maps.LatLng(studio.lat, studio.lng);
                new CustomMarker(position, map, studio);
                bounds.extend(position);
            });

            google.maps.event.addListenerOnce(map, 'idle', function() {
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
                panelWrapper.addEventListener('click', function(event) {
                    if (event.target && event.target.id === 'close-btn') {
                        panelWrapper.classList.remove('active');
                    }
                });
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
                                    <img src="{{ asset('assets/web/extra/location_logo.png') }}" alt="Location">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- MODAL & STEP NAVIGATION ELEMENTS ---
            const openModalBtn = document.getElementById('open-booking-modal-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const modalOverlay = document.getElementById('booking-modal-overlay');
            const nextBtns = document.querySelectorAll('.next-btn, .agree-btn');
            const backBtns = document.querySelectorAll('.back-btn');
            const steps = document.querySelectorAll('.form-step');
            let currentStep = 0;

            // --- STEP 1: CALENDAR ELEMENTS ---
            const monthYearDisplay = document.getElementById('calendar-month-year');
            const calendarGridBody = document.getElementById('calendar-grid-body');
            const prevMonthBtn = document.getElementById('prev-month-btn');
            const nextMonthBtn = document.getElementById('next-month-btn');
            const fromDateDisplay = document.getElementById('from-date-display');
            const toDateDisplay = document.getElementById('to-date-display');

            // --- STEP 2: UPLOAD ELEMENTS ---
            const uploadBox = document.getElementById('upload-box');
            const fileInput = document.getElementById('file-input');
            const imagePreviewGallery = document.getElementById('image-preview-gallery');
            const uploadedFilesList = document.getElementById('uploaded-files-list');
            const fileTemplate = document.getElementById('uploaded-file-template');

            // --- CALENDAR STATE ---
            let currentDate = new Date(2025, 8, 1); // September 2025
            let startDate = new Date(2025, 8, 14);
            let endDate = new Date(2025, 8, 30);
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];
            const uploadedFiles = new Map();

            // Modal and Step Navigation (No changes needed here)
            const openModal = () => {
                document.body.classList.add('modal-is-open');
                modalOverlay.classList.add('active');
            }
            const closeModal = () => {
                document.body.classList.remove('modal-is-open');
                modalOverlay.classList.remove('active');
                setTimeout(() => goToStep(0), 300);
            };
            if (openModalBtn) openModalBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            if (modalOverlay) modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            function goToStep(stepIndex) {
                if (stepIndex >= steps.length || stepIndex < 0) return;
                steps[currentStep].classList.remove('active');
                steps[stepIndex].classList.add('active');
                currentStep = stepIndex;
                updateProgressBar();
                const backBtn = steps[stepIndex].querySelector('.back-btn');
                if (backBtn) backBtn.disabled = (stepIndex === 0);
            }
            const updateProgressBar = () => {
                const indicators = document.querySelectorAll('.progress-indicator');
                indicators.forEach(indicator => {
                    if (indicator) {
                        const progressSteps = indicator.querySelectorAll('.progress-step');
                        progressSteps.forEach((progress, progressIdx) => {
                            progress.classList.toggle('active', progressIdx < currentStep);
                        });
                        if (progressSteps[currentStep]) {
                            progressSteps[currentStep].classList.add('active');
                        }
                    }
                });
            };
            nextBtns.forEach(btn => btn.addEventListener('click', () => {
                if (btn.id === 'agree-btn') goToStep(4);
                else if (currentStep < steps.length - 1) goToStep(currentStep + 1);
            }));
            backBtns.forEach(btn => btn.addEventListener('click', () => {
                if (currentStep > 0) goToStep(currentStep - 1);
            }));
            document.getElementById('submitted-continue-btn')?.addEventListener('click', closeModal);

            // =========================================================
            // === START OF UPDATED JAVASCRIPT FOR CALENDAR RENDERER ===
            // =========================================================
            const formatDate = (d) => d ? d.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : "";
            const toISO = (d) =>
                `${d.getFullYear()}-${(d.getMonth() + 1).toString().padStart(2, '0')}-${d.getDate().toString().padStart(2, '0')}`;

            const renderCalendar = () => {
                const year = currentDate.getFullYear(),
                    month = currentDate.getMonth();
                monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
                calendarGridBody.innerHTML = '';

                ['M', 'T', 'W', 'T', 'F', 'S', 'S'].forEach(d => calendarGridBody.innerHTML +=
                    `<div class="day-cell day-name">${d}</div>`);

                const firstDayOfMonth = new Date(year, month, 1);
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const startDayIndex = (firstDayOfMonth.getDay() + 6) % 7; // Monday = 0

                for (let i = 0; i < startDayIndex; i++) {
                    calendarGridBody.innerHTML += `<div class="day-cell other-month"></div>`;
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const cell = document.createElement('div');
                    const cellDate = new Date(year, month, day);
                    const dayOfWeek = (cellDate.getDay() + 6) % 7; // Monday = 0, Sunday = 6

                    cell.className = 'day-cell';
                    cell.textContent = day.toString().padStart(2, '0');
                    cell.dataset.date = toISO(cellDate);
                    cell.dataset.day = day.toString().padStart(2, '0'); // For CSS content: attr(data-day)

                    if (startDate && endDate && cellDate > startDate && cellDate < endDate) {
                        cell.classList.add('in-range');
                        if (dayOfWeek === 0) cell.classList.add('pill-left');
                        if (dayOfWeek === 6) cell.classList.add('pill-right');
                    }

                    if (startDate && toISO(cellDate) === toISO(startDate)) {
                        cell.classList.add('start-date', 'pill-left');
                        if (endDate && toISO(startDate) === toISO(endDate)) {
                            cell.classList.add('pill-right');
                        }
                    }

                    if (endDate && toISO(cellDate) === toISO(endDate)) {
                        cell.classList.add('end-date', 'pill-right');
                    }

                    cell.addEventListener('click', handleDateClick);
                    calendarGridBody.appendChild(cell);
                }
                updateDateInputs();
            };
            // =======================================================
            // === END OF UPDATED JAVASCRIPT FOR CALENDAR RENDERER ===
            // =======================================================

            const updateDateInputs = () => {
                fromDateDisplay.textContent = formatDate(startDate);
                toDateDisplay.textContent = formatDate(endDate);
            };
            const handleDateClick = (e) => {
                const clickedDate = new Date(e.target.dataset.date + 'T00:00:00');
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

            // File Upload Logic (No changes needed)
            if (uploadBox && fileInput && imagePreviewGallery && uploadedFilesList && fileTemplate) {
                uploadBox.addEventListener('click', () => fileInput.click());
                fileInput.addEventListener('change', (event) => {
                    const files = event.target.files;
                    for (const file of files) {
                        const fileKey = `${file.name}-${file.size}`;
                        if (!uploadedFiles.has(fileKey)) {
                            const fileData = {
                                file: file,
                                timestamp: new Date()
                            };
                            uploadedFiles.set(fileKey, fileData);
                            renderFile(fileKey, fileData);
                        }
                    }
                    fileInput.value = '';
                });
            }

            function renderFile(key, data) {
                const {
                    file,
                    timestamp
                } = data;
                const templateClone = fileTemplate.content.cloneNode(true);
                const fileRow = templateClone.querySelector('.uploaded-file-row');
                fileRow.dataset.key = key;
                fileRow.querySelector('.file-name').textContent = file.name;
                const timeEl = fileRow.querySelector('.file-time');
                timeEl.textContent = timeAgo(timestamp);
                timeEl.dataset.timestamp = timestamp;
                fileRow.querySelector('.file-size-pill').textContent = formatBytes(file.size);
                fileRow.querySelector('.file-remove-btn').addEventListener('click', () => removeFile(key));
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.dataset.key = key;
                    imagePreviewGallery.appendChild(img);
                }
                uploadedFilesList.appendChild(fileRow);
            }

            function removeFile(key) {
                const fileRow = uploadedFilesList.querySelector(`.uploaded-file-row[data-key="${key}"]`);
                if (fileRow) fileRow.remove();
                const imgPreview = imagePreviewGallery.querySelector(`img[data-key="${key}"]`);
                if (imgPreview) imgPreview.remove();
                uploadedFiles.delete(key);
            }

            function formatBytes(bytes, d = 2) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024,
                    i = Math.floor(Math.log(bytes) / Math.log(k));
                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(d))} ${['Bytes', 'KB', 'MB', 'GB'][i]}`;
            }

            function timeAgo(date) {
                const s = Math.floor((new Date() - date) / 1000);
                if (s >= 31536000) return Math.floor(s / 31536000) + "y ago";
                if (s >= 2592000) return Math.floor(s / 2592000) + "mo ago";
                if (s >= 86400) return Math.floor(s / 86400) + "d ago";
                if (s >= 3600) return Math.floor(s / 3600) + "h ago";
                if (s >= 60) return Math.floor(s / 60) + "m ago";
                if (s > 0) return s + "s ago";
                return "just now";
            }

            function updateAllFileTimes() {
                document.querySelectorAll('.file-time').forEach(el => {
                    const ts = el.dataset.timestamp;
                    if (ts) el.textContent = timeAgo(new Date(ts));
                });
            }
            setInterval(updateAllFileTimes, 10000);
            goToStep(0);
        });
    </script>
@endsection
