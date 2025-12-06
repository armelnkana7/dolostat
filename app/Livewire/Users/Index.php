<?php

namespace App\Livewire\Users;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\UserService;
use Livewire\Component;

/**
 * Users Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppressions avec modale de confirmation.
 * TODO: Vérifier les permissions via policies (seuls les admins peuvent supprimer)
 * TODO: Vérifier que l'utilisateur ne supprime pas son propre compte
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $search = '';
    public $perPage = 15;
    public $returnUrl = null;
    protected UserService $userService;

    public function boot(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * Supprime un utilisateur après confirmation
     * TODO: Implémenter la vérification des permissions (admin only)
     * TODO: Implémenter la vérification pour éviter auto-suppression
     * 
     * @param mixed $id Identifiant de l'utilisateur
     */
    public function delete($id)
    {
        try {
            $this->userService->delete($id);
            $this->toastSuccess('Utilisateur supprimé avec succès', 'Utilisateur supprimé');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('users.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $users = $this->userService->list(
            [
                'search' => $this->search,
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
            ],
            ['establishment', 'department']
        );

        return view('livewire.users.index', compact('users'));
    }
}
