<?php

namespace App\Livewire\Departments;

use App\Models\Subject;
use App\Services\DepartmentService;
use Livewire\Component;

/**
 * Departments Form Component
 */
class Form extends Component
{
    public $departmentId = null;
    public $establishment_id = null;
    public $name = '';
    public $description = '';
    public $selectedSubjects = []; // Matières sélectionnées
    public $availableSubjects = []; // Matières disponibles pour sélection
    public $returnUrl = null;

    protected function rules()
    {
        return [
            'establishment_id' => 'required|exists:establishments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'selectedSubjects' => 'array',
            'selectedSubjects.*' => 'exists:subjects,id',
        ];
    }

    public function mount(DepartmentService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('departments.index');

        // Charger toutes les matières disponibles pour l'établissement
        $this->loadAvailableSubjects();

        if ($id) {
            $department = $service->find($id);
            if ($department) {
                $this->departmentId = $department->id;
                $this->establishment_id = $department->establishment_id;
                $this->name = $department->name;
                $this->description = $department->description;
                // Charger les matières déjà associées
                $this->selectedSubjects = $department->subjects()
                    ->pluck('id')
                    ->toArray();
            }
        }
    }

    public function loadAvailableSubjects()
    {
        // Charger toutes les matières de l'établissement qui ne sont pas assignées à d'autres départements
        // ou les matières assignées au département courant (en édition)
        $this->availableSubjects = Subject::where('establishment_id', $this->establishment_id)
            ->where(function ($query) {
                $query->whereNull('department_id')
                    ->orWhere('department_id', $this->departmentId);
            })
            ->pluck('name', 'id')
            ->toArray();
    }

    public function save(DepartmentService $service)
    {
        $this->validate();

        if ($this->departmentId) {
            $service->update($this->departmentId, [
                'establishment_id' => $this->establishment_id,
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Mettre à jour les matières associées
            $this->updateDepartmentSubjects($service);

            $this->dispatch('notify', message: 'Département mis à jour avec succès');
        } else {
            $department = $service->create([
                'establishment_id' => $this->establishment_id,
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Associer les matières sélectionnées
            $this->attachSubjectsToDepartment($department->id);

            $this->dispatch('notify', message: 'Département créé avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    private function updateDepartmentSubjects(DepartmentService $service)
    {
        $department = $service->find($this->departmentId);

        // Détacher toutes les matières
        $department->subjects()->update(['department_id' => null]);

        // Attacher les nouvelles matières sélectionnées
        if (!empty($this->selectedSubjects)) {
            Subject::whereIn('id', $this->selectedSubjects)
                ->update(['department_id' => $this->departmentId]);
        }
    }

    private function attachSubjectsToDepartment($departmentId)
    {
        if (!empty($this->selectedSubjects)) {
            Subject::whereIn('id', $this->selectedSubjects)
                ->update(['department_id' => $departmentId]);
        }
    }

    public function render()
    {
        return view('livewire.departments.form', [
            'availableSubjects' => $this->availableSubjects,
        ]);
    }
}
