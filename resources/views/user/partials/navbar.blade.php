<div class="page-header">
    <div class="header-row">
        <h1 class="page-title">{{ $pageTitle ?? '' }}</h1>
        <div class="user-profile">
            <!-- Profile Dropdown Area (Pehle se maujood) -->
            <div class="profile-toggle-area" id="profileToggleArea">
                <img src="{{ asset('dashboard/user-profile.jpg') }}" alt="Chris Johnson avatar" class="user-avatar">
                <div class="user-info">
                    <p>{{ ucwords(Auth::user()->name) }} {{ ucwords(Auth::user()->last_name) }}</p>
                    <p>{{ ucwords(Auth::user()->role_id) }}</p>
                </div>
            </div>
            <div class="profile-dropdown-menu" id="profileDropdownMenu">
                <a class="profile-dropdown-item" href="{{ asset('dashboard/artist_profile') }}">Profile</a>

                <a href="#" class="profile-dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <!-- Notification Bell aur Dropdown -->
            <div class="notification-container">
                <div class="notification-bell-icon" id="notificationBellIcon">
                    <img src="{{ asset('extra/notification_logo.png') }}" alt="Notification Bell">
                    <!-- Aap yahan SVG icon bhi istemal kar sakte hain -->
                </div>

                <!-- Notification Dropdown Menu -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <h3>Notifications</h3>
                    </div>
                    <div class="notification-list">
                        <!-- Notification Item 1 -->
                        <div class="notification-item">
                            <div class="item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="item-content">
                                <p class="item-title"><strong>John Doe</strong></p>
                                <p class="item-message">It is a long established fact that a reader will be distracted</p>
                            </div>
                            <div class="item-meta">
                                <span class="unread-dot"></span>
                                <span class="item-time">00 min ago</span>
                            </div>
                        </div>
                        <!-- Notification Item 2 -->
                        <div class="notification-item">
                            <div class="item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="item-content">
                                <p class="item-title"><strong>John Doe</strong></p>
                                <p class="item-message">It is a long established fact that a reader will be distracted</p>
                            </div>
                            <div class="item-meta">
                                <span class="unread-dot"></span>
                                <span class="item-time">00 min ago</span>
                            </div>
                        </div>
                        <!-- Notification Item 3 (Same as above) -->
                    </div>
                    <div class="notification-footer">
                        <a href="{{ asset ('dashboard/notification') }}">View All</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
