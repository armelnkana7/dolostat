<?php

namespace App\Livewire\SchoolClasses;

use App\Models\Department;
use App\Services\SchoolClassService;
use Livewire\Component;

/**
 * SchoolClasses Form Component
 */
class Form extends Component
{
    public $schoolClassId = null;
    public $establishment_id = null;
    public $department_id = null;
    public $name = '';
    public $level = '';
    public $description = '';
    public $returnUrl = null;

    protected function rules()
    {
        return [
            'establishment_id' => 'required|exists:establishments,id',
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }

    public function mount(SchoolClassService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('school-classes.index');

        if ($id) {
            $schoolClass = $service->find($id);
            if ($schoolClass) {
                $this->schoolClassId = $schoolClass->id;
                $this->establishment_id = $schoolClass->establishment_id;
                $this->name = $schoolClass->name;
                $this->level = $schoolClass->level;
                $this->description = $schoolClass->description;
            }
        }
    }

    public function save(SchoolClassService $service)
    {
        $this->validate();

        if ($this->schoolClassId) {
            $service->update($this->schoolClassId, [
                'establishment_id' => $this->establishment_id,
                'name' => $this->name,
                'level' => $this->level,
                'description' => $this->description,
            ]);
            $this->dispatch('notify', message: 'Classe mise à jour avec succès');
        } else {
            $service->create([
                'establishment_id' => $this->establishment_id,
                'name' => $this->name,
                'level' => $this->level,
                'description' => $this->description,
            ]);
            $this->dispatch('notify', message: 'Classe créée avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        return view('livewire.school-classes.form');
    }
}
