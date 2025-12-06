<?php

namespace App\Livewire\Examples;

use Livewire\Component;

/**
 * Exemple d'utilisation du système de toasts global
 * 
 * Le système de toasts est maintenant centralisé et globalement accessible
 * via le trait WithToasts dans tous les composants Livewire
 * 
 * ===================================
 * 1. SETUP INITIAL
 * ===================================
 * 
 * Le composant ToastContainer est inclus dans le layout (resources/views/layouts/saul.blade.php):
 * @livewire('toast-container')
 * 
 * Les composants qui veulent utiliser les toasts doivent inclure le trait:
 * use App\Livewire\Traits\WithToasts;
 * 
 * Puis l'utiliser dans la classe:
 * class MyComponent extends Component {
 *     use WithToasts;
 * }
 * 
 * ===================================
 * 2. USAGE BASIQUE
 * ===================================
 * 
 * Success (succès):
 *     $this->toastSuccess('Votre message', 'Titre');
 *     $this->toastSuccess('Produit créé');  // Titre par défaut
 * 
 * Error (erreur):
 *     $this->toastError('Une erreur s\'est produite', 'Erreur');
 *     $this->toastError($e->getMessage());  // Titre par défaut
 * 
 * Warning (attention):
 *     $this->toastWarning('Attention, cette action est irréversible', 'Attention');
 * 
 * Info (information):
 *     $this->toastInfo('Voici une information', 'Info');
 * 
 * ===================================
 * 3. COMPARAISON AVANT/APRÈS
 * ===================================
 * 
 * AVANT (toastr direct):
 *     toastr.success(
 *         "Succès!",
 *         "Preview updated!",
 *         {timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
 *     );
 * 
 * APRÈS (via Livewire):
 *     $this->toastSuccess('Succès!', 'Preview updated!');
 * 
 * Les options (timeOut, closeButton, etc.) sont gérées automatiquement
 * par le composant ToastContainer Bootstrap 5
 * 
 * ===================================
 * 4. EXEMPLE COMPLET DANS UN COMPOSANT
 * ===================================
 * 
 * namespace App\Livewire\Products;
 * 
 * use App\Livewire\Traits\WithToasts;
 * use Livewire\Component;
 * 
 * class Create extends Component {
 *     use WithToasts;
 *     
 *     public function save() {
 *         try {
 *             Product::create($this->data);
 *             $this->toastSuccess('Produit créé avec succès', 'Créé');
 *             $this->redirect(route('products.index'));
 *         } catch (\Exception $e) {
 *             $this->toastError('Impossible de créer le produit: ' . $e->getMessage());
 *         }
 *     }
 * }
 * 
 * ===================================
 * 5. RÉSULTAT VISUEL
 * ===================================
 * 
 * Les toasts s'affichent en haut à droite de la page avec:
 * - Icône appropriée (✓, ✗, ⚠, ℹ)
 * - Titre et message
 * - Bouton de fermeture
 * - Barre de progression (si timeout > 0)
 * - Couleurs Bootstrap (success, danger, warning, info)
 * 
 * ===================================
 * 6. TIMEOUT PERSONNALISÉ
 * ===================================
 * 
 * Par défaut, timeout = 0 (pas de fermeture automatique)
 * Vous pouvez le personnaliser:
 * 
 *     $this->toastSuccess('Message', 'Titre', timeout: 3000);  // 3 secondes
 *     $this->toastError('Message', 'Titre', timeout: 5000);    // 5 secondes
 * 
 * ===================================
 * 7. FICHIERS CONCERNÉS
 * ===================================
 * 
 * Trait:
 *     app/Livewire/Traits/WithToasts.php
 * 
 * Composant:
 *     app/Livewire/ToastContainer.php
 * 
 * Vue:
 *     resources/views/livewire/toast-container.blade.php
 * 
 * Layout (inclut le composant):
 *     resources/views/layouts/saul.blade.php
 * 
 * ===================================
 * 8. AVANTAGES
 * ===================================
 * 
 * ✓ Pas de dépendance externe (Bootstrap 5 inclus)
 * ✓ Centralisé et réutilisable
 * ✓ Facile à intégrer dans tous les composants
 * ✓ Supporte success, error, warning, info
 * ✓ Interface cohérente Saul theme
 * ✓ Pas de JavaScript complexe à gérer
 * ✓ Évite toastr.js (dépendance JS)
 */
class ToastSystemExample extends Component
{
    public function render()
    {
        return view('livewire.examples.toast-system-example');
    }
}
