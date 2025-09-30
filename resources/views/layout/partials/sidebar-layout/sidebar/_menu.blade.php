<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="menu-icon">{!! getIcon('home', 'fs-2') !!}</span>
                    <span class="menu-title"> Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item pt-5">
                <!--begin:Menu content-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Apps</span>
                </div>
                <!--end:Menu content-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('people', 'fs-2') !!}</span>
                    <span class="menu-title">User Management</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.administrators.*') ? 'active' : '' }}"
                            href="{{ route('user-management.administrators.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Administrators</span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.artists.*') ? 'active' : '' }}"
                            href="{{ route('user-management.artists.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Guest Artist</span>
                        </a>
                        <!--end:Menu link-->

                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.studios.*') ? 'active' : '' }}"
                            href="{{ route('user-management.studios.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Studios</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    {{-- <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}"
                            href="{{ route('user-management.roles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                        <!--end:Menu link-->
                    </div> --}}
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    {{-- <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}"
                            href="{{ route('user-management.permissions.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Permissions</span>
                        </a>
                        <!--end:Menu link-->
                    </div> --}}
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('plan-management.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('category', 'fs-2') !!}</span>
                    <span class="menu-title">Plan Management</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('plan-management.plans.*') ? 'active' : '' }}"
                            href="{{ route('plan-management.plans.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Plan</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('plan-management.features.*') ? 'active' : '' }}"
                            href="{{ route('plan-management.features.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Features</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                </div>
                <!--end:Menu sub-->
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('creative-management.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('brush', 'fs-2') !!}</span>
                    <span class="menu-title">Creative Management</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('creative-management.plans.*') ? 'active' : '' }}"
                            href="{{ route('creative-management.supplies.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Supplies</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('creative-management.station-amenities.*') ? 'active' : '' }}"
                            href="{{ route('creative-management.station-amenities.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Station Amenities</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('creative-management.tattoo-styles.*') ? 'active' : '' }}"
                            href="{{ route('creative-management.tattoo-styles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Tattoo Styles</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('creative-management.design-specialities.*') ? 'active' : '' }}"
                            href="{{ route('creative-management.design-specialities.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Design Speciality</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('payments.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('wallet', 'fs-2') !!}</span>
                    <span class="menu-title">Payments</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('payments.deposits.*') ? 'active' : '' }}"
                            href="{{ route('payments.deposits.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Deposits</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
