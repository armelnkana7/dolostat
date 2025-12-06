<?php

namespace App\Livewire\SchoolClasses;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\SchoolClassService;
use Livewire\Component;

/**
 * SchoolClasses Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppressions avec modale de confirmation.
 * TODO: Vérifier les permissions via policies
 * TODO: Vérifier les dépendances (ex: programmes associés) avant suppression
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $search = '';
    public $perPage = 15;
    public $returnUrl = null;
    protected SchoolClassService $schoolClassService;

    public function boot(SchoolClassService $service)
    {
        $this->schoolClassService = $service;
    }

    /**
     * Supprime une classe après confirmation
     * TODO: Implémenter la vérification des permissions
     * TODO: Implémenter la vérification des programmes associés
     * 
     * @param mixed $id Identifiant de la classe
     */
    public function delete($id)
    {
        try {
            $this->schoolClassService->delete($id);
            $this->toastSuccess('Classe supprimée avec succès', 'Classe supprimée');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('school-classes.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $schoolClasses = $this->schoolClassService->list(
            [
                'search' => $this->search,
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
            ]
        );

        return view('livewire.school-classes.index', compact('schoolClasses'));
    }
}
