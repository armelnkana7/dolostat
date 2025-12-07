<?php

namespace App\Livewire\Programs;

use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use App\Services\ProgramService;
use Livewire\Component;

/**
 * Programs Index Component
 * 
 * Utilise le trait WithConfirmDelete pour gérer les suppressions avec modale de confirmation.
 * TODO: Vérifier les permissions via policies
 * TODO: Vérifier les dépendances (ex: rapports de couverture) avant suppression
 */
class Index extends Component
{
    use WithConfirmDelete, WithToasts;

    public $perPage = 15;
    public $classe_id = null;
    public $subject_id = null;
    public $returnUrl = null;
    protected ProgramService $programService;

    public function boot(ProgramService $service)
    {
        $this->programService = $service;
    }

    /**
     * Supprime un programme après confirmation
     * TODO: Implémenter la vérification des permissions
     * TODO: Implémenter la vérification des rapports de couverture associés
     * 
     * @param mixed $id Identifiant du programme
     */
    public function delete($id)
    {
        try {
            $this->programService->delete($id);
            $this->toastSuccess('Programme supprimé avec succès', 'Programme supprimé');
            // Capture URL before deletion and redirect
            $this->returnUrl = url()->previous() ?? route('programs.index');
            $this->redirect($this->returnUrl);
        } catch (\Exception $e) {
            $this->toastError('Erreur : ' . $e->getMessage(), 'Échec de la suppression');
        }
    }

    public function render()
    {
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        $departmentId = null;

        // If user has animator role, filter by their department
        if (auth()->user()->hasRole('animator')) {
            $departmentId = auth()->user()->department_id;
        }

        $programs = $this->programService->list(
            [
                'per_page' => $this->perPage,
                'establishment_id' => $establishmentId,
                'classe_id' => $this->classe_id,
                'subject_id' => $this->subject_id,
                'department_id' => $departmentId,
            ],
            ['establishment', 'schoolClass', 'subject', 'subject.department']
        );

        return view('livewire.programs.index', compact('programs'));
    }
}
