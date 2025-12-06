<!--begin::Authentication - Sign-up -->
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
                    {{ __('Rejoignez Dolostat') }}
                </h1>
                <!--end::Title-->
                <!--begin::Description-->
                <p class="d-none d-lg-block fw-semibold fs-2 text-white">
                    {{ __('Gérez votre couverture pédagogique efficacement') }}<br />
                    {{ __('Suivez vos programmes en temps réel') }}
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
                <form wire:submit.prevent="register" class="form w-100">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">{{ __('Créer un compte') }}</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">
                            {{ __('Déjà inscrit ?') }}
                            <a href="{{ route('login') }}" class="link-primary fw-bold">
                                {{ __('Se connecter') }}
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

                    <!--begin::Input group - Name-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bold text-dark">{{ __('Nom complet') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text"
                            class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                            wire:model.defer="name" placeholder="Jean Dupont" autocomplete="name" />
                        <!--end::Input-->
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group - Username-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bold text-dark">{{ __('Nom d\'utilisateur') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text"
                            class="form-control form-control-lg form-control-solid @error('username') is-invalid @enderror"
                            wire:model.defer="username" placeholder="johndoe" autocomplete="username" />
                        <!--end::Input-->
                        @error('username')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group - Email-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bold text-dark">{{ __('Adresse email') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email"
                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            wire:model.defer="email" placeholder="nom@exemple.fr" autocomplete="email" />
                        <!--end::Input-->
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group - Password-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-bold text-dark fs-6 mb-2">{{ __('Mot de passe') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password"
                            class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                            wire:model.defer="password" placeholder="••••••••" autocomplete="new-password" />
                        <!--end::Input-->
                        <div class="form-text mt-2">{{ __('Minimum 8 caractères') }}</div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group - Confirm Password-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label
                            class="form-label fw-bold text-dark fs-6 mb-2">{{ __('Confirmer le mot de passe') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password"
                            class="form-control form-control-lg form-control-solid @error('password_confirmation') is-invalid @enderror"
                            wire:model.defer="password_confirmation" placeholder="••••••••"
                            autocomplete="new-password" />
                        <!--end::Input-->
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Checkbox - Terms-->
                    <div class="fv-row mb-10">
                        <div class="form-check form-check-custom form-check-solid">
                            <input type="checkbox" class="form-check-input" id="kt_register_agree" required />
                            <label class="form-check-label fw-semibold text-gray-700 fs-6" for="kt_register_agree">
                                {{ __('J\'accepte les') }}
                                <a href="#" class="ms-1 link-primary">{{ __('conditions d\'utilisation') }}</a>
                            </label>
                        </div>
                    </div>
                    <!--end::Checkbox-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5" wire:loading.attr="disabled">
                            <span class="indicator-label">
                                {{ __('Créer un compte') }}
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
<!--end::Authentication - Sign-up-->
