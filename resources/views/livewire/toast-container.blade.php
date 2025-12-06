{{-- 
    Conteneur global pour les toasts utilisant toastr.js
    Inclure dans le layout : @livewire('toast-container')
    
    Les toasts sont affichés via JavaScript toastr.js avec configuration prédéfinie
--}}

<script>
    // Configuration toastr.js globale
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Fonction globale pour afficher un toast
    window.showToast = function(type, message, title = '') {
        if (typeof toastr !== 'undefined' && toastr[type]) {
            toastr[type](message, title);
        }
    };
</script>

{{-- Ancien système - à supprimer après migration --}}
<div class="d-none">
    @foreach ([] as $toast)
        <div wire:key="toast-{{ $toast['id'] }}"
            class="alert alert-{{ $toast['type'] === 'error' ? 'danger' : $toast['type'] }} alert-dismissible fade show d-flex gap-2"
            role="alert" style="min-width: 350px; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);">

            {{-- Icône --}}
            <div class="flex-shrink-0">
                @if ($toast['type'] === 'success')
                    <i class="ki-duotone ki-check-circle fs-2 text-success">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                @elseif($toast['type'] === 'error')
                    <i class="ki-duotone ki-cross-circle fs-2 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                @elseif($toast['type'] === 'warning')
                    <i class="ki-duotone ki-information-5 fs-2 text-warning">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                @else
                    <i class="ki-duotone ki-notification-status fs-2 text-info">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                @endif
            </div>

            {{-- Contenu --}}
            <div class="flex-grow-1">
                <strong class="d-block fs-6">{{ $toast['title'] }}</strong>
                <span class="text-muted fs-7">{{ $toast['message'] }}</span>
            </div>

            {{-- Bouton fermeture --}}
            <button type="button" class="btn-close" wire:click="removeToast('{{ $toast['id'] }}')" aria-label="Fermer"
                style="align-self: start; margin-top: -3px;">
            </button>

            {{-- Barre de progression (si timeout > 0) --}}
            @if ($toast['timeout'] > 0)
                <div class="progress"
                    style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; border-radius: 0;">
                    <div class="progress-bar bg-{{ $toast['type'] === 'error' ? 'danger' : $toast['type'] }}"
                        style="width: 100%; animation: shrink {{ $toast['timeout'] / 1000 }}s linear forwards;">
                    </div>
                </div>
                <style>
                    @keyframes shrink {
                        from {
                            width: 100%;
                        }

                        to {
                            width: 0%;
                        }
                    }
                </style>
            @endif
        </div>
    @endforeach
</div>

<script>
    // Auto-fermer les toasts avec timeout
    document.addEventListener('livewire:updated', function() {
        const toasts = document.querySelectorAll('[role="alert"]');
        toasts.forEach(toast => {
            const toastId = toast.getAttribute('wire:key')?.replace('toast-', '');
            if (toastId) {
                // Vérifier si le toast a une animation de progression
                const progressBar = toast.querySelector('.progress-bar');
                if (progressBar) {
                    const duration = parseFloat(progressBar.style.animation.match(/[\d.]+/)[0]);
                    if (duration > 0) {
                        setTimeout(() => {
                            // Le composant supprimera le toast après l'animation
                        }, duration * 1000);
                    }
                }
            }
        });
    });
</script>
