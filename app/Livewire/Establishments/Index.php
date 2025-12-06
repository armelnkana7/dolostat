<?php

namespace App\Livewire\Establishments;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\EstablishmentService;
use Livewire\Component;

/**
 * Establishments Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppions avec modale de confirmation.
 * Les suppressions sont écoutées via l'événement Livewire 'confirmed' qui déclenche la méthode delete().
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $search = '';
    public $perPage = 15;
    public $returnUrl = null;
    protected EstablishmentService $establishmentService;

    public function boot(EstablishmentService $service)
    {
        $this->establishmentService = $service;
    }

    /**
     * Supprime un établissement après confirmation
     * 
     * @param mixed $id Identifiant de l'établissement
     * @return void
     */
    public function delete($id)
    {
        // TODO: Vérifier les permissions (policy)
        // TODO: Vérifier que l'établissement appartient à l'utilisateur autorisé

        try {
            $this->establishmentService->delete($id);
            $this->toastSuccess('Établissement supprimé avec succès', 'Établissement supprimé');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('establishments.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    /**
     * Rafraîchit la liste des établissements
     */
    public function refresh()
    {
        $this->dispatch('refresh');
    }

    public function render()
    {
        $establishments = $this->establishmentService->list(
            ['search' => $this->search, 'per_page' => $this->perPage],
            []
        );

        return view('livewire.establishments.index', compact('establishments'));
    }
}
