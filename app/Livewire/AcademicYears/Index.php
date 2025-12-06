<?php

namespace App\Livewire\AcademicYears;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\AcademicYearService;
use Livewire\Component;

/**
 * AcademicYears Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppressions avec modale de confirmation.
 * TODO: Vérifier les permissions via policies
 * TODO: Vérifier que l'année académique n'est pas active avant suppression
 * TODO: Vérifier les dépendances (programmes, rapports, etc.) avant suppression
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $search = '';
    public $perPage = 15;
    public $returnUrl = null;
    protected AcademicYearService $academicYearService;

    public function boot(AcademicYearService $service)
    {
        $this->academicYearService = $service;
    }

    /**
     * Supprime une année académique après confirmation
     * TODO: Implémenter la vérification des permissions
     * TODO: Implémenter la vérification qu'elle n'est pas active
     * TODO: Implémenter la vérification des dépendances
     * 
     * @param mixed $id Identifiant de l'année académique
     */
    public function delete($id)
    {
        try {
            $this->academicYearService->delete($id);
            $this->toastSuccess('Année académique supprimée avec succès', 'Année supprimée');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('academic-years.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $academicYears = $this->academicYearService->list(
            [
                'search' => $this->search,
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
            ],
            ['establishment']
        );

        return view('livewire.academic-years.index', compact('academicYears'));
    }
}
