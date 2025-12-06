<?php

namespace App\Livewire\Subjects;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\SubjectService;
use Livewire\Component;

/**
 * Subjects Index Component
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
    protected SubjectService $subjectService;

    public function boot(SubjectService $service)
    {
        $this->subjectService = $service;
    }

    /**
     * Supprime une matière après confirmation
     * TODO: Implémenter la vérification des permissions
     * TODO: Implémenter la vérification des programmes associés
     * 
     * @param mixed $id Identifiant de la matière
     */
    public function delete($id)
    {
        try {
            $this->subjectService->delete($id);
            $this->toastSuccess('Matière supprimée avec succès', 'Matière supprimée');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('subjects.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $subjects = $this->subjectService->list(
            [
                'search' => $this->search,
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
            ],
            ['establishment', 'department']
        );

        return view('livewire.subjects.index', compact('subjects'));
    }
}
