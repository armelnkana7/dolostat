{{-- 
    Script d'intégration Livewire pour la modale de confirmation Bootstrap 5
    
    Ce script établit le lien entre :
    - Les boutons wire:click qui émettent 'openConfirm'
    - La modale Bootstrap
    - Les événements Livewire 'confirmed'
    
    Placement : À inclure dans le layout après les @livewireScripts
--}}

<script>
    /**
     * Gestion de la modale de confirmation avec Livewire 3
     * 
     * Flux :
     * 1. Un bouton émet wire:click="$emit('openConfirm', data)"
     * 2. Ce script écoute 'openConfirm' et remplit/affiche la modale
     * 3. Utilisateur clique "Confirmer"
     * 4. Modale émet 'confirmed' via Livewire
     * 5. Le composant Livewire reçoit 'confirmed' et appelle delete()
     */

    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser la modale Bootstrap
        const modalElement = document.getElementById('confirmModal');
        if (!modalElement) {
            console.warn('confirmModal element not found in DOM');
            return;
        }

        const modal = new bootstrap.Modal(modalElement);
        const confirmTitle = document.getElementById('confirmTitle');
        const confirmMessage = document.getElementById('confirmMessage');
        const confirmButton = document.getElementById('confirmButton');

        let currentPayload = null;

        // Écouter l'événement Livewire 'openConfirm' pour afficher la modale
        if (window.Livewire) {
            window.Livewire.on('openConfirm', (data) => {
                // Remplir la modale avec les données
                confirmTitle.textContent = data.title || 'Confirmation';
                confirmMessage.textContent = data.message || 'Êtes-vous sûr de cette action ?';

                // Stocker le payload pour la confirmation
                currentPayload = {
                    event: data.event || 'deleteConfirmed',
                    model: data.model || null,
                    id: data.id || null,
                    payload: data.payload || null
                };

                // Mettre à jour le bouton de confirmation
                confirmButton.onclick = () => {
                    modal.hide();

                    // Émettre l'événement de confirmation à Livewire
                    window.Livewire.emit('confirmed', currentPayload);
                };

                // Afficher la modale
                modal.show();
            });

            // Nettoyer après fermeture de la modale
            modalElement.addEventListener('hidden.bs.modal', () => {
                currentPayload = null;
                confirmButton.onclick = null;
            });
        }
    });
</script>
