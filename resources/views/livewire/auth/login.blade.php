<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
            <!--begin::Header-->
            <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                <!--begin::Logo-->
                <a href="{{ route('dashboard') }}" class="py-2 py-lg-20">
                    <img alt="Logo" src="{{ asset('dist/assets/media/logos/mail.svg') }}" class="h-40px h-lg-50px" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">
                    {{ __('Bienvenue à Dolostat') }}
                </h1>
                <!--end::Title-->
                <!--begin::Description-->
                <p class="d-none d-lg-block fw-semibold fs-2 text-white">
                    {{ __('Système de gestion des couvertures pédagogiques') }}<br />
                    {{ __('Suivez l\'avancement de vos programmes en temps réel') }}
                </p>
                <!--end::Description-->
            </div>
            <!--end::Header-->
            <!--begin::Illustration-->
            <div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                style="background-image: url({{ asset('dist/assets/media/illustrations/sketchy-1/17.png') }})"></div>
            <!--end::Illustration-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Aside-->
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form wire:submit.prevent="login" class="form w-100">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">{{ __('Se connecter à Dolostat') }}</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">
                            {{ __('Pas encore de compte ?') }}
                            <a href="{{ route('register') }}" class="link-primary fw-bold">
                                {{ __('Créer un compte') }}
                            </a>
                        </div>
                        <!--end::Link-->
                    </div>
                    <!--end::Heading-->

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ __('Erreur !') }}</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!--begin::Input group - Email/Username-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label
                            class="form-label fs-6 fw-bold text-dark">{{ __('Email ou Nom d\'utilisateur') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text"
                            class="form-control form-control-lg form-control-solid @error('credential') is-invalid @enderror"
                            wire:model.defer="credential" placeholder="user@example.fr ou johndoe"
                            autocomplete="username" />
                        <!--end::Input-->
                        @error('credential')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group - Password-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bold text-dark fs-6 mb-0">{{ __('Mot de passe') }}</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bold">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input type="password"
                            class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                            wire:model.defer="password" placeholder="••••••••" autocomplete="current-password" />
                        <!--end::Input-->
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Checkbox - Remember me-->
                    <div class="fv-row mb-10">
                        <div class="form-check form-check-custom form-check-solid">
                            <input type="checkbox" class="form-check-input" id="kt_login_remember_me"
                                wire:model.defer="rememberMe" />
                            <label class="form-check-label fw-semibold text-gray-700 fs-6" for="kt_login_remember_me">
                                {{ __('Se souvenir de moi') }}
                            </label>
                        </div>
                    </div>
                    <!--end::Checkbox-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5" wire:loading.attr="disabled">
                            <span class="indicator-label">
                                {{ __('Continuer') }}
                            </span>
                            <span class="indicator-progress">
                                {{ __('Veuillez patienter...') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->
        <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
            <!--begin::Links-->
            <div class="d-flex flex-center fw-semibold fs-6">
                <a href="https://dolostat.local" class="text-muted text-hover-primary px-2" target="_blank">
                    {{ __('À propos') }}
                </a>
                <a href="https://dolostat.local/support" class="text-muted text-hover-primary px-2" target="_blank">
                    {{ __('Support') }}
                </a>
                <a href="https://dolostat.local/docs" class="text-muted text-hover-primary px-2" target="_blank">
                    {{ __('Documentation') }}
                </a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Body-->
</div>
<!--end::Authentication - Sign-in-->
