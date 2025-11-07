<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar_wrapper">
        <div class="sidebar-logo" style="text-align: center;">
            <a href="{{ url('dashboard/explore') }}">
                <img src="{{ asset('assets/web/extra/guestlyLogo-02.png') }}" alt="Guestly Logo" style="width: 60%; height: auto; cursor: pointer; margin-left: -15px">
            </a>
        </div>
        @if(auth()->user()->role_id === 'artist')

        <nav class="sidebar-nav">
            <a href="{{ url('dashboard/explore') }}"
               class="nav-link {{ Request::is('dashboard/explore') || Request::is('dashboard/studio_detail') ? 'active' : '' }}">
                <img src="{{ asset(Request::is('dashboard/explore') || Request::is('dashboard/studio_detail') ? 'assets/web/extra/explore.svg' : 'assets/web/extra/explore_inactive.svg') }}"
                     style="width: 20px; height: 20px;">
                <span>{{__('explore_heading')}}</span>
            </a>

            <a href="{{ url('dashboard/artist_chat') }}"
               class="nav-link {{ Request::is('dashboard/artist_chat') ? 'active' : '' }}">
                <img src="{{ asset(Request::is('dashboard/artist_chat') ? 'assets/web/extra/message.svg' : 'assets/web/extra/message_inactive.svg') }}"
                     style="width: 20px; height: 20px;">
                <span>{{__('messages_heading')}}</span>
            </a>

            <a href="{{ url ('dashboard/artist_booking') }}"
               class="nav-link {{ Request::is('dashboard/artist_booking') || Request::is('dashboard/artist_guest_spot') ? 'active' : '' }}">
                <img src="{{ asset(Request::is('dashboard/artist_booking') || Request::is('dashboard/artist_guest_spot') ? 'assets/web/extra/calendar.svg' : 'assets/web/extra/calendar_inactive.svg') }}"
                     style="width: 20px; height: 20px;">
                {{--            <span>Bookings</span>--}}
                <span>{{__('studios_heading')}}</span>
            </a>

            <a href="{{ url ('dashboard/artist_request') }}"
               class="nav-link {{ Request::is('dashboard/artist_request') ? 'active' : '' }}">
                <img src="{{ asset(Request::is('dashboard/artist_request') ? 'assets/web/extra/request.svg' : 'assets/web/extra/request_inactive.svg') }}"
                     style="width: 20px; height: 20px;">
                {{--            <span>Requests</span>--}}
                <span>{{__('clients_heading')}}</span>
            </a>

            <a href="{{ url ('dashboard/artist_tattoo') }}"
               class="nav-link {{ Request::is('dashboard/artist_tattoo') ? 'active' : '' }}">
                <img src="{{ asset(Request::is('dashboard/artist_tattoo') ? 'assets/web/extra/flash_tattoos.svg' : 'assets/web/extra/flash_tattoos_inactive.svg') }}"
                     style="width: 20px; height: 20px;">
                <span>{{__('flash_tattoos_heading')}}</span>
            </a>

            <div class="nav-item dropdown-container open">

                <!-- Yeh link dropdown ko kholega/band karega -->
                <a href="#"
                   id="profileDropdownToggle"
                   class="nav-link dropdown-toggle {{ Request::is('dashboard/artist_profile*') || Request::is('dashboard/artist_security*') || Request::is('dashboard/artist_bio*') || Request::is('dashboard/artist_subscription*') || Request::is('dashboard/artist_rating*') || Request::is('dashboard/artist_payment*')  ? 'active' : '' }}">

                    <img src="{{ asset(Request::is('dashboard/artist_profile*') || Request::is('dashboard/artist_security*') || Request::is('dashboard/artist_bio*') || Request::is('dashboard/artist_subscription*') || Request::is('dashboard/artist_rating*') || Request::is('dashboard/artist_payment*') ? 'assets/web/extra/profile.svg' : 'assets/web/extra/profile_inactive.svg') }}"
                         style="width: 20px; height: 20px;">
                    <span style="margin-right: auto">{{__('profile_personal_heading')}}</span>

                    <!-- Dropdown ka arrow icon -->
                    <svg class="dropdown-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>

                <!-- Dropdown Menu -->
                <div  class="dropdown-menu-inline {{ Request::is('dashboard/artist_profile*') || Request::is('dashboard/artist_security*') || Request::is('dashboard/artist_bio*') || Request::is('dashboard/artist_subscription*') || Request::is('dashboard/artist_rating*') || Request::is('dashboard/artist_payment*') ? 'show' : '' }}">
                    <a href="{{ asset ('dashboard/artist_profile') }}"
                       class="nav-link {{ Request::is('dashboard/artist_profile') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_profile') ? 'assets/web/extra/user_profile.svg' : 'assets/web/extra/user_profile_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('personal_information_heading')}}</span>
                    </a>
                    <a href="{{ asset ('dashboard/artist_security') }}"
                       class="nav-link {{ Request::is('dashboard/artist_security') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_security') ? 'assets/web/extra/user_security.svg' : 'assets/web/extra/user_security_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('login_security_heading')}}</span>
                    </a>
                    <a href="{{ asset ('dashboard/artist_bio') }}"
                       class="nav-link {{ Request::is('dashboard/artist_bio') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_bio') ? 'assets/web/extra/user_bio.svg' : 'assets/web/extra/user_bio_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('bio_tattoo_styles_heading')}}</span>
                    </a>
                    <a href="{{ asset ('dashboard/artist_subscription') }}"
                       class="nav-link {{ Request::is('dashboard/artist_subscription') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_subscription') ? 'assets/web/extra/user_subscription.svg' : 'assets/web/extra/user_subscription_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('subscription_management_heading')}}</span>
                    </a>
                    <a href="{{ asset ('dashboard/artist_rating') }}"
                       class="nav-link {{ Request::is('dashboard/artist_rating') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_rating') ? 'assets/web/extra/user_rating.svg' : 'assets/web/extra/user_rating_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('view_ratings_heading')}}</span>
                    </a>
                    <a href="{{ asset ('dashboard/artist_payment') }}"
                       class="nav-link {{ Request::is('dashboard/artist_payment') ? 'active' : '' }}">
                        <img src="{{ asset(Request::is('dashboard/artist_payment') ? 'assets/web/extra/user_payment.svg' : 'assets/web/extra/user_payment_inactive.svg') }}"
                             style="width: 25px; height: 25px;">
                        <span>{{__('payments_methods_heading')}}</span>
                    </a>
                </div>

            </div>
        </nav>

        @elseif(auth()->user()->role_id === 'studio')

            <nav class="sidebar-nav">
                <a href="{{ url('dashboard/studio_home') }}"
                   class="nav-link {{ Request::is('dashboard/studio_home') || Request::is('dashboard/studio_detail') ? 'active' : '' }}">
                    <img src="{{ asset(Request::is('dashboard/studio_home') || Request::is('dashboard/studio_detail') ? 'assets/web/extra/studio_dashboard.svg' : 'assets/web/extra/studio_dashboard_inactive.svg') }}"
                         style="width: 20px; height: 20px;">
                    <span>{{__('studio_dashboard_heading')}}</span>
                </a>

                <a href="{{ url('dashboard/studio_chat') }}"
                   class="nav-link {{ Request::is('dashboard/studio_chat') ? 'active' : '' }}">
                    <img src="{{ asset(Request::is('dashboard/studio_chat') ? 'assets/web/extra/message.svg' : 'assets/web/extra/message_inactive.svg') }}"
                         style="width: 20px; height: 20px;">
                    <span>{{__('messages_heading')}}</span>
                </a>

                <a href="{{ url ('dashboard/studio_search_artist') }}"
                   class="nav-link {{ Request::is('dashboard/studio_search_artist') || Request::is('dashboard/artist_guest_spot') ? 'active' : '' }}">
                    <img src="{{ asset(Request::is('dashboard/studio_search_artist') || Request::is('dashboard/artist_guest_spot') ? 'assets/web/extra/studio_search.svg' : 'assets/web/extra/studio_search_inactive.svg') }}"
                         style="width: 20px; height: 20px;">
                    <span>{{__('studio_search_artist_heading')}}</span>
                </a>

                <a href="{{ url ('dashboard/studio_request') }}"
                   class="nav-link {{ Request::is('dashboard/studio_request') ? 'active' : '' }}">
                    <img src="{{ asset(Request::is('dashboard/studio_request') ? 'assets/web/extra/request.svg' : 'assets/web/extra/request_inactive.svg') }}"
                         style="width: 20px; height: 20px;">
                                <span>{{__('studio_artist_request_heading')}}</span>
{{--                    <span>Clients</span>--}}
                </a>

{{--                <a href="{{ url ('dashboard/artist_tattoo') }}"--}}
{{--                   class="nav-link {{ Request::is('dashboard/artist_tattoo') ? 'active' : '' }}">--}}
{{--                    <img src="{{ asset(Request::is('dashboard/artist_tattoo') ? 'assets/web/extra/flash_tattoos.svg' : 'assets/web/extra/flash_tattoos_inactive.svg') }}"--}}
{{--                         style="width: 20px; height: 20px;">--}}
{{--                    <span>Flash Tattoos</span>--}}
{{--                </a>--}}

                <div class="nav-item dropdown-container open">

                    <!-- Yeh link dropdown ko kholega/band karega -->
                    <a href="#"
                       id="profileDropdownToggle"
                       class="nav-link dropdown-toggle {{ Request::is('dashboard/studio_profile*') || Request::is('dashboard/studio_security*') || Request::is('dashboard/studio_rating*') || Request::is('dashboard/studio_availability*') || Request::is('dashboard/studio_subscription*') || Request::is('dashboard/studio_payment*')  ? 'active' : '' }}">

                        <img src="{{ asset(Request::is('dashboard/studio_profile*') || Request::is('dashboard/studio_security*') || Request::is('dashboard/studio_subscription*') || Request::is('dashboard/studio_rating*') || Request::is('dashboard/studio_payment*') ? 'assets/web/extra/studio_profile.svg' : 'assets/web/extra/studio_profile_inactive.svg') }}"
                             style="width: 20px; height: 20px;">
                        <span style="margin-right: auto">{{__('profile_personal_heading')}}</span>

                        <!-- Dropdown ka arrow icon -->
                        <svg class="dropdown-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>

                    <!-- Dropdown Menu -->
                    <div  class="dropdown-menu-inline {{ Request::is('dashboard/studio_profile*') || Request::is('dashboard/studio_security*') || Request::is('dashboard/studio_subscription*') || Request::is('dashboard/studio_availability*') || Request::is('dashboard/studio_rating*') || Request::is('dashboard/studio_payment*') ? 'show' : '' }}">
                        <a href="{{ asset ('dashboard/studio_profile') }}"
                           class="nav-link {{ Request::is('dashboard/studio_profile') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_profile') ? 'assets/web/extra/user_profile.svg' : 'assets/web/extra/user_profile_inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('studio_profile_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_security') }}"
                           class="nav-link {{ Request::is('dashboard/studio_security') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_security') ? 'assets/web/extra/user_security.svg' : 'assets/web/extra/user_security_inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('login_security_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_availability') }}"
                           class="nav-link {{ Request::is('dashboard/studio_availability') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_availability') ? 'assets/web/extra/studio-availability.svg' : 'assets/web/extra/studio-availability-inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('studio_availability_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_subscription') }}"
                           class="nav-link {{ Request::is('dashboard/studio_subscription') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_subscription') ? 'assets/web/extra/user_subscription.svg' : 'assets/web/extra/user_subscription_inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('subscription_management_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_promotion') }}"
                           class="nav-link {{ Request::is('dashboard/studio_promotion') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_promotion') ? 'assets/web/extra/studio-boast.svg' : 'assets/web/extra/studio-boast-inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('studio_ads_promotion_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_rating') }}"
                           class="nav-link {{ Request::is('dashboard/studio_rating') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_rating') ? 'assets/web/extra/user_rating.svg' : 'assets/web/extra/user_rating_inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('view_ratings_heading')}}</span>
                        </a>
                        <a href="{{ asset ('dashboard/studio_payment') }}"
                           class="nav-link {{ Request::is('dashboard/studio_payment') ? 'active' : '' }}">
                            <img src="{{ asset(Request::is('dashboard/studio_payment') ? 'assets/web/extra/user_payment.svg' : 'assets/web/extra/user_payment_inactive.svg') }}"
                                 style="width: 25px; height: 25px;">
                            <span>{{__('payments_methods_heading')}}</span>
                        </a>
                    </div>

                </div>
            </nav>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </button>
        </form>

    </div>
</aside>
