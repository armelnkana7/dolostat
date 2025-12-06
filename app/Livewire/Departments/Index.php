<?php

namespace App\Livewire\Departments;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\DepartmentService;
use Livewire\Component;

/**
 * Departments Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppressions avec modale de confirmation.
 * TODO: Vérifier les permissions via policies
 * TODO: Vérifier les dépendances (ex: classes associées) avant suppression
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $search = '';
    public $perPage = 15;
    public $returnUrl = null;
    protected DepartmentService $departmentService;

    public function boot(DepartmentService $service)
    {
        $this->departmentService = $service;
    }

    /**
     * Supprime un département après confirmation
     * 
     * TODO: Implémenter la vérification de permission
     * TODO: Implémenter la vérification des dépendances
     * TODO: Implémenter le logging/audit
     * 
     * @param mixed $id Identifiant du département
     */
    public function delete($id)
    {
        try {
            $this->departmentService->delete($id);
            $this->toastSuccess('Département supprimé avec succès', 'Département supprimé');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('departments.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $departments = $this->departmentService->list(
            [
                'search' => $this->search,
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
            ],
            ['establishment']
        );

        return view('livewire.departments.index', compact('departments'));
    }
}
