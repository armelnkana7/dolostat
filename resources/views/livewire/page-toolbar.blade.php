<div id="kt_app_toolbar" class="app-toolbar pt-5 pb-5" wire:id="45454545hhh4j54h5j45h45j4h5j5">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-containerh container-fluid d-flex align-items-stretch">
        <!--begin::Toolbar wrapper-->
        <div class="app-toolbar-wrapper1 d-flex flex-stack flex-wrap gap-4 w-100">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                <!--begin::Breadcrumb-->
                @if (count($breadcrumbs) > 0)
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                        {{-- Bouton accueil --}}
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="{{ route('dashboard') }}" class="text-gray-500">
                                <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                            </a>
                        </li>

                        {{-- Breadcrumbs dynamiques --}}
                        @foreach ($breadcrumbs as $breadcrumb)
                            {{-- Séparateur --}}
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>

                            {{-- Item --}}
                            <li
                                class="breadcrumb-item text-gray-700 @if ($breadcrumb['active'] ?? false) fw-bold @endif lh-1">
                                @if (isset($breadcrumb['href']) && !($breadcrumb['active'] ?? false))
                                    <a href="{{ $breadcrumb['href'] }}" class="text-gray-500">
                                        {{ $breadcrumb['label'] }}
                                    </a>
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
                <!--end::Breadcrumb-->

                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">
                    {{ $title }}
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->

            {{-- Bouton d'action optionnel --}}
            @if ($actionLabel && $actionRoute)
                <!--begin::Actions-->
                <a href="{{ $actionRoute }}" class="{{ $actionClass }} ms-3 px-4 py-3">
                    {{ $actionLabel }}
                </a>
                <!--end::Actions-->
            @endif
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->
