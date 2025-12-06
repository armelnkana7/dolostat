{{-- 
    Modale de confirmation réutilisable Bootstrap 5 (Saul theme)
    Accepte : id, title, message, confirmEvent, confirmPayload (id ou données)
    Émet un événement Livewire 'confirmed' avec le payload après confirmation
--}}

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fs-3 fw-bold" id="confirmModalLabel">
                    <span id="confirmTitle">Confirmation</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage" class="text-muted fs-6 mb-0">
                    Êtes-vous sûr de cette action ?
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Annuler
                </button>
                <button type="button" class="btn btn-danger" id="confirmButton" wire:click="">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'), {
            backdrop: 'static',
            keyboard: false
        });
        const confirmBtn = document.getElementById('confirmButton');
        let currentData = null;

        // Écouter l'événement Livewire 'openConfirm' pour ouvrir la modale
        if (window.Livewire) {
            window.Livewire.on('openConfirm', (data) => {
                currentData = data;
                document.getElementById('confirmTitle').textContent = data.title || 'Confirmation';
                document.getElementById('confirmMessage').textContent = data.message ||
                    'Êtes-vous sûr ?';

                // Définir l'action du bouton confirmer
                confirmBtn.onclick = () => {
                    // Dispatcher l'événement Livewire avec le payload
                    window.Livewire.dispatch('confirmed', {
                        event: data.event || 'deleteConfirmed',
                        model: data.model || null,
                        id: data.id || null,
                        payload: data.payload || null
                    });
                    // Cacher la modale proprement
                    setTimeout(() => {
                        modal.hide();
                    }, 100);
                };

                modal.show();
            });

            // Nettoyer les backdrops orphelins à la fermeture
            document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
                // Supprimer tous les backdrops parasites
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                    backdrop.remove();
                });
                // S'assurer que le body permet le scroll
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        }
    });
</script>
