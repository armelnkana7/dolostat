<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <base href="{{ url('/') }}" />
    <title>@yield('title', config('app.name', 'Dolostat'))</title>
    <meta charset="utf-8" />
    <meta name="description" content="@yield('meta_description', 'Dolostat - Gestion scolaire simplifiée')" />
    <meta name="keywords" content="@yield('meta_keywords', 'gestion scolaire, éducation, établissement, classes, programmes')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="{{ config('app.locale', 'fr_FR') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('og_title', config('app.name', 'Dolostat'))" />
    <meta property="og:description" content="@yield('og_description', config('app.name', 'Dolostat') . ' - Gestion scolaire')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'Dolostat') }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="robots" content="@yield('meta_robots', 'index,follow')" />
    <meta name="author" content="{{ config('app.name', 'Dolostat') }}" />
    <meta name="language" content="{{ app()->getLocale() }}" />
    <meta property="og:image" content="{{ asset('dist/assets/media/misc/saul-welcome.png') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name', 'Dolostat'))" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Gestion scolaire simplifiée')" />
    <meta name="twitter:image" content="{{ asset('dist/assets/media/misc/saul-welcome.png') }}" />
    <link rel="alternate" hreflang="{{ app()->getLocale() }}" href="{{ url()->current() }}" />
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />
    <link rel="shortcut icon" href="{{ asset('dist/assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    {{-- @vite('resources/css/app.css') --}}
    @livewireStyles

    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <!-- JSON-LD Organization structured data for SEO -->
    <script type="application/ld+json">
        {!! json_encode([
            "context" => "https://schema.org",
            "type" => "Organization",
            "url" => url('/'),
            "name" => config('app.name', 'Dolostat'),
            "logo" => asset('dist/assets/media/logos/default.svg'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
    data-kt-app-aside-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('partials.navbar')
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('partials.sidebar')
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                {{-- <div wire:loading>@include('components.loading-indicator')</div> --}}
                                {{ $slot }}
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    @include('partials.footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('dist/assets/') }}";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('dist/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/create-account.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Global Stylesheets Bundle-->
    @livewireScripts
    <!--end::Custom Javascript-->
    <!--end::Javascript-->

    <x-confirm-modal />
    <x-confirm-modal-script />
    @livewire('toast-container')
    @stack('scripts')

    <script>
        // Écoute l'événement dispatché depuis Livewire
        Livewire.on('open-pdf', detail => {
            // detail.url contient l'URL passée depuis PHP
            if (detail?.url) {
                window.open(detail.url, '_blank'); // ouvre dans un nouvel onglet
            }
        });
    </script>

</body>
<!--end::Body-->

</html>
