<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ __('Se connecter') }} - Dolostat</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <!-- Saul Theme Assets -->
    <link href="{{ asset('dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!-- Livewire Styles -->
    @livewireStyles

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
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @livewire('auth.login')
    </div>

    <!-- Scripts -->
    <script var="hostUrl" src="{{ asset('dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/scripts.bundle.js') }}"></script>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
