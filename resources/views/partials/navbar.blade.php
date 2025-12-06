<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
    <!--begin::Header main-->
    <div class="d-flex align-items-center flex-stack flex-grow-1">
        <div class="app-header-logo d-flex align-items-center flex-stack px-lg-11 mb-2" id="kt_app_header_logo">
            <!--begin::Sidebar mobile toggle-->
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
                id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Sidebar mobile toggle-->
            <!--begin::Logo-->
            <a href="{{ route('dashboard') }}" class="app-sidebar-logo">
                <img alt="Logo" src="{{ asset('dist/assets/media/logos/default.svg') }}"
                    class="h-30px theme-light-show" />
                <img alt="Logo" src="{{ asset('dist/assets/media/logos/default-dark.svg') }}"
                    class="h-30px theme-dark-show" />
            </a>
            <!--end::Logo-->
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-sm btn-icon btn-color-warning me-n2 d-none d-lg-flex"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-duotone ki-exit-left fs-2x rotate-180">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <!--begin::Navbar-->
        <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-center flex-lg-grow-1 me-2 me-lg-0 px-lg-8">
                <livewire:admin-switcher />
            </div>
            <!--begin::User menu-->
            <div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-30px symbol-lg-40px"
                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end">
                    <img src="{{ asset('dist/assets/media/avatars/300-2.jpg') }}" alt="user" />
                </div>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Username and Role-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">
                                    {{ auth()->user()->name ?? 'Utilisateur' }}
                                </div>
                                @if (auth()->user())
                                    <small class="fw-semibold text-muted fs-7">
                                        {{ auth()->user()->getRoleNames()->first() ?? 'Utilisateur' }}
                                    </small>
                                @endif
                            </div>
                            <!--end::Username and Role-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item - Logout-->
                    <div class="menu-item px-5">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="menu-link px-5 text-danger"
                                style="border: none; background: none; cursor: pointer; width: 100%; text-align: left;">
                                <i class="ki-duotone ki-log-out fs-5 me-2"></i>
                                <span>Se Déconnecter</span>
                            </button>
                        </form>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User menu-->
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header main-->
    <!--begin::Separator-->
    <div class="app-header-separator"></div>
    <!--end::Separator-->
</div>
