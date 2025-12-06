{{-- 
    Sidebar auto-generated: vérifier que les noms de routes existent dans routes/web.php
    Chaque lien inclut la détection d'état actif et vérification des permissions Spatie
    Classes CSS Saul: 'here show menu-accordion' (parent ouvert), 'active' (lien courant)
--}}
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Main-->
    <div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column"
        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
            class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">

            <!-- Dashboard -->
            <div class="menu-item">
                <a href="{{ route('dashboard') }}"
                    class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-home fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <!-- Gestion Académique -->
            @php
                $academicOpen = request()->routeIs('academic-years.*', 'departments.*', 'establishments.*');
            @endphp
            @can('view_academic_years')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $academicOpen ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-calendar-8 fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Gestion Académique</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!-- Années Académiques -->
                        @can('view_academic_years')
                            <div class="menu-item">
                                <a href="{{ route('academic-years.index') }}"
                                    class="menu-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Années Académiques</span>
                                </a>
                            </div>
                        @endcan

                        <!-- Établissements -->
                        @can('view_establishments')
                            <div class="menu-item">
                                <a href="{{ route('establishments.index') }}"
                                    class="menu-link {{ request()->routeIs('establishments.*') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Établissements</span>
                                </a>
                            </div>
                        @endcan

                        <!-- Départements -->
                        @can('view_departments')
                            <div class="menu-item">
                                <a href="{{ route('departments.index') }}"
                                    class="menu-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Départements</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            @endcan

            <!-- Gestion Pédagogique -->
            @php
                $pedagogicOpen = request()->routeIs('classes.*', 'subjects.*', 'programs.*', 'programs.manage');
            @endphp
            @can('view_classes')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $pedagogicOpen ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-book fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Gestion Pédagogique</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!-- Classes -->
                        @can('view_classes')
                            <div class="menu-item">
                                <a href="{{ route('classes.index') }}"
                                    class="menu-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Classes</span>
                                </a>
                            </div>
                        @endcan

                        <!-- Matières -->
                        @can('view_subjects')
                            <div class="menu-item">
                                <a href="{{ route('subjects.index') }}"
                                    class="menu-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Matières</span>
                                </a>
                            </div>
                        @endcan

                        <!-- Programmes -->
                        @can('view_programs')
                            <div class="menu-item">
                                <a href="{{ route('programs.index') }}"
                                    class="menu-link {{ request()->routeIs('programs.index', 'programs.create', 'programs.edit') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Programmes</span>
                                </a>
                            </div>
                        @endcan

                        <!-- Gestionnaire de Programmes -->
                        @can('manage_programs')
                            <div class="menu-item">
                                <a href="{{ route('programs.manage') }}"
                                    class="menu-link {{ request()->routeIs('programs.manage') ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Gestionnaire de Programmes</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            @endcan

            <!-- Couverture Hebdomadaire -->
            @can('view_weekly_coverage')
                <div class="menu-item">
                    <a href="{{ route('weekly-coverage.create') }}"
                        class="menu-link {{ request()->routeIs('weekly-coverage.*', 'coverage.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-calendar-tick fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Couverture Hebdomadaire</span>
                    </a>
                </div>
            @endcan

            <!-- Rapports -->
            @php
                $reportsOpen = request()->routeIs('reports.*');
            @endphp
            @can('view_reports')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $reportsOpen ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-chart-line-down fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Rapports</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!-- Rapport de Couverture -->
                        <div class="menu-item">
                            <a href="{{ route('reports.coverage') }}"
                                class="menu-link {{ request()->routeIs('reports.coverage') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Couverture Pédagogique</span>
                            </a>
                        </div>

                        <!-- Programmes et Rapports -->
                        <div class="menu-item">
                            <a href="{{ route('programs.reports') }}"
                                class="menu-link {{ request()->routeIs('programs.reports') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Programmes et Rapports</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Utilisateurs (Admin only) -->
            @can('view_users')
                <div class="menu-item">
                    <a href="{{ route('users.index') }}"
                        class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-people fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Utilisateurs</span>
                    </a>
                </div>
            @endcan

            <!-- Administration (Permissions & Rôles) -->
            @can('manage_permissions')
                <div class="menu-item">
                    <a href="{{ route('admin.role-permissions') }}"
                        class="menu-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-shield-tick fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Gestion des Rôles</span>
                    </a>
                </div>
            @endcan

        </div>
        <!--end::Sidebar menu-->

        <!--begin::Footer-->
        <div class="app-sidebar-project-default app-sidebar-project-minimize text-center min-h-lg-400px flex-column-auto d-flex flex-column justify-content-end"
            id="kt_app_sidebar_footer">
            <!--begin::Title-->
            <h2 class="fw-bold text-gray-800">{{ config('app.name', 'Dolostat') }}</h2>
            <!--end::Title-->
            <!--begin::Description-->
            <div class="fw-semibold text-gray-700 fs-7 lh-2 px-7 mb-1">Système de gestion scolaire</div>
            <!--end::Description-->
            <!--begin::Illustration-->
            <img class="mx-auto h-150px h-lg-175px mb-4" src="{{ asset('dist/assets/media/misc/saul-welcome.png') }}"
                alt="" />
            <!--end::Illustration-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Main-->
</div>
