<?php

/**
 * EXEMPLE D'INTÉGRATION DU SYSTÈME DE CONFIRMATION DE SUPPRESSION
 * 
 * Ce fichier montre comment intégrer le système de modale de confirmation 
 * dans vos composants Livewire pour les opérations de suppression sécurisées.
 * 
 * ============================================================================
 * 1. ÉTAPES D'INTÉGRATION
 * ============================================================================
 * 
 * ÉTAPE 1 : Ajouter le trait au composant
 * ----------------------------------------
 * use App\Livewire\Traits\WithConfirmDelete;
 * 
 * class YourIndexComponent extends Component
 * {
 *     use WithConfirmDelete;
 *     ...
 * }
 * 
 * 
 * ÉTAPE 2 : Implémenter la méthode delete($id)
 * -----------------------------------------------
 * public function delete($id)
 * {
 *     // Valider les permissions
 *     $this->authorize('delete', Model::findOrFail($id));
 *     
 *     // Vérifier le scope (établissement, etc.)
 *     $item = Model::where('establishment_id', session('establishment_id'))
 *                   ->findOrFail($id);
 *     
 *     // Supprimer
 *     $item->delete();
 *     
 *     // Notifier
 *     $this->dispatch('notify', message: 'Ressource supprimée avec succès');
 *     
 *     // Rafraîchir la liste
 *     $this->dispatch('refresh');
 * }
 * 
 * 
 * ÉTAPE 3 : Utiliser la partial dans la vue index
 * --------------------------------------------------
 * <table class="table align-middle table-row-dashed fs-6 gy-5">
 *     <tbody>
 *         @forelse($items as $item)
 *             <tr>
 *                 <td>{{ $item->name }}</td>
 *                 <td class="text-end">
 *                     @include('components.table-actions', [
 *                         'editRoute' => 'items.edit',
 *                         'id' => $item->id,
 *                         'modelName' => 'ItemModel',
 *                         'modelLabel' => 'item'
 *                     ])
 *                 </td>
 *             </tr>
 *         @empty
 *             <tr>
 *                 <td colspan="2" class="text-center text-muted py-4">Aucun item trouvé</td>
 *             </tr>
 *         @endforelse
 *     </tbody>
 * </table>
 * 
 * 
 * ============================================================================
 * 2. FLUX COMPLET DE SUPPRESSION
 * ============================================================================
 * 
 * 1. Utilisateur clique sur "Supprimer" → wire:click émet 'openConfirm'
 * 2. JavaScript reçoit 'openConfirm' et affiche la modale Bootstrap
 * 3. Utilisateur clique "Confirmer" → modale émet 'confirmed' avec payload
 * 4. Livewire reçoit 'confirmed' → appelle handleConfirmedDelete() du trait
 * 5. handleConfirmedDelete() appelle delete($id)
 * 6. delete() exécute la suppression et rafraîchit la liste
 * 
 * 
 * ============================================================================
 * 3. SÉCURITÉ À VÉRIFIER
 * ============================================================================
 * 
 * ✓ Autorisation : Utiliser les policies Laravel (@can ou authorize())
 * ✓ Scope : Vérifier que la ressource appartient à l'établissement de l'utilisateur
 * ✓ Validation : Vérifier les conditions métier avant suppression (ex: pas de dépendances)
 * ✓ Audit : Logger les suppressions pour traçabilité
 * 
 * 
 * ============================================================================
 * 4. EXEMPLE COMPLET : SchoolClasses
 * ============================================================================
 * 
 * namespace App\Livewire\SchoolClasses;
 * 
 * use App\Livewire\Traits\WithConfirmDelete;
 * use App\Models\SchoolClass;
 * use App\Services\SchoolClassService;
 * use Livewire\Component;
 * 
 * class Index extends Component
 * {
 *     use WithConfirmDelete;
 *     
 *     public $search = '';
 *     public $perPage = 15;
 *     public $department_id = null;
 *     
 *     protected SchoolClassService $service;
 *     
 *     public function boot(SchoolClassService $service)
 *     {
 *         $this->service = $service;
 *     }
 *     
 *     public function delete($id)
 *     {
 *         // Vérifier la permission (via Gate ou Policy)
 *         $this->authorize('delete', SchoolClass::class);
 *         
 *         // Récupérer et vérifier le scope establishment
 *         $class = SchoolClass::where('establishment_id', session('establishment_id'))
 *                              ->findOrFail($id);
 *         
 *         // Vérifier les dépendances (ex: pas de programmes associés)
 *         // if ($class->programs()->exists()) {
 *         //     throw new \Exception('Cette classe a des programmes associés.');
 *         // }
 *         
 *         // Supprimer via le service
 *         $this->service->delete($id);
 *         
 *         // Notification
 *         $this->dispatch('notify', 
 *             type: 'success', 
 *             message: 'Classe supprimée avec succès'
 *         );
 *         
 *         // Rafraîchir
 *         $this->dispatch('refresh');
 *     }
 *     
 *     public function render()
 *     {
 *         $establishmentId = session('establishment_id') ?? auth()->user()->establishment_id;
 *         $schoolClasses = $this->service->list([
 *             'search' => $this->search,
 *             'per_page' => $this->perPage,
 *             'establishment_id' => $establishmentId,
 *             'department_id' => $this->department_id,
 *         ], ['establishment', 'department']);
 *         
 *         return view('livewire.school-classes.index', compact('schoolClasses'));
 *     }
 * }
 * 
 * 
 * ============================================================================
 * 5. ÉVÉNEMENTS LIVEWIRE UTILISÉS
 * ============================================================================
 * 
 * - openConfirm(data)
 *   Émet depuis le bouton suppression de la vue
 *   Data: { model, id, title, message, event }
 * 
 * - confirmed(data)
 *   Reçu après confirmation utilisateur
 *   Déclenche handleConfirmedDelete() qui appelle delete($id)
 * 
 * - refresh
 *   Listener qui rafraîchit le composant
 * 
 * - notify
 *   Dispatche une notification (succès/erreur)
 * 
 * 
 * ============================================================================
 * 6. NOTES IMPORTANTES
 * ============================================================================
 * 
 * - Le trait fournit handleConfirmedDelete() automatiquement
 * - Vous DEVEZ implémenter la méthode delete($id) dans votre composant
 * - Les suppressions doivent toujours vérifier les permissions et le scope
 * - Utilisez les services pour la logique métier complexe
 * - Loguez les actions critiques pour audit
 * 
 */

namespace App\Livewire\Examples;

// Ce fichier est une documentation, pas du code exécutable.
// Consultez les exemples ci-dessus pour intégrer le système de confirmation.
